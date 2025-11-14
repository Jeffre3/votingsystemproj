<?php
$SERVER = "localhost";
$user = "myuser";
$password = "mypassword";
$db_name = "mydb";

$conn = mysqli_connect($SERVER, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("not connected". mysqli_connect_error());

}

?>
