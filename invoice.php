<?php
require_once "init.php";

 //Prevent URL Hacking - Redirect
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: neworder.php");
        exit;
}

//Redirect if cart is blank
if(empty($_SESSION['cart'])){
    header("Location: neworder.php");
    exit;
}


//Get all fields submitted in order form
//TODO: $ordertotal = $_SESSION['ordertotal'] ?? 0;
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$firstaddress = $_POST['firstaddress'] ?? '';
$secondaddress = $_POST['secondaddress'] ?? '';
$towncity = $_POST['towncity'] ?? '';
$postcode = $_POST['postcode'] ?? '';
$cardnumber = $_POST['numbercard'] ?? '';
$cardname = $_POST['namecard'] ?? '';

// Phone number validation
if (!preg_match('/^[0-9+\s()-]{7,20}$/', $phone)) {
    header("Location: neworder.php?error=invalid_phone");
    exit;
}

// Postcode validation
if (!preg_match('/^[A-Za-z0-9\s-]{4,10}$/', $postcode)) {
    header("Location: neworder.php?error=invalid_postcode");
    exit;
}

//Name validation
if(preg_match('/\d/', $name) || preg_match('/\d/', $cardname)){
    header("Location: neworder.php?error=invalid_name");
    exit;
}

//Get last 4 digits of card number
$hiddencardnumber = substr($cardnumber, -4);

?>