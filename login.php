<?php
session_start();

// Email validation regex
$emailReg = "/^\w+@[a-z]+(\.[a-z]{2,5})+$/i";

// Form submission logic

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Revolution&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/login.css">
    <title>Login</title>
</head>

<body>  
    <div class="container">
        <div class="side">
        <p class="welcmsg" id="wel">Welcome to IT College Room Reservation System <p>
            <p>Don't have an account?</p>
            <button type= "submit" name="signup" class="signup"><a href="sign.php">Sign up</a></button>
 
        </div>
        <main>
            <div class="login">
                <h1 class='log'>Login</h1>
                <!-- login form -->
                <form method="post">
                    <div id="messageBox" style='visibility: hidden;'> 
                        <span id='message'></span>
                    </div>
                    <div class="inputF" id="emailInput">
                        <i class="fa-solid fa-user" id="userIcon"></i>
                        <input onfocus="emailChange(this)" onblur="emailReset(this)" type="text" class="input" placeholder="E-mail" name="email" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>">
                    </div>
                    <span id='email' style='color:red;'></span>
                    <div class="inputF" id="passwordInput">
                        <i class="fa-solid fa-lock" id="passIcon"></i>
                        <input onfocus="passChange(this)" onblur="passReset(this)" type="password" class="input" placeholder="Password" name="password" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                    </div>
                    <div class="field-group">
		                <div><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
		                <label for="remember-me">Remember me</label>
	                    </div>
                    <span id='pass' style='color:red;'></span>
                    <div class="submit">
                        <button type="submit" name="sbtn" class="button">login</button>
                    </div>
                </form>
                <div class="info">
                    <p>
                        <a href="">Contact us</a> 
                        <span>|</span>
                        <a href="">About us</a>
                        <span>|</span>
                        <a href="">Help</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
    <?php

    if (isset($_POST['sbtn'])) {
        require('connection.php');
      $print = false;
      $userEmail = trim($_POST['email']);
      $userPassword = trim($_POST['password']);

      $sql = "Select * from users where email ='$userEmail' and password ='$userPassword'";
     
      
      $result = $db->prepare($sql);
      $result->execute();
      $row = $result->fetch(PDO::FETCH_ASSOC);

              $_SESSION["user_Id"]= $row["user_Id"];
      // if remember me clicked . Values will be stored in $_COOKIE  array
              if(!empty($_POST["remember"])) {
            //COOKIES for email
            setcookie ("user_login",$_POST["email"],time()+ (10 * 365 * 24 * 60 * 60));
  //COOKIES for password
  setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
  } else {
  if(isset($_COOKIE["user_login"])) {
  setcookie ("user_login","");
  if(isset($_COOKIE["userpassword"])) {
  setcookie ("userpassword","");
                  }
              }
              if ($row["user_type"] == 'user') {
                header('Location: view-user.php');
                exit();
            } else if ($row["user_type"] == 'admin') {
                header('Location: view-admin.php');
                exit();
            } 
      }
      if ($userEmail == "") {
          echo "<script>document.getElementById('email').innerHTML='* E-mail is required'; document.getElementById('emailInput').style.borderBottomColor = 'red';</script>";
          $print = true;
      }
      if ($userPassword == "") {
          echo "<script>document.getElementById('pass').innerHTML='* Password is required'; document.getElementById('passwordInput').style.borderBottomColor = 'red';</script>";
          $print = true;
      }
      if (!$print) {
          // If the email is valid
          if (preg_match($emailReg, $userEmail)) {
              try {
                  require('connection.php');
                  $sql = "SELECT * FROM users WHERE email LIKE ?";
                  $result = $db->prepare($sql);
                  $result->execute(array($userEmail));
                  $db = null;
              } catch (PDOException $e) {
                  die($e->getMessage());
              }
  
              $count = $result->rowCount();
              $row = $result->fetch(PDO::FETCH_ASSOC);
              if ($count == 1) {
                  // Check if the password is valid
                  if (password_verify($userPassword, $row['password'])) {
                      $_SESSION['currentUser'] = $row["user_Id"];
                      $_SESSION['userType'] = $row["user_type"];
  
                      if ($row["user_type"] == 'user') {
                          header('Location: view-user.php');
                          exit();
                      } else if ($row["user_type"] == 'admin') {
                          header('Location: view-admin.php');
                          exit();
                      } 
                  } else {
                      echo "<script>document.getElementById('message').innerHTML='E-mail or password is not valid';
                                     document.getElementById('messageBox').style.visibility = 'visible'</script>";
                  }
              } else {
                  echo "<script>document.getElementById('message').innerHTML='E-mail or password is not valid';
                                    document.getElementById('messageBox').style.visibility = 'visible';</script>";
              }
          } else {
              echo "<script>document.getElementById('message').innerHTML='E-mail or password is not valid';
                            document.getElementById('messageBox').style.visibility = 'visible';</script>";
          }
      }
  
}
  
    
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Change the color of the icon and the underline when clicking on the input field
        function emailChange(input) {
            const element = document.getElementById('emailInput');
            const icon = document.getElementById('userIcon');
            element.style.borderBottomColor = '#a9856c';
            icon.style.color = '#a9856c';
        }

        function emailReset(input) {
            const element = document.getElementById('emailInput');
            const icon = document.getElementById('userIcon');
            element.style.borderBottomColor = '#757575';
            icon.style.color = '#757575';
        }
        
        function passChange(input) {
            const element = document.getElementById('passwordInput');
            const icon = document.getElementById('passIcon');
            element.style.borderBottomColor = '#a9856c';
            icon.style.color = '#a9856c';
        }

        function passReset(input) {
            const element = document.getElementById('passwordInput');
            const icon = document.getElementById('passIcon');
            element.style.borderBottomColor = '#757575';
            icon.style.color = '#757575';
        }
    </script>
</body>
</html>
