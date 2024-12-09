<!DOCTYPE html>
<?php
    session_start();
    include 'connection.php';
   
    if(isset($_POST['continue'])){ // note: change 'continue' 
        if(isset($_POST['email']) && isset($_POST['newp1']) && isset($_POST['newp2'])){
            if($_POST['newp1'] == $_POST['newp2']){
                $new_password = md5($_POST['newp2']);
                $email = $_POST['email'];
                $query = ("UPDATE users SET password='$new_password' WHERE eamil='$email'");
                $sql->query($query);
                // header("login.php");
            }
        }
    }
?>
<link rel="stylesheet" type="text/css" href="forgot_pword_style.css">
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="forgetpass.css">
</head>
<body>
    <div class='forgot'>
        <form method='post'>
            Email: <input type='text' name='email'><br/>
            New Password: <input type='text' name='newp1'><br/>
            Retype your new password: <input type='text' name='newp2'><br/>
        </form>
        <form method='post'>
            <input type='submit' name='continue' value='Continue'>
        </form>
        <div class="submit">
            <a href="login.php"><button type="submit" name="sbtn" class="button">Exit</button></a>
        </div>
    </div>
</body>
</html>
