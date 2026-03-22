<?php
require_once "init.php";

//Redirect back to cart if empty
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    header("Location: basket.php");
    exit;
}

//Errors - Get invalid entry errors
$errors = $_GET['error'] ?? '';

?>

<!DOCTYPE html>
<html class="bg-[#161616]">
    <head>
        <title>Your Order</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

        <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Your Order</h1>
        <?php 

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
                <div class='flex items-center justify-between gap-4 p-4 border rounded-lg'>
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
            <div class='flex items-center p-2 gap-1 justify-end'> 
                <h3>Order Total: </h3><p>£{$ordertotal}</p>
            </div>";
        
        ?>

        <?php

        //Erros - Display input errors from form submission
        if(isset($errors)){
            switch($errors){
            case 'invalid_phone':
                echo "<p class='text-red-600'>Enter a valid phone number.</p>";
                break;
            case 'invalid_postcode':
                echo "<p class='text-red-600'>Enter a valid post code.</p>";
                break;
            case 'invalid_name':
                echo "<p class='text-red-600'>Enter a valid name.</p>";
                break;
        }
        }

        ?>

        <!--  Order details form, using POST for security  -->
        <form class="my-8 grid grid-cols-2 grid-rows-7 gap-4" action="invoice.php" method="POST">
            <span><strong>Details</strong></span><span></span>
            Name: <input type="text" name="name" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            E-mail: <input type="text" name="email" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
            Phone Number: <input type="text" name="phone" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^\+?[0-9]{1,4}?[\s.-]?\(?[0-9]{1,4}?\)?[\s.-]?[0-9\s.-]{5,15}$" required>
            <span><strong>Address</strong></span><span></span>
            1st Line Address: <input type="text" name="firstaddress" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            2nd Line Address: <input type="text" name="secondaddress" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            Town/City: <input type="text" name="towncity" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            Postcode: <input type="text" name="postcode" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[A-Za-z0-9\s-]{4,10}$" required>
            <span><strong>Payment</strong></span><span></span>
            Name on card: <input type="text" name="namecard" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            Card Number: <input type="text" name="numbercard" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[0-9 ]{13,19}$" inputmode="numeric" required>
            CVC: <input type="text" name="cvccard" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[0-9]{3,4}$" inputmode="numeric" required>
            <div class="col-span-2 flex justify-end mt-4"><input type="submit" value="Confirm & Pay" class="inline-block bg-gray-800 text-white px-4 py-2 rounded-lg hover:cursor-pointer hover:bg-gray-900 transition" required></div>
        </form>
        <a href='basket.php' class='text-gray-800 inline-block'>← Back to Cart</a>
        
    </body>


</html>