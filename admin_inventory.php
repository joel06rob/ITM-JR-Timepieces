<?php
  require_once "init.php";

  //User isn't admin - Redirect
  if (!$auth->checkAdmin()){
  header("Location: index.php");
  exit;
  }

  $admin = new Admin($conn);
  $product_results = $admin->getProductsStock();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Watch Shop</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#161616]">

<!-- NAVBAR -->
<nav class="absolute top-0 left-0 w-full z-10">
    <div class="max-w-8xl mx-auto px-8 py-4 flex justify-end items-center">
      <div class="flex items-center gap-6">
        <!-- Navigation Links -->
        <ul class="flex gap-10 bg-gradient-to-r from-[#242424] to-[#2D2D2D] p-4 px-11 rounded-[35px] font-medium text-white shadow-[0_1px_5px_rgba(0,0,0,0.25)] items-center">
          <li><a href="index.php" class="hover:text-gray-300 transition-colors duration-200">Watches</a></li>
          <li><a href="orders.php" class="hover:text-gray-300 transition-colors duration-200">My Orders</a></li>
          <li><a href="basket.php" class="hover:text-gray-300 transition-colors duration-200">Basket</a></li>
          
          <div class="flex gap-5 items-center pl-6">
            <li><a href="watchfinder.php"><img src="media/icons8-women's-watch-30.png"></a></li>
            <li><a href="signup.php"><img src="media/icons8-person-30.png"></a></li>
          </div>
        </ul>

      </div>
    </div>
</nav>


<!-- ADMIN -->
<section class="max-w-7xl mx-auto py-20 pb-28 px-4">

  <h2 class="text-3xl font-bold mb-5 text-center text-white">Admin Inventory</h2>

<div class="flex">
    <a class="py-3 px-6 text-white" href="admin_manage.php">Manage</a>
    <a class="py-3 px-6 text-white" href="admin_dash.php">Dashboard</a>
    <a class="py-3 px-6 text-black bg-white rounded-[35px]" href="admin_inventory.php">Inventory</a>
</div>

  <div class="flex flex-col gap-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-2 mt-6">
        <?php 
        foreach($product_results as $product_result){
            echo '
                <div class="relative group bg-white overflow-hidden shadow p-5 text-center transition-transform duration-300 ease-in-out shadow-[0_1px_5px_rgba(0,0,0,0.1)] hover:cursor-pointer">
                <img 
                    src="media/' . $product_result['ImageUrl'] . '" 
                    alt="'.$product_result['Name'].'"
                    class="w-full h-40 object-contain rounded-lg mb-4 transition-transform duration-300 ease-in-out group-hover:scale-125"
                >

                <h5 class="text-xl font-semibold mb-1">'. $product_result['Name'] .'</h5>
                <p class="text-sm text-gray-400 opacity-100 max-h-20 overflow-hidden transition-all duration-300 group-hover:opacity-0 group-hover:max-h-0">
                    '. $product_result['Description'] .'
                </p>
                <p class="text-gray-500 mb-4">£'. $product_result['Price'] .'</p> 
                ';
                

                //Check if item is in stock
                if($product_result['Stock'] > 0){
                      echo '<p class="text-gray-500 mb-4">'. $product_result['Stock'] .'</p> ';
                }
                else{

                      echo '<p class="text-red-500 font-semibold">Out of stock</p>';
                  
                  }
                
                echo '</div>';
        }


        ?>
    </div>
  </div>


</section>


<footer class="flex text-white font-medium py-8 px-8 gap-6">
    <a href="index.php">Contact Us</a>
    <a href="watchfinder.php">Make a Purchase</a>
    <a href="basket.php">Your Cart</a>
</footer>

<script src="chartdata_dash.js" defer></script>
</body>
</html>