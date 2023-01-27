<?php
session_start();
require('connection.php');

$user = $_SESSION['userid'];
$sql = "INSERT INTO cart (user_id)
        VALUES ('$user')";
mysqli_query($con, $sql);
?>