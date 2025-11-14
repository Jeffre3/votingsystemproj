<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Delete candidate
    $stmt = $conn->prepare("DELETE FROM candidates WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Candidate deleted successfully";
    } else {
        echo "Failed to delete candidate";
    }
    $stmt->close();
    $conn->close();
}
?>
