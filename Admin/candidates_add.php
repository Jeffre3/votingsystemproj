<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $platform = $_POST['platform'];
    $image = $_FILES['image'];

    // Upload image
    $imagePath = 'uploads/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO candidates (name, position, platform, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $position, $platform, $imagePath);
    if ($stmt->execute()) {
        echo "Candidate added successfully";
    } else {
        echo "Failed to add candidate";
    }
    $stmt->close();
    $conn->close();
}
?>
    