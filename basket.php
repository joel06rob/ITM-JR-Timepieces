<?php
require_once "init.php";

//Initialize cart if not existing
$cart = new Cart();
if(!$cart->getCart()){
    $_SESSION['cart'] = [];
}


?>

<!DOCTYPE html>
<html class="bg-[#161616]">
<head>
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>
     
    <?php
    //Check if cart is empty - display if so.
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    }
    else{
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
                        <img src='media/{$row['ImageUrl']}' class='w-24 h-24 object-cover rounded'>
                        <div class='flex flex-col'>
                            <p class='text-xl font-semibold'>{$row['Name']}</p>
                            <p class='text-gray-600'>£{$subtotal}</p>
                            <p class='text-sm font-light'>{$quantity}</p>
                        </div>
                    </div>
                </div>
                ";
        }
        
        echo "
            <div class='flex items-center p-2 gap-1 justify-end'> 
                <h3>Order Total: </h3><p>£{$ordertotal}</p>
            </div>";
        
        echo "
            <div class='flex justify-end items-center pt-2'>
                <a href='neworder.php' class='inline-block bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition'>Purchase</a> 
            </div>";

    }
    ?>

    <a href='index.php' class='text-[#BFB578] font-semibold inline-block pt-4 hover:text-[#161616]'>← Continue Shopping</a>
    

</div>

</body>
</html>