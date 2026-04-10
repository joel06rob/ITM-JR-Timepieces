<?php
require_once "init.php";

  //User isn't admin - Redirect
  if (!$auth->checkAdmin()){
  header("Location: index.php");
  exit;
  }

  $admin = new Admin($conn);

  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])){
    
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $admin->updateOrder($order_id, $new_status);
}

  $statusFilter = $_GET['status'] ?? null;
  if($statusFilter){
    $orders = $admin->getAllOrders($statusFilter);
  }
  else{
    $orders = $admin->getAllOrders();
  }

  
  

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
<div id="products" class="max-w-7xl mx-auto py-20 pb-28 px-4">

  <h2 class="text-3xl font-bold mb-5 text-center text-white">Admin Manage</h2>
  <?php 
  
  if(!$orders){
  echo "<p class='text-white'>No Orders Found.</p>";
  }
  else{

    //Display:
    // header
    // orders data

    echo "<form method='GET' class='flex justify-end'>
      <select name='status' onchange='this.form.submit()' 
          class='px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600'>
          
          <option value='' " . (($statusFilter == '') ? 'selected' : '') . ">
              All Orders
          </option>

          <option value='Processing' " . (($statusFilter == 'Processing') ? 'selected' : '') . ">
              Processing
          </option>

          <option value='Completed' " . (($statusFilter == 'Completed') ? 'selected' : '') . ">
              Completed
          </option>

          <option value='Cancelled' " . (($statusFilter == 'Cancelled') ? 'selected' : '') . ">
              Cancelled
          </option>

      </select>
  </form>";
    echo "<div class='py-10'>
          <div class='px-8 py-4 bg-gray-800'>
            <ul class='flex list-none justify-between text-white'>
              <li>Order ID
              <li>Customer ID
              <li>Order Date
              <li>Status
            </ul>
          </div>
          <div class='flex flex-col gap-1'>
          ";

    foreach($orders as $order){

      $status = $order['Status'];
      if($status == "Completed"){
        $statusClass = "bg-green-500/20 text-green-500";
      }
      elseif($status == "Processing"){
        $statusClass = "bg-blue-500/20 text-blue-500";
      }
      elseif($status == "Cancelled"){
        $statusClass = "bg-red-500/20 text-red-500";
      }
      else{
        $statusClass = "bg-gray-500 text-white";
      }

      echo "<div class='flex items-center bg-white gap-4 py-4 px-8 border'>   
                        <div class='flex-1 flex items-center gap-4'>          
                          <p>{$order['ID']}</p>
                          <p>{$order['CustomerID']}</p>
                          <p class='pl-2 text-xs'>{$order['OrderDate']}</p>
                        </div>
                        <div class='flex-1'>
                          <form method='POST' class='inline-block'>
                          <input type='hidden' name='order_id' value='{$order['ID']}'>
                          <select name='status' onchange='this.form.submit()'
                              class='px-3 py-1 rounded-lg text-sm border {$statusClass}'>

                              <option value='Processing' " . (($status == 'Processing') ? 'selected' : '') . ">
                                  Processing
                              </option>

                              <option value='Completed' " . (($status == 'Completed') ? 'selected' : '') . ">
                                  Completed
                              </option>

                              <option value='Cancelled' " . (($status == 'Cancelled') ? 'selected' : '') . ">
                                  Cancelled
                              </option>

                          </select>
                          <input type='hidden' name='update_status' value='1'>
                          </form>
                        </div>
                        <div class='flex-1 flex justify-end'>
                        ";

      //TODO: FIX LAYOUT OF CANCELLED STATUS
      if($status != "Cancelled"){
        echo "<form method='POST' action='admin_manage_delete.php'>
                            <input type='hidden' name='orderid' value='".$order["ID"]."'>
                            <button type='submit'
                            class='inline-block bg-none text-red-600 font-[50] px-4 py-2 rounded-lg hover:text-red-800 transition'>
                            Cancel
                            </button>
                        </form>";
      }
      else{
        echo "<div class='w-6'></div>";
      }

      echo "</div></div>";
    }

    echo "</div>";
    echo "</div>";
  }
  
  ?>

</div>


<footer class="flex text-white font-medium py-8 px-8 gap-6">
    <a href="#">Contact Us</a>
    <a href="#">Make a Purchase</a>
    <a href="cart.php">Your Cart</a>
</footer>

</body>
</html>