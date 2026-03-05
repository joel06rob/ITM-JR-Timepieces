<?php
require_once "init.php";

$cart = new Cart();
$cart->addToCart($_POST['product_id']);

header("Location: basket.php");
exit;
?>