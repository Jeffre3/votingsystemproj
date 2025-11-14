<?php
$SERVER = "localhost";
$user = "root";
$password = "";
$db_name = "bovotes";

$conn = mysqli_connect($SERVER, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("not connected". mysqli_connect_error());

}

?>