<?php
session_start();

if(isset($_POST['food_id']) && isset($_POST['order_qty']) && isset($_POST['total_price'])){
    // $foods = $_SESSION['foods'];
    $_SESSION['foods'][($_POST['food_id'])] = $_POST['order_qty'];
    $_SESSION['total_price'] = $_POST['total_price'];
}
?>