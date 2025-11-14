<?php
session_start();
include 'connect.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        
        if ($password != '') {
            
            $password = $password;
        } else {
            
            $password = $row['password'];
        }

    
        $update_stmt = $conn->prepare("UPDATE accounts SET username = ?, password = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $username, $password, $id);

        if ($update_stmt->execute()) {
            $_SESSION['success'] = 'Account updated successfully';
        } else {
            $_SESSION['error'] = 'Error updating account: ' . $conn->error;
        }

        $update_stmt->close();
    } else {
        $_SESSION['error'] = 'Account not found';
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Fill up the edit form first';
}


header('location: accounts.php');
?>
