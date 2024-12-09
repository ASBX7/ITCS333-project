<?php
session_start();
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
                    placeholder='Enter book name'
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
                <li><a href='reserved.php'>Reserved</a></li>
                <li><a href="view-user.php">Browse</a></li>
                <li><a href="contact-us.php">Contact us</a></li>
                
                <li><a href="UserInformation.php">My account</a></li>
                <div class="close-menu"><i class="fa fa-times"></i></div>
                </ul>
            </div>
        </nav>
    </header>



<?php
$print=false;

    if(isset($_POST["btn"])){
        try
        {
        require('connection.php');
        if($_POST["department"]=="all"){
            $text=$_POST["text"];
            $text="%$text%";
            $sql="SELECT * FROM room WHERE location LIKE ? AND room_id NOT IN (SELECT room_id FROM deleted_rooms)";
            $result=$db->prepare($sql);
            $result->execute(array($text));
            $print=true;
        }
        else{
            $department=$_POST["department"];
            $text=$_POST["text"];
            $text="%$text%";
            $sql='SELECT * FROM room WHERE location LIKE ? AND department=? AND room_id NOT IN (SELECT room_id FROM deleted_rooms)';
                    
            $result=$db->prepare($sql);
            $result->execute(array($text,"$department"));
            $print=true;
        }

        $db=null;
    } catch(PDOEXCEPTION $e)
    {
    die($e->getMessage());
    }
    }

    if(isset($_GET['department'])){
        $c= $_GET['department'];
        try
        {
        require('connection.php');
        $sql="SELECT * FROM room WHERE department=:department AND room_id NOT IN (SELECT room_id FROM deleted_rooms)";
        $result=$db->prepare($sql);
        $result->bindParam(":department", $c);
        $result->execute();
        $print=true;
        $db=null;
        } catch(PDOEXCEPTION $e)
        {
        die($e->getMessage());
        }

    }
        if($print){
        $count = $result->rowCount();
            
        if($count > 0)
        { 
   
            echo "
            <div class='container'>
            ";
            $records = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach($records as $record)
            {
                extract($record);
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
                </div><!-- end of location-department div -->
                <a href= 'room-details.php?id=$room_id'><button class='btn'>View Room Details</button></a>
            </div><!-- end of class info -->

        </div><!-- end of class card -->
        ";

            }
        echo"</div><!-- end of container -->";
        }
  
    } 
?>

   
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
    <script src="script/pop-up.js"></script>
    </body>
    </html>

