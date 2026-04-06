<?php 
require_once "init.php";
$product = new Product($conn);

//Load products from DB
//If no search - load all, else load only searched products
//
$product_results;
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
  $product_results = $product->getProducts("all");
}
else{
  $product_results = $product->getProducts($_GET['search'] ?? "");
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

<body class="bg-white">

<!-- NAVBAR -->
<nav class="absolute top-0 left-0 w-full z-10">
    <div class="max-w-8xl mx-auto px-8 py-4 flex justify-end items-center">
      <div class="flex items-center gap-6">
        <!-- Navigation Links -->
        <ul class="flex gap-10 bg-gradient-to-r from-[#242424] to-[#2D2D2D] p-4 px-11 rounded-[35px] font-medium text-white shadow-[0_1px_5px_rgba(0,0,0,0.25)] items-center">
          <li><a href="watchfinder.php" class="hover:text-gray-300 transition-colors duration-200">Watches</a></li>
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
<section class="my-40 mx-auto">
  <!--SEARCH-->
    <form id="searchForm" method="GET" action="watchfinder.php" class="mx-10">
        <input type="text" name="search" id="searchInput" placeholder="Search for watches" class="font-[20] text-4xl w-full bg-transparent outline-none border-none text-[#1a1a1]">
    </form>
    <hr class="border-t border-[#b0aca6] mx-0 mt-3">

    <!--WATCHES-->
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
                

                //Check if item is in stock, if so display add to cart button else tell the user they are out of stock.
                if($product_result['Stock'] > 0){
                      echo '<form method="POST" action="add_to_basket.php">
                          <input type="hidden" name="product_id" value="'.$product_result["ID"].'">
                          <button type="submit"
                          class="inline-block bg-none text-black font-[50] px-4 py-2 rounded-lg hover:text-[#cccccc] transition">
                          ADD TO CART
                          </button>
                      </form>';
                  } 
                  else{

                      echo '<p class="text-red-500 font-semibold">Out of stock</p>';
                  
                  }
                
                echo '</div>';
        }


        ?>
    </div>

</section>


</body>
</html>