<?php
session_start();
if(!isset($_SESSION["currentUser"])){
    header("location:login.php");
  }

  if(isset($_GET['id'])){
    $modalMessage="";
    $showModal = false;
    try {
        require("connection.php");

    $rid = $_GET['id'];
    $time= $_GET['time'] ;

    $sql = "Delete from reserved_rooms where room_id=? and time_slot=?";
    $rs=$db->prepare($sql);
    if($rs->execute(array($rid,$time))){
        $modalMessage = "The reservation cancelled succesfully";
        $showModal = true;  
    }
}
catch (PDOException $e) 
{
    die("Error " . $e->getMessage());
}}




?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title></title>
        <link rel="stylesheet" href="styles/department.css" />
        <link rel="stylesheet" href="styles/header.css">
        <link
                rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
                integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
                crossorigin="anonymous"
                referrerpolicy="no-referrer"
                />
        <link rel="stylesheet" href="styles/popup.css" />
        <link rel="stylesheet" href="styles/footer.css" />


    </head>
    <body>
 <!-- Pop up modal -->
 <div id="myModal" class="modal" style="<?php echo isset($showModal) && $showModal ? 'display:flex;' : 'display:none;'; ?>">
        <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body">
            <i class="fa-solid fa-circle-check icons"></i>
            <p class="modal-message"><?php echo isset($modalMessage) ? $modalMessage : ''; ?></p>
        </div>
        <div class="modal-footer">
            <button id="closeModal">Close</button>
        </div>
        </div>
    </div>
    <header>
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
<?php if ($_SESSION["userType"]=="user") 
        { echo"<nav>
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
    </header>";}
    else {echo"<nav>
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
                </header>";}?>

    <?php
        require('connection.php');
        $print=false;

        $user_id=$_SESSION["currentUser"];
        $sql = "select * from room r join reserved_rooms rr on r.room_id = rr.room_id where rr.user_id=? ";
        $rs=$db->prepare($sql);
        $rs->execute(array($user_id));


        $count = $rs->rowCount();

        

        if ($count > 0)
        {
            if($count > 0)
        { 
   
            echo "
            <div class='container'>
            ";
            $records = $rs->fetchAll(PDO::FETCH_ASSOC);
            foreach($records as $record)
            {
                extract($record);
                if($time_slot == "firstSlot") $time= '8:00 - 9:00';
                elseif($time_slot == "secondSlot") $time = '9:00 - 10:00';
                elseif($time_slot == "thirdSlot") $time = '10:00 - 11:00';
                elseif($time_slot == "fourthSlot") $time = '11:00 - 12:00';
                elseif($time_slot == "fifthSlot") $time = '12:00 - 13:00';
                elseif($time_slot == "sixthSlot") $time = '13:00 - 14:00';
                
                if ($type == "Lab")
                    $room_pic = "lab.png";
                else $room_pic = "class.png";


                echo"
                <div class='card'>
            <div class='img'>
                <img src='images/$room_pic' alt='room img'/>
            </div><!-- end of class img -->

            <div class='info'>
                <div class='location-department'>
                    <p >$location</p>
                    <p class ='department'> $department</p>
                    <p class ='time'> $time_slot</p>
                </div><!-- end of location-department div -->
                <a href= 'reserved.php?id=$room_id && time=$time_slot'><button class='btn'>Unreserve</button></a>
            </div><!-- end of class info -->

        </div><!-- end of class card -->
        ";

            }
        echo"</div><!-- end of container -->";
        }
        }

        

        ?>

   