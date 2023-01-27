<?php
session_start();
require('connection.php');

if(isset($_SESSION['foods']) && !empty($_SESSION['foods'])){
    $user = $_SESSION['userid'];
    $foods = $_SESSION['foods'];
    $sql = "INSERT INTO cart (user_id)
            VALUES ('$user')";
    $cart_id = 0;
    if(mysqli_query($con, $sql)){
        $cart_id = mysqli_insert_id($con);
    }

    foreach($foods as $food_id => $order_qty){
        $sql = "INSERT INTO `order`(cart_id, food_id, order_qty)
                VALUES($cart_id, $food_id, $order_qty)";
        mysqli_query($con, $sql);
    }
}
unset($_SESSION['foods']);
unset($_SESSION['total_price']);
?>