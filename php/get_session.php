<?php
session_start();

$res = array();

if(isset($_GET['food_id'])){
    $food_id = $_GET['food_id'];
    if(isset($_SESSION['foods'])){
        $foods = $_SESSION['foods'];
        if(isset($foods[$food_id])){
            $res["order_qty"] = $foods[$food_id];
        }else{
            $res["order_qty"] = 0;
        }
    }else{
        $res["order_qty"] = 0;
    }
    if(isset($_SESSION['total_price'])){
        $res["total_price"] = $_SESSION['total_price'];
    }else{
        $res["total_price"] = 0;
    }
    // print_r($res);
    echo json_encode($res);

}

?>