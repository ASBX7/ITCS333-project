<?php 
require('connection.php');

if (isset($_GET['room'])) {
    $room_id = $_GET['room'];

    $sql = "DELETE FROM room WHERE room_id = ?";
    $stmt = $db->prepare($sql);

    $rs = $stmt->execute(array($room_id));

    if ($rs) {
        echo "Room deleted successfully.";
        header("Location: browsing-admin.php"); 
        exit();
    } else {
        echo "Error: Could not delete room.";
    }
}
?>
