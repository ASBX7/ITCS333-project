<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    header("location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservebut'])) {
    try {
        require('connection.php');

        $timeslot = $_POST['timeslot'];
        $room_id = $_POST['room_id'];
        $user_id = $_SESSION['currentUser']; // Assuming the user ID is stored in the session

        // Check if the room is already reserved at the selected time for the same user
        $sql_check = "SELECT * FROM reserved_rooms WHERE room_id = ? AND time_slot = ? AND user_id = ?";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->execute([$room_id, $timeslot, $user_id]);

        if ($stmt_check->rowCount() > 0) {
            echo "<script>alert('You have already reserved this room at this time!');</script>";
        } else {
            // Insert reservation only if the room is not reserved at that time
            $sql_reserve = "INSERT INTO reserved_rooms (room_id, time_slot, user_id) VALUES (?, ?, ?)";
            $stmt_reserve = $db->prepare($sql_reserve);
            $stmt_reserve->execute([$room_id, $timeslot, $user_id]);

            // Redirect after reservation
            header("Location: reserved.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
