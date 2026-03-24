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
$ordertotal = $_SESSION['ordertotal'] ?? 0;
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

<?php 
//Insert order to DB

$order = new Order($conn);
$order->createOrder($_SESSION['user_id'], $_SESSION['cart']);
?>

<!DOCTYPE html>
<html class="bg-[#161616]">
    <head>
        <title>Order</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Order Details:</h1>

        <?php

            if(!empty($errors)){
                foreach ($errors as $error){
                    echo "<p class='text-red-600'> $error</p>";
                }
            }
            else{

            
            //Display the order details (Using htmlspecialchars to escape any malicious inputs)
            echo "
                <div class='px-2'>
                    <p><strong>" . htmlspecialchars($name) . ", welcome to the JR Timepiece's Owners Club.</strong></p>
                    <br>
                    <p><i><b>The details of your order are listed below:</b></i></p>
                    <p>Email:" . htmlspecialchars($email) . "</p>
                    <p>Phone:" . htmlspecialchars($phone) . "</p>

                    <br>
                    <p><i><b>Delivery Information:</b></i></p>
                    <p>" . htmlspecialchars($firstaddress) . "</p>
                    <p>" . htmlspecialchars($secondaddress) . "</p>
                    <p>" . htmlspecialchars($towncity) . "</p>
                    <p>" . htmlspecialchars($postcode) . "</p>

                    <br>
                    <p><i>Total Paid:</i></p>
                    <p>£" . $ordertotal . "</p>
                    <p>Paid With:</p>
                    <p>•••• •••• •••• ". $hiddencardnumber ."</p>
                </div>

                <a href='index.php' class='inline-block bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition'>Continue</a>
            ";
            
            //Clear cart and total variables:
            $_SESSION['cart'] = [];
            $_SESSION['ordertotal'] = 0;

            
            }
        ?>

    </body>

</html>