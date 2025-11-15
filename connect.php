<?php
$SERVER = "bovotesz.cluster-clawq4ag8twp.af-south-1.rds.amazonaws.com";
$user = "admin";
$password = "lagunero123";
$db_name = "bovotesz";

$conn = mysqli_connect($SERVER, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("not connected". mysqli_connect_error());

}

?>
