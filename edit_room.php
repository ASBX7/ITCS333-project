<?php

//ahmed code !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$room_id = $_GET['id'] ?? null;
if (!$room_id) {
    die("Room ID is required.");
}

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = :id");
$stmt->execute([':id' => $room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $equipment = $_POST['equipment'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("
        UPDATE rooms 
        SET name = :name, capacity = :capacity, equipment = :equipment, description = :description 
        WHERE id = :id
    ");
    $stmt->execute([
        ':name' => $name,
        ':capacity' => $capacity,
        ':equipment' => $equipment,
        ':description' => $description,
        ':id' => $room_id
    ]);

    header('Location: manage_rooms.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h2>Edit Room</h2>
        <form method="POST">
            <label for="name">Room Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($room['name']) ?>" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" value="<?= $room['capacity'] ?>" required>

            <label for="equipment">Equipment:</label>
            <textarea id="equipment" name="equipment" required><?= htmlspecialchars($room['equipment']) ?></textarea>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($room['description']) ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
    </main>
</body>
</html>