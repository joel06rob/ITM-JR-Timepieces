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
            <li><a href="#products"><img src="media/icons8-person-30.png"></a></li>
          </div>
        </ul>

      </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="bg-gradient-to-b from-[#161616] to-[#242424] flex items-center justify-center">
    <img src="media/HeroWatchImage1.png" class="max-w-[90%] max-h-[90%]">
    <div>
        <div class="flex flex-col text-[128px] bg-gradient-to-r from-[#696969] to-[#FFFFFF] bg-clip-text text-transparent">
            <p>LUXURY</p>
            <p>TIMEPIECES</p>
        </div>
        <a href="#products">
        <div class="flex items-center gap-2">
            <div class="w-16 h-0.5 bg-white"></div>
            <p class="text-white font-extralight">DISCOVER</p>
        </div>
        </a>
    </div>
</section>

<!--SIGNUP SECTION-->
<section class="relative h-screen overflow-hidden">
    <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline><source src="media/204581-925146029_small.mp4"/></video>
    <div class="relative z-10 flex-col text-white p-10">
        <div class="flex flex-col">
            <p class="text-[128px] italic font-bold">MEMBERS CLUB</p>
            <p class="text-[40px] font-normal">JOIN THE COLLECTORS CLUB TO PURCHASE</p>
        </div>

        <button class="mt-[400px] mx-auto bg-white text-black px-8 py-5">SIGN UP</button>
    </div>


</section>

<!-- PRODUCT LIST -->
<div id="products" class="max-w-7xl mx-auto py-20 pb-28 px-4">

    <h2 class="text-3xl font-bold mb-5 text-center text-white">Our Collection</h2>
    <h3 class="text-2xl font-regular mb-20 text-center text-[#BFB578]">Explore our finest timepieces</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    </div>
    <div class="flex justify-center">
        <button class="justify-center bg-white text-black px-8 py-5">FIND WATCH</button>
    </div>
</div>

<!--ABOUT-->
<section class="bg-white">
<div class="max-w-4xl mx-auto py-16 px-10 grid grid-cols-2 gap-20">
<p class="py-10">JR Timepieces has been established since the 1800's. We have been carefully assembling timepieces in a professional, expert manner for as long as we can remember. Not one bezel or hand hasn't been carefully crafted by our expert watchmakers. Our watches are like no other, we only craft for the best.</p>
<img src="media/images1.jpeg">
</div>
</section>

<footer class="flex text-white font-medium py-8 px-8 gap-6">
    <a href="#">Contact Us</a>
    <a href="#">Make a Purchase</a>
    <a href="cart.php">Your Cart</a>
</footer>

</body>
</html>