<?php
include 'connect.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $sql = "DELETE FROM voters WHERE id = '$id'";
    if($conn->query($sql) === TRUE){
        
        header('location: voters.php');
    } else {
        echo 'error';
    }
}
?>

