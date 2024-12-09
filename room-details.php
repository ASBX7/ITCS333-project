<?php
session_start();

if (!isset($_SESSION["currentUser"])) {
    header("location:login.php");
    exit();
}

if (isset($_GET['id'])) {
    try {
        $rid = $_GET['id'];
        require('connection.php');

        // Get room details
        $sql = "SELECT * FROM room WHERE room_id=?";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $rid);
        $stmt->execute();

        // Get room details with class_type
        $sql2 = "SELECT * FROM room r JOIN class_type ct ON r.type = ct.type WHERE r.room_id = ?";
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute(array($rid));

        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Room Details</title>
        <link rel='stylesheet' href='styles/room-details.css'>
        <link rel='stylesheet' href='styles/header.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' integrity='sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==' crossorigin='anonymous' referrerpolicy='no-referrer'/>
        <link rel='stylesheet' href='styles/popup.css' />
        <link rel='stylesheet' href='styles/footer.css' />
        </head>
        <body>";

        // Header for user or admin
        if ($_SESSION["userType"] == "user") {
            echo "<header style='margin-bottom:0'>
            <img src='images/logo-7.jpg' alt='logo'>
            <form action='department.php' method='post'>
            <div class='header-search'>
            <select class='header-select' name='department' id='department'>
            <option value='all' selected hidden>Department</option>
            <option value='Information System (IS)'>Information System (IS)</option>
            <option value='Computer Science (CS)'>Computer Science (CS)</option>
            <option value='Computer Engineering (CE)'>Computer Engineering</option>
            </select>
            <input type='text' name='text' class='header-input' placeholder='Enter Room Number'/>
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
        } else {
            echo "<header>
            <img src='images/logo-7.jpg' alt='logo'>
            <form action='browsing-admin.php' method='post'>
            <div class='header-search'>
            <select class='header-select' name='department' id='department'>
            <option value='all' selected hidden>Department</option>
            <option value='Information System (IS)'>Information System (IS)</option>
            <option value='Computer Science (CS)'>Computer Science (CS)</option>
            <option value='Computer Engineering (CE)'>Computer Engineering</option>
            </select>
            <input type='text' name='text' class='header-input' placeholder='Enter Room Number'/>
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

        // If the room exists
        if ($stmt->rowCount() > 0 && $stmt2->rowCount() > 0) {
            $roomDetails = $stmt->fetch();
            $classDetails = $stmt2->fetch();
            extract($roomDetails);
            extract($classDetails);
            $room_pic = ($type == "Lab") ? "lab.png" : "class.png";

            echo "<div class='container'>
            <div class='up'>
            <div class='img'>
            <img src='images/$room_pic' alt='room pic' />
            </div>
            <div class='room-info'>
            <p><span class='title'>Location&nbsp:</span>&nbsp<span class='info'>$location</span></p>
            <p><span class='title'>Department&nbsp:</span>&nbsp<span class='info'>$department</span></p>
            <p><span class='title'>Room Type&nbsp:</span>&nbsp<span class='info'>$type</span></p>
            <p><span class='title'>Capacity&nbsp:</span>&nbsp<span class='info'>$capacity</span></p>
            <p><span class='title'>Equipments&nbsp:</span>&nbsp<span class='info'>$equipments</span></p>
            </div><!-- end of room-info -->
            </div><!-- end of up -->
            <div class='down'>
            <p><span class='title'>Time Slots:</span><br /></p><span class='info'>
            <div class='slots'>
            <form action='reserve-room.php' method='post'>
            <select name='timeslot' id='timeslot' required>
            <option value='not-selected' selected hidden>Select time slot</option>";

            // Query to get available time slots
            $sql3 = "SELECT time FROM available WHERE room_id = ?";
            $stmt3 = $db->prepare($sql3);
            $stmt3->execute([$rid]);

            // Get all available time slots
            $availableTimes = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            // Query to get reserved time slots for this room
            $sql_reserved = "SELECT time_slot FROM reserved_rooms WHERE room_id = ?";
            $stmt_reserved = $db->prepare($sql_reserved);
            $stmt_reserved->execute([$rid]);

            // Get all reserved time slots for this room
            $reservedTimes = $stmt_reserved->fetchAll(PDO::FETCH_ASSOC);

            // Create an array of reserved times for easy comparison
            $reservedTimesArray = array_column($reservedTimes, 'time_slot');

            // Generate the dropdown for available time slots
            foreach ($availableTimes as $timeRow) {
                $time = $timeRow['time'];
                // Only show the time slot if it's not reserved
                if (!in_array($time, $reservedTimesArray)) {
                    echo "<option value='$time'>$time</option>";
                }
            }

            echo "</select>
            <button type='submit' name='reservebut' class='btn' id='reservebutton'>Reserve</button>
            <input type='hidden' name='room_id' value='$rid'>
            </form>
            </span>
            </div><!-- end of slots -->";

            // Admin buttons
            if ($_SESSION["userType"] == "admin") {
                echo "<a href='delete-room.php?room=$room_id'><button type='submit' name='deletebut' class='btn'>Delete</button></a>
                <a href='updateRoom.php?id=$room_id'><button class='btn'>Update</button></a>";
            }

            echo "</div><!-- end of down -->
            </div><!-- end of container -->";
        }

        // Footer
        echo "<footer>
        <div class='left-footer'>
        <i class='fa-solid fa-circle-question'></i>
        <a href='contact-us.php'>contact us</a>
        </div>
        <div class='center'>
        <a href=''>Terms & Conditions</a>
        <p>|</p>
        <p>@2024 mark</p>
        <p>|</p>
        <a href=''>Privacy & Policy</a>
        </div>
        <div class='right-footer'>
        <i class='fa-solid fa-circle-info'></i>
        </div>
        </footer>
        <script src='script/pop-up.js'></script>
        <script src='script/header.js'></script>
        </body>
        </html>";

    } catch (PDOException $e) {
        die("Error " . $e->getMessage());
    }
}
?>
