<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $stmt = $conn->prepare("INSERT INTO accounts (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);


    if ($stmt->execute()) {
        $_SESSION['success'] = 'Voter added successfully';
    } else {
        $_SESSION['error'] = $stmt->error;
    }


    $stmt->close();
} else {
    $_SESSION['error'] = 'Fill up add form first';
}


header('location: accounts.php');
?>
