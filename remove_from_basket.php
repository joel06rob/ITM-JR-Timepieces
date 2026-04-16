<?php
require_once "init.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $productId = $_POST['product_id'] ?? null;

    if($productId){
        $cart = new Cart();
        $cart->removeFromCart($productId);
    }
}

header("Location: basket.php");
exit;
?>