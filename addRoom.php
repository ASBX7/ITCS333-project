<?php
session_start();
if(!isset($_SESSION["currentUser"]) || $_SESSION["userType"] == "user"){
    header("location:login.php");
}

if(isset($_POST['btn'])){
    $modalMessage = "";
    $showModal = false;
    try {
        require("connection.php");
        $db->beginTransaction();

        $loc_reg = '/^\d+$/';

        $location = $_POST['location'];
        $department = $_POST['department'];
        $room_type = $_POST['room_type'];

        if ($room_type == "Lab") {
            $room_pic = "lab.png";
        } else {
            $room_pic = "class.png";
        }

        if (!preg_match($loc_reg, $location)) {
            $modalMessage = "Room number must be integers only!";
            $showModal = true;
        } else {
            // Insert into 'room' table
            $sql = "INSERT INTO room VALUES (NULL, :location, '1', '1', '1', '1', '1', '1', :room_type, current_timestamp(), :department, :room_pic)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":location", $location);
            $stmt->bindParam(":department", $department);
            $stmt->bindParam(":room_type", $room_type);
            $stmt->bindParam(":room_pic", $room_pic);
            $stmt->execute();

            // Get the room ID of the newly added room
            $Room_ID = $db->lastInsertId();

            // Define the time slots you want to add to the 'available' table
            $time_slots = [
                '8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00',
                '12:00-1:00', '1:00-2:00'
            ];

            // Insert each time slot into the 'available' table for the new room
            $sql_available = "INSERT INTO available (room_id, time) VALUES (:room_id, :time)";
            $stmt_available = $db->prepare($sql_available);

            foreach ($time_slots as $time) {
                $stmt_available->bindParam(":room_id", $Room_ID);
                $stmt_available->bindParam(":time", $time);
                $stmt_available->execute();
            }

            if($db->commit()){
                $modalMessage = "Room added and time slots added successfully!";
                $showModal = true;
            } else {
                $modalMessage = "There was an error adding the Room.";
                $showModal = true;
            }
        }

    } catch (PDOException $e) {
        $db->rollBack();
        die("Error " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="styles/popup.css" />
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/addRoom.css">
    <link rel="stylesheet" href="styles/footer.css" />
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
            <input type="text" name="text" class="header-input" placeholder="Enter Room Number"/>
            <button type="submit" class="header-search-btn" name="btn">
                <i class="fa-solid fa-magnifying-glass"></i>
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
        <legend>Add New Room</legend>

        <form method="post" id="contactForm">
            <div class="container">
                <div class="Half">
                    <div>
                        <label for="location">Location (numbers only)</label>
                        <input type="text" name="location" id="location" required>
                    </div>

                    <div>
                        <label for="department">Department</label>
                        <select name="department" id="department" class="rtype" required>
                            <?php
                                try {
                                    require('connection.php');
                                    $sql = "SELECT * FROM departments";
                                    $rs = $db->prepare($sql);
                                    $rs->execute();
                                    $db = null;
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }

                                foreach ($rs as $department) {
                                    $dep = $department['dep_name'];
                                    echo "<option value='$dep'>$dep</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="roomType">Room Type</label>
                        <select name="room_type" id="room_type" class="rtype" required>
                            <?php
                                try {
                                    require('connection.php');
                                    $sql = "SELECT * FROM class_type";
                                    $rs = $db->prepare($sql);
                                    $rs->execute();
                                    $db = null;
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }

                                foreach ($rs as $type) {
                                    $roomtype = $type['type'];
                                    echo "<option value='$roomtype'>$roomtype</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="addRoomButton">
                    <button type="submit" id="openModal" class="mybutton" name="btn">Add The Room</button>
                </div>
            </div>
        </form>
    </fieldset>

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
            <a href="">Privacy & Policy</a>
        </div>
        <div class="right-footer">
            <i class="fa-solid fa-circle-info"></i>
        </div>
    </footer>

    <script src="script/pop-up.js"></script>
    <script src="script/header.js"></script>
</body>
</html>
