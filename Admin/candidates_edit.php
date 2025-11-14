<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $platform = $_POST['platform'];
    $image = $_POST['image'];  // Default image is set to old one if no new image uploaded

    // Handle the file upload if a new image is selected
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        // If no new image is uploaded, keep the old image
        $query = $conn->query("SELECT image FROM candidates WHERE id = $id");
        $row = $query->fetch_assoc();
        $image = $row['image'];
    }

    // Prepare the SQL query to update the candidate record
    $stmt = $conn->prepare("UPDATE candidates SET name = ?, position = ?, platform = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $position, $platform, $image, $id);

    if ($stmt->execute()) {
        echo "Candidate updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
