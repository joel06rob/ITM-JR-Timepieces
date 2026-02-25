<?php
  require_once "init.php";

  //User isn't admin - Redirect
  if (!$auth->checkAdmin()){
  header("Location: index.php");
  exit;
  }

  //Get data for charts - Moved to seperate endpoint (Simpler JSON data).
  



?>

<!DOCTYPE html>
<html>
<head>
    <title>Watch Shop</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
          <li><a href="#products" class="hover:text-gray-300 transition-colors duration-200">Watches</a></li>
          <li><a href="#products" class="hover:text-gray-300 transition-colors duration-200">My Orders</a></li>
          <li><a href="#products" class="hover:text-gray-300 transition-colors duration-200">Basket</a></li>
          
          <div class="flex gap-5 items-center pl-6">
            <li><a href="#products"><img src="media/icons8-women's-watch-30.png"></a></li>
            <li><a href="signup.php"><img src="media/icons8-person-30.png"></a></li>
          </div>
        </ul>

      </div>
    </div>
</nav>


<!-- ADMIN -->
<section id="dashboard" class="max-w-7xl mx-auto py-20 pb-28 px-4">

  <h2 class="text-3xl font-bold mb-5 text-center text-white">Admin Dashboard</h2>

  <div>
  <!--DASHBOARD: ORDERS-->
    <div>
      <h3 class="text-center text-xl font-bold text-white m-10">Orders</h3>
      <div class="flex flex-col gap-10">
        <div class="text-center p-12 bg-gradient-to-r from-[#242424] to-[#2D2D2D] rounded-[50px]">
          <p id="totalOrders" class="text-white"></p>
          <p class="text-lg text-white">Total Orders</p>
        </div>
        <div class="text-center p-12 bg-gradient-to-r from-[#242424] to-[#2D2D2D] rounded-[50px]">
          <p id="totalUnprocessedOrders" class="text-white"></p>
          <p class="text-lg text-white">Unprocessed Orders</p>
        </div>
      </div>
      <div>
        <canvas></canvas>
      </div>

    </div>

  </div>


</section>


<footer class="flex text-white font-medium py-8 px-8 gap-6">
    <a href="#">Contact Us</a>
    <a href="#">Make a Purchase</a>
    <a href="cart.php">Your Cart</a>
</footer>

<script src="chartdata_dash.js" defer></script>
</body>
</html>