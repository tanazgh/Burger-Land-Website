<?php
$con = new mysqli("localhost", "root", "","burgerland"); 

if($con->connect_errno) {
    die("Connection failed: " . $con->connect_error);  
}
     
?>