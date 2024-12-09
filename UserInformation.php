<?php
session_start();
if (isset($_SESSION['currentUser'])) {

    $uid = $_SESSION['currentUser'];
    try {
        require('connection.php');
        $sql = "SELECT * FROM users WHERE user_Id=?";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $uid);
        $rs = $stmt->execute();
        $db = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    if ($rs == 1) {
        $row = $stmt->fetch();
        extract($row);
    }

} else {
    header("location:login.php");
}


if (isset($_POST["update-btn"])) {

    try {
        $modalMessage = "";
        $showModal = false;
        require('connection.php');
        $db->beginTransaction();

        // Get updated values from the form
        $newFname = trim($_POST["First_Name"]);
        $newEmail = trim($_POST["Email"]);
        $newNum = trim($_POST["phone_number"]);
        $newLname = trim($_POST["Last_Name"]);
        $newpic = isset($_FILES["user_pic"]) ? $_FILES["user_pic"] : null;

        $counter = 0;
        $updatedValues = [];

        // Check for changes and prepare SQL updates
        if (!empty($newFname) && $newFname != $first_name) {
            $sql = "UPDATE users SET first_name=? WHERE user_Id=?";
            $result = $db->prepare($sql);
            $result->execute(array($newFname, $uid));
            $counter++;
            $updatedValues['first_name'] = $newFname;
        }

        if (!empty($newLname) && $newLname != $last_name) {
            $sql = "UPDATE users SET last_name=? WHERE user_Id=?";
            $result = $db->prepare($sql);
            $result->execute(array($newLname, $uid));
            $counter++;
            $updatedValues['last_name'] = $newLname;
        }

        if (!empty($newEmail) && $newEmail != $email) {
            $sql = "UPDATE users SET email=? WHERE user_Id=?";
            $result = $db->prepare($sql);
            $result->execute(array($newEmail, $uid));
            $counter++;
            $updatedValues['email'] = $newEmail;
        }

        if (!empty($newNum) && $newNum != $phone_number) {
            $sql = "UPDATE users SET phone_number=? WHERE user_Id=?";
            $result = $db->prepare($sql);
            $result->execute(array($newNum, $uid));
            $counter++;
            $updatedValues['phone_number'] = $newNum;
        }

        /* if (!empty($newAddress) && $newAddress != $address) {
            $sql = "UPDATE users SET address=? WHERE user_Id=?";
            $result = $db->prepare($sql);
            $result->execute(array($newAddress, $uid));
            $counter++;
            $updatedValues['address'] = $newAddress;
        } */

        if ($newpic && $newpic['size'] > 0) {
            $fileTmpPath = $newpic['tmp_name'];
            $fileName = $newpic['name'];
            $fileType = $newpic['type'];

            if (in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $imageData = file_get_contents($fileTmpPath);
                $sql = "UPDATE users SET user_pic=? WHERE user_Id=?";
                $result = $db->prepare($sql);
                $result->execute(array($imageData, $uid));
                $counter++;
                $updatedValues['user_pic'] = $newpic['name'];
            }
        }

        // If any changes were made, commit the transaction
        if ($counter != 0) {
            $db->commit();
            // Fetch updated user data
            $stmt = $db->prepare("SELECT * FROM users WHERE user_Id = ?");
            $stmt->execute([$uid]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Update the session variables with the updated user data
            $first_name = $user['first_name'];
            $last_name = $user['last_name'];
            $email = $user['email'];
            $phone_number = $user['phone_number'];
            /* $address = $user['address']; */
            $user_pic = $user['user_pic'];

            $modalMessage = "Your information has been updated successfully.";
            $showModal = true;
        } else {
            $modalMessage = "No changes were made.";
            $showModal = true;
        }

        $db = null;

    } catch (PDOException $e) {
        $db->rollBack();
        $modalMessage = "Error while updating your information.";
        $showModal = true;
    }
}

if (isset($_POST["logout-btn"])) {
    session_destroy();
    header("location:login.php");
}


if (isset($_POST['continue'])) {
    $modalMessage = "";
    $showModal = false;

    require('connection.php');
    $db->beginTransaction();

    if (isset($_POST['oldp']) && isset($_POST['newp1']) && isset($_POST['newp2'])) {
        $oldPassword = $_POST['oldp'];
        $password_re = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%*\\-]{8,50}$/";

        if ($_POST['newp1'] == $_POST['newp2'] && password_verify($oldPassword, $password)) {
            if (preg_match($password_re, $_POST['newp1'])) {
                $new_password = password_hash($_POST['newp2'], PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password=? WHERE user_Id=?";
                $result = $db->prepare($sql);
                $result->execute(array($new_password, $uid));
                $db->commit();

                $modalMessage = "Your password has been updated successfully!";
                $showModal = true;
            } else {
                $modalMessage = "New password must be between 8 and 50 characters and include uppercase, lowercase, digits, and special characters.";
                $showModal = true;
            }
        } else {
            $modalMessage = "Old password is incorrect or new passwords do not match!";
            $showModal = true;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/user-information.css">
    <link rel="stylesheet" href="styles/popup.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="styles/header.css">
    
     <link rel="stylesheet" href="styles/footer.css" />

  </head>
  <body>
    
  <?php
  if($_SESSION["userType"]=="user"){
    echo "  <header style='margin-bottom:0'>
    <img src='images/logo-7.jpg' alt='logo'>
    <form action='department.php' method='post'>
                <div class='header-search'>
                <select class='header-select' name='department' id='department'>
                <option value='all' selected hidden>Department</option>
                <option value='Information System (IS)'>Information System (IS)</option>
                <option value='Computer Science (CS)'>Computer Science (CS)</option>
                <option value='Computer Engineering (CE)'>Computer Engineering</option>
                    </select>
                    <input
                    type='text'
                    name='text'
                    class='header-input'
                    placeholder='Enter Room Number'
                    />
                    <button type='submit' class='header-search-btn' name='btn'>
                    <i class='fa-solid fa-magnifying-glass'></i>
                    </button>
                </div>
                </form>

    <nav>
        <div class='open-menu'><i class='fa fa-bars'></i></div>
        <div class='main-menu'>
            <ul>
            <li><a href='reserved.php'>Reserved</a></li>
            <li><a href='view-user.php'>Browse</a></li>
            <li><a href='contact-us.php'>Contact us</a></li>
            
            <li><a href='UserInformation.php'>My account</a></li>
            <div class='close-menu'><i class='fa fa-times'></i></div>
            </ul>
        </div>
    </nav>
</header>";
  }

  else {
    echo "  <header style='margin-bottom:0'>
    <img src='images/logo-7.jpg' alt='logo'>
     <form action='browsing-admin.php' method='post'>
                <div class='header-search'>
                <select class='header-select' name='department' id='department'>
                <option value='all' selected hidden>Department</option>
                <option value='Information System (IS)'>Information System (IS)</option>
                <option value='Computer Science (CS)'>Computer Science (CS)</option>
                <option value='Computer Engineering (CE)'>Computer Engineering</option>
                    </select>
                    <input
                    type='text'
                    name='text'
                    class='header-input'
                    placeholder='Enter Room Number'
                    />
                    <button type='submit' class='header-search-btn' name='btn'>
                    <i class='fa-solid fa-magnifying-glass'></i>
                    </button>
                </div>
                </form>


    <nav>
        <div class='open-menu'><i class='fa fa-bars'></i></div>
        <div class='main-menu'>
            <ul>
            <li><a href='view-admin.php'>Home</a></li>
            <li><a href='browsing-admin.php'>Browse</a></li>
            <li><a href='addRoom.php'>Add</a></li>
            <li><a href='reserved.php'>Reserved</a></li>
            
            <li><a href='UserInformation.php'>My account</a></li>
            <div class='close-menu'><i class='fa fa-times'></i></div>
            </ul>
        </div>
    </nav>
</header>";
  }
  
  ?>


    <main>

        <aside>
            <div class="t">
            <div class="userInfo titles" id="info">User Info</div>
            <div class="changePassword titles" id="pass">Change Password</div>
            
            
            </div>
            <div class="d">
            <form method="post" class="btn"><button name="logout-btn">Logout</button></form>
            </div>
        </aside>
        
   
        <div id="update-info">


        <form method="post" id="contactForm">

        <div class="container">
                    

        <div class="Half">

            <div>
                <label for="First_Name">First Name</label>
                <div class="input-icon">
                <input type="text" name="First_Name" id="First_Name"  class="disabled" value="<?php echo $first_name ?>">
                <i id="edit-fname" class="fa-regular fa-pen-to-square"></i>
            </div>
            </div>
            

            <div>
                <label> Email  </label>
                <div class="input-icon">
                <input type="email" name="Email"  id="Email" class="disabled" value="<?php echo $email?>">
                <i id="edit-email" class="fa-regular fa-pen-to-square"></i>
            </div>
            </div>

            <div class="num">
                <label for="Phopne mumber">Phone number</label>
                <div class="input-icon">
                
                <input title="number" class="n disabled" type="text" name="phone_number" id="phone_number"  value="<?php echo $phone_number?>">
                <i id="edit-num" class="fa-regular fa-pen-to-square"></i>
            </div>
            </div>


        </div>

        <div class="Half">

            <div>
                <label for="Last_Name">Last Name</label>
                <div class="input-icon">
                <input type="text" name="Last_Name" id="Last_Name"  class="disabled" value="<?php echo $last_name?>">
                <i id="edit-lname" class="fa-regular fa-pen-to-square"></i>
            </div>
            </div>


            <div>
                <label for="type">User Type</label>
                <div class="input-icon">
                <input title="address" type="text" name="type" id="type" required min="0" max="100"  class="disabled" value="<?php echo $user_type?>">
                
            </div>
            </div>

            <div class="pic">
                <label for="user_pic">Profile Picture</label>
                <div class="input-icon">
                                <input type="file" name="user_pic" id="user_pic" accept="image/*">
                                <?php if ($user_pic): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($user_pic); ?>" alt="Profile Picture" id="profile-img" />
                                <?php endif; ?>
                            </div>
                        </div>



        </div>
     </div>

            <div class="UpdateInformation">
            <button type="submit" class="btn" name="update-btn" id="openModal" >Update Information</button>
            </div>
  
    </form>

   </div>
   <div id="myModal" class="modal" style="<?php echo isset($showModal) && $showModal ? 'display:flex;' : 'display:none;'; ?>">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="modal-body">
        
        <p class="modal-message"><?php echo isset($modalMessage) ? $modalMessage : ''; ?></p>
      </div>
      <div class="modal-footer">
        <button id="closeModal">Close</button>
      </div>
    </div>
  </div>

    <div id="change-password">
   
        <form method='post' id="contactForm">
            <div class="pinput">Old password <br><input type='password' name='oldp'></div>
            <div class="pinput"> New Password <br> <input type='password' name='newp1'></div>
            <div class="pinput"> Retype your new password <br> <input type='password' name='newp2'></div>
            <div class="pbtn"> <button type='submit' name='continue' class="btn" id="openModal" value='Continue'>Submit</button></div>
        </form>

    </div>
    

    
    

       
            
        


    </main>


    <footer style="margin-top:0;">
      <div class="left-footer">
        <i class="fa-solid fa-circle-question"></i>
        <a href="contact-us.php">contact us</a>
      </div>
      <div class="center">
        <a href="">Terms & Conditions</a>
        <p>|</p>
        <p>@2024 mark</p>
        <p>|</p>
        <!-- <br /> -->
        <a href="">Privacy & Policy</a>
      </div>
      <div class="right-footer">
        <i class="fa-solid fa-circle-info"></i>
      </div>
    </footer>
<script src="script\pop-up.js"></script>
<script src="script\account.js"></script>
<script src="script\header.js"></script>
<script src="script\updateuser.js"></script>
</body>
</html>