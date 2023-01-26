<?php

require('connection.php');

$id = $_GET['id'];
$sql = "DELETE FROM cat WHERE id=$id";

if (mysqli_query($con, $sql)) {
    header('location: dashboard.php');
    echo "1 Record deleted";
} else {
    echo "Error Delete: " . mysqli_error($con);
}
mysqli_close($con);
?>