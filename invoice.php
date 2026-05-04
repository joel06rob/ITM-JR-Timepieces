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
$order_id = $order->createOrder($_SESSION['user_id'], $_SESSION['cart']);
?>

<!DOCTYPE html>
<html class="bg-[#161616]">
    <head>
        <title>Order</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Order Details [<?= $order_id ?>]:</h1>

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
                    <p>Phone:" . htmlspecialchars($phone) . "</p> ";
                    
            //Prepare product IDs for SELECT statement. i.e. {1=>2, 4=>1, 7=>3} --> 1,4,7
            $product_ids = implode(",", array_keys($_SESSION['cart']));

            $sql = "SELECT * FROM Product WHERE ID IN ($product_ids)";
            $result = mysqli_query($conn, $sql);

            $ordertotal = 0;

            while($row = mysqli_fetch_assoc($result)){

                $product_id = $row['ID'];
                $quantity = $_SESSION['cart'][$product_id];
                $price = $row['Price'];
                $subtotal = $price * $quantity;

                $ordertotal += $subtotal;
                
                echo "
                    <div class='flex items-center justify-between mt-1 gap-1 p-1 border rounded-lg'>
                        <div class='flex items-center gap-4'>
                            <img src='media/{$row['ImageUrl']}' class='w-10 h-10 object-cover rounded'>
                            <div class='flex flex-col'>
                                <p class='text-sm font-semibold'>{$row['Name']}</p>
                                <p class='text-gray-600 text-xs'>£{$subtotal}</p>
                                <p class='text-xs font-light'>{$quantity}</p>
                            </div>
                        </div>
                    </div>
                    ";
            }
                    

            echo "
                    <br>
                    <p><i><b>Delivery Information:</b></i></p>
                    <p>" . htmlspecialchars($firstaddress) . "</p>
                    <p>" . htmlspecialchars($secondaddress) . "</p>
                    <p>" . htmlspecialchars($towncity) . "</p>
                    <p>" . htmlspecialchars($postcode) . "</p>

                    <br>
                    <p><i><b>Total Paid:</b></i></p>
                    <p>£" . $ordertotal . "</p>
                    <p>Paid With:</p>
                    <p>•••• •••• •••• ". $hiddencardnumber ."</p>
                </div>

                <a href='index.php' class='inline-block bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition'>Continue</a>
                <a href='orders.php' class='inline-block bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition'>Track Order</a>
            ";
            
            //Clear cart and total variables:
            $_SESSION['cart'] = [];
            $_SESSION['ordertotal'] = 0;

            
            }
        ?>

    </body>

</html>