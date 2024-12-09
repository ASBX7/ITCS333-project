<?php
session_start();
if(!isset($_SESSION["currentUser"])||!($_SESSION["userType"]=="admin")){
  header("location:login.php");
}





include 'connection.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/adminstyle.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>
<body>
<header>
        <img src="images/logo-7.jpg" alt="logo">
        <form action="browsing-admin.php" method="post">
        <div class="header-search">
                <select class="header-select" name="department" id="department">
                <option value="all" selected hidden>Department</option>
                <option value="Information System (IS)">Information System (IS)</option>
                <option value="Computer Science (CS)">Computer Science (CS)</option>
                <option value="Computer Engineering (CE)">Computer Engineering</option>
               
                </select>
                <input
                type="text"
                name="text"
                class="header-input"
                placeholder="Enter Room Number"
                />
                <button type="submit" class="header-search-btn" name="btn">
                <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>

        <nav>
            <div class="open-menu"><i class="fa fa-bars"></i></div>
            <div class="main-menu">
                <ul>
                <li><a href="view-admin.php">Home</a></li>
                <li><a href="browsing-admin.php">Browse</a></li>
                <li><a href="addRoom.php">Add</a></li>
                <li><a href="reserved.php">Reserved</a></li>
                <li><a href="UserInformation.php">My account</a></li>
                <div class="close-menu"><i class="fa fa-times"></i></div>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        

        <fieldset id="right">
            <legend class="tit">Room Management</legend>
            <div class="sub2">
                <a href="addRoom.php"><div class="button">Add New Room</div></a>
                <a href="browsing-admin.php"><div class="button">Browse Rooms</div></a>
                <a href="archived.php"><div class="button">Deleted Room List</div></a>
                
            </div>
        </fieldset>

        
    </div>
   <footer>
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
    <script src="script/header.js"></script>
</body>
</html>
