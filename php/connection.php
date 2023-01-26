<?php
 
$con = "";
  
$con = new mysqli("localhost", "root", "","mydb"); 

if($con->connect_errno) {
    die("Connection failed: " . $con->connect_error);  
}
     
?>