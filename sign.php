<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Revolution&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/signup.css">
</head>
<body>
  <div class="container">
        <div class="side">
            <p class="welcmsg" id="wel">Welcome to IT College Room Reservation System <p>
            <p>Don't have an account?</p>
            <button type= "submit" name="login" class="login"><a href="login.php">Sign In</a></button>
        </div>
        <main>
          <div class="signup">
          <h1 class='register'>Sign Up</h1>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
 
            <div class="form">
            <form method="post">
            <div id="messageBox" style='visibility: hidden;'> 
                        <span id='message'></span>
                    </div>
              <div class="half">
              <div class="half-form">
                <div class="inputF" id="firstnameInput">
                  <input type="text" name='fname' class="input" placeholder="First name" ></div> 
                  <span id='fname' style='color:red;'></span> 
                <br>
                <div class="inputF" id="emailInput">
                  <input type="text" name='email'class="input" placeholder="E-mail" ></div>
                  <span id='email' style='color:red;'></span>
                <br>
                
                <div class="inputF" id="passwordInput">
                  <input type="password" name='password' class="input" placeholder="Password" ></div>
                
                <span id='pass' style='color:red;'></span>
                <br>

              </div> <!-- end of half-form div -->
              




              <div class="half-form">
                
                <div class="inputF" id="lastnameInput">
                <input type="text" name='lname'class="input" placeholder="Last name" > </div>
                <span id='lname' style='color:red;'></span>
                <br>

                
                
                
                <div class="inputF" id="phone">
                <input type="text" name='phone' class="input" placeholder="Phone"></div>
                <span id='phonenum' style='color:red;'></span>
                <br>
                <div class="inputF" id="conf-passwordInput">
                  <input type="password" name='conf-password' class="input" placeholder="Confirm Password" ></div>
                  <span id='con-pass' style='color:red;'></span>
                  <br>
                </div> <!-- end of half-form div -->

                <br>
          </div>
 
                <br>
                <div class="submit">
                <button name="sbtn">Sign Up</button>
                </div>
                </form>
                </div> 
        </main>
    </div>
</body>
</html>
 
 
 
<?php
require("connection.php");
 
if(isset($_POST["sbtn"]) ){
    $fname= $_POST["fname"];
    $lname= $_POST["lname"];
    $email=$_POST["email"];
    $password=$_POST["password"];
    $phone=$_POST["phone"];
    $confirm_pass = $_POST["conf-password"];
   
    $error = "";

    

    $stuEmail_RE = '/^[a-zA-Z0-9._%+-]+@stu\.uob\.edu\.bh$/';

    $instructorEmail_RE = '/^[a-z]+@uob\.edu\.bh$/';

    $fullName_RE = '/^[a-zA-Z\s]{3,50}$/';

    $phoneNum_RE = '/^(00973|\+973)?\s?(([36]\d{7})|(17\d{6}))$/';

    $password_RE = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%*\\-]{8,50}$/";
  


    //RE
    $student_re = '/^[a-zA-Z0-9._%+-]+@stu\.uob\.edu\.bh$/';
    $instructors_re = '/^[a-z]+@uob\.edu\.bh$/';
    $name_re = '/^[a-zA-Z\s]{3,50}$/';
    $admin_re = '/^[a-zA-Z0-9._%+-]+@admin\.uob\.edu\.bh$/';
    $password_re = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%*\\-]{8,50}$/";
    $print = false;

    if ($fname == "") {
      echo "<script>document.getElementById('fname').innerHTML='*  Name is required'; document.getElementById('firstnameInput').style.borderBottomColor = 'red';</script>";
      $print = true;
  }
  if ($lname == "") {
      echo "<script>document.getElementById('lname').innerHTML='* Required'; document.getElementById('lastnameInput').style.borderBottomColor = 'red';</script>";
      $print = true;
  }
  if ($email == "") {
    echo "<script>document.getElementById('email').innerHTML='* Required'; document.getElementById('emailInput').style.borderBottomColor = 'red';</script>";
    $print = true;
}
if ($password == "") {
    echo "<script>document.getElementById('pass').innerHTML='* Required'; document.getElementById('passwordInput').style.borderBottomColor = 'red';</script>";
    $print = true;
}
if ($phone == "") {
  echo "<script>document.getElementById('phonenum').innerHTML='* Required'; document.getElementById('phone').style.borderBottomColor = 'red';</script>";
  $print = true;
}
if ($confirm_pass == "") {
  echo "<script>document.getElementById('con-pass').innerHTML='* Required'; document.getElementById('conf-passwordInput').style.borderBottomColor = 'red';</script>";
  $print = true;
}

    


   /*  if ($password != $confirm_pass){
      $error= "Passwords you entered don't match <br>";
      

      } */
    if (!preg_match($student_re, $email) && !preg_match($instructors_re, $email)&& !preg_match($admin_re, $email)) 
    {
        $error .= "Invalid UoB email format <br>";
    }
 
    if (!preg_match($name_re, $fname )) 
    {
        $error .= "Names must contain letters/spaces only <br>";
    }else if (!preg_match($name_re, $lname)){
      $error .= " names must contain letters/spaces only <br>";
    }

 
    if (!preg_match($phoneNum_RE, $phone)) 
    {
        $error .= " Invalid phone number format. <br>";
    }
 
    if (!preg_match($password_RE, $password)) 
    {
        $error .= " Password must be 8-50 characters, include uppercase, lowercase, digit, and special character. <br>";
    }

    if($error == "") {

      $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();
 
        if ($emailExists) 
        {
            $error .= "This email is already registered. <br>";
        }

    }

      // If validation fails, display error message
      if ($error) 
      {
        echo "<script>document.getElementById('message').innerHTML='$error';
        document.getElementById('messageBox').style.visibility = 'visible';</script>";
    
      }
      else{

        if (preg_match($student_re, $email))
        {
          $userType = "user";

        }
        else $userType = "admin";

 
        $query="INSERT INTO users VALUES (null,:fname,:lname,:email,:password,:phone,null,:type,null)";
        $stmt=$db->prepare($query);
 
        $hps=password_hash($password, PASSWORD_DEFAULT);
 
        $stmt->bindParam(":fname",$fname);
        $stmt->bindParam(":lname",$lname);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":password",$hps);
        $stmt->bindParam(":phone",$phone);
        $stmt->bindParam(":type",$userType);
 
   
          if($stmt->execute()){
            header("location: login.php");
            exit();
          }
          else{
            echo "unsucessfull registeration";
          }
 
        }
 
      
     
      
       
 
 
  
    }
?>

  