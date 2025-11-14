<?php
include 'connect.php';


if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $Stuid = $_POST['Stuid'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $department = $_POST['department'];

    
    $sql = "SELECT * FROM voters WHERE id = $id";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    
    $sql = "UPDATE voters SET Stuid = '$Stuid', email = '$email', name = '$name', department = '$department' WHERE id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'voter updated successfully';
    } else {
        $_SESSION['error'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}


header('location: voters.php');
?>
