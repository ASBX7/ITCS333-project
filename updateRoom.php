<?php
if(isset($_GET["id"])){
    
    $rid=$_GET["id"];
    try 
    {
        
        require('connection.php');
        $sql="SELECT * FROM room where room_id=?";
        $stmt=$db->prepare($sql);
        $rs=$stmt->execute(array($rid));
        $db=null;
    } catch(PDOEXCEPTION $e){
         die($e->getMessage());
    }

    if($rs==1 )
    {
        $row=$stmt->fetch();
        extract($row);

    }

}
else{
    die();
}
?>

<?php
if(isset($_POST['btn'])){
    $modelMessage="";
    $showModal= false;
    $update = false;



    try{
        require('connection.php');
        $newlocation = $_POST['location'];
        $newdepartment = $_POST['department'];
        $newtype = $_POST['room_type'];

        if($newlocation != $location){
            $sql= "update room set location=? where room_id=?";
            $result=$db->prepare($sql);
            $result->execute(array($newlocation,$room_id));
            $update= true;
        }


        if($newdepartment != $department){
            $sql= "update room set department=? where room_id=?";
            $result=$db->prepare($sql);
            $result->execute(array($newdepartment,$room_id));
            $update= true;
        }


        if($newtype != $type){
            $sql= "update room set type=? where room_id=?";
            $result=$db->prepare($sql);
            $result->execute(array($newtype,$room_id));
            $update= true;
        }






        if($update){
            $modalMessage = "Room updated .";
            $showModal = true;
        }
        $db=null;

    }
    catch (PDOException $e){
    
        die("Error " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
    <link rel="stylesheet" href="styles/updateRoom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/popup.css" />
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css" />
</head>
<body>
<header>
        <img src="images/logo-7.jpg" alt="logo">
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
            <div class="open-menu"><i class="fa fa-bars"></i></div>
            <div class="main-menu">
                <ul>
                <li><a href='view-admin.php'>Home</a></li>
                <li><a href="browsing-admin.php">Browse</a></li>
                <li><a href="addRoom.php">Add</a></li>
              <li><a href="reserved.php">Reserved</a></li>
                
              <li><a href="UserInformation.php">My account</a></li>
                <div class="close-menu"><i class="fa fa-times"></i></div>
                </ul>
            </div>
        </nav>
    </header>
    <fieldset>
        <legend>Update a Room</legend>
    
        <form method="post"  id="contactForm">

        <div class="container">
            

        <div class="Half">
            <div>
            <label for="location">Location (numbers only)</label>
            <div class="input-icon">
            <input type="text" name="location" id="location" value="<?php echo $location ?>">
            </div>
            </div>
        

            <div>
            <label for="department">
                Department
            </label>
            <div class="input-icon">
            <select name="department" id= "department" class="rtype" value='<?php echo $department ?>' >
        <?php
                try{
                    require('connection.php');
                    $sql = "select * from departments";
                    $rs = $db->prepare($sql);
                    $rs->execute();
                    $db = null;

                }
                catch (PDOException $e){
                    die($e->getMessage());
                }

                foreach($rs as $department){
                    $dep = $department['dep_name'];
                    echo "<option value='$dep'> $dep<?option>";
                }

                ?>
        </select>

            </div>
            </div>
        

        


            <div>
            

            <label for="roomType">Room Type</label>
            <div class="input-icon">
            <select name="room_type" id= "room_type" class="rtype" required>
                <?php
                try{
                    require('connection.php');
                    $sql = "select * from class_type";
                    $rs = $db->prepare($sql);
                    $rs->execute();
                    $db = null;

                }
                catch (PDOException $e){
                    die($e->getMessage());
                }

                foreach($rs as $type){
                    $roomtype = $type['type'];
                    echo "<option value='$roomtype'> $roomtype<?option>";
                }

                ?>
            </select>

            <!-- Pop up modal -->
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
         
            </div>
            </div>
            <!-- <select name="room_type" id= "room_type" class="rtype" required style="display: none" >
                 <?php
                /* try{
                    require('connection.php');
                    $sql = "select * from class_type";
                    $rs = $db->prepare($sql);
                    $rs->execute();
                    $db = null;

                }
                catch (PDOException $e){
                    die($e->getMessage());
                }

                foreach($rs as $type){
                    $roomtype = $type['type'];
                    echo "<option value='$roomtype'> $roomtype<?option>";
                }*/

                ?>
            </select>
             -->

        </div>
        </div>


        </div>
    

    
        <div class="addRoomButton">
        <button type="submit"  id="openModal" class="btn" name="btn">Modify The Room</button>
        </div>
        
    </form>

</fieldset>
    
</body>
</html>