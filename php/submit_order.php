<?php
session_start();
require('connection.php');

$user = $_SESSION['userid'];
$sql = "SELECT id FROM cart ORDER BY id DESC LIMIT 0,1";
mysqli_query($con, $sql);
if ($result=mysqli_query($con,$sql)){
    $ans=mysqli_fetch_row($result);
    $cart_id = $ans[0];
    $food_id = $_POST['food_id'];
    $qty = $_POST['qty'];
    $sql = "INSERT INTO `order`(cart_id, food_id, order_qty)
            VALUES($cart_id, $food_id, $qty)";
    mysqli_query($con, $sql);
}
?>