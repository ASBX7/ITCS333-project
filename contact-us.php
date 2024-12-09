<?php
session_start();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact us page</title>
    <link rel="stylesheet" href="styles/contact-us.css">
        <link rel="stylesheet" href="styles/footer.css" />
        <link rel="stylesheet" href="styles/header.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
<body>
<?php
  if(isset($_SESSION["currentUser"])){
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
            <li><a href='Archived.php'>Delete</a></li>
            <li><a href='UserInformation.php'>My account</a></li>
            <div class='close-menu'><i class='fa fa-times'></i></div>
            </ul>
        </div>
    </nav>
</header>";
  }
}
  
  ?>






    <fieldset>

        

        <legend>Contact us</legend>
        
        <div class="container">

        <div class="contact-card">
            <i class="fa-solid fa-phone"></i>
            <div class="info0"><p>Phone</p></div>
                
                <div class="info1">
                    <p>+973 35557444</p>
                    <p>+973 17734909</p>  
            </div>
        </div>


        <div class="contact-card">
            <i class="fa-solid fa-envelope"></i>
            <div class="info3"><p>Emails</p></div>
            <div class="info2">
                <p>University@gmail.com</p> 
                <p>UniversityService@gmail.com</p> 
        </div>



        </div>
    
       </div>
    
    </fieldset>

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
