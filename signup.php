<!--TODO: PHP CODE TO QUERY USER ACCOUNT > REDIRECT TO LOGIN -->
<?php
require_once "autoloader.php";

//User Signup (TEST)
if($_SERVER["REQUEST_METHOD"] == "POST"){

  $fname = $_POST['fname'] ?? '';
  $sname = $_POST['sname'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $passwordre = $_POST['repeat_password'] ?? '';
  
  //Validation: Signup
  //Passwords, Names, Email
  $signup_errors = [];
  if(!($password == $passwordre)){
    $signup_errors[] = "<p class='text-red-600'>Please ensure your password matches the re-entered password.</p>";
  }
  if(preg_match('/\d/', $fname) || preg_match('/\d/', $sname)){
    $signup_errors[] = "<p class='text-red-600'>Please enter a valid name.</p>";
  }
  if(!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)){
    $signup_errors[] = "<p class='text-red-600'>Please enter a valid email.</p>";
  }

  //TODO: Auth() - Validate if email already exists.

  if(!$signup_errors){
  $db = new Database();
  $conn = $db->connect();

  $user_signup = new User($conn);
  $result_signup = $user_signup->createUser($fname, $sname, $email, $password);
  if($result_signup){
    //TODO: On redirect, pass temporary cookie into login page - Auto login.
    echo "<p class='text-green-500'>Successfully Signed Up</p>";
  }
  else{
    echo "<p class='text-red-600'>Error Signing Up: Please Try Again</p>";
  }
  }
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

<!--SIGNUP SECTION-->
<section class="relative h-screen overflow-hidden flex items-center justify-center">
    <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline><source src="media/204581-925146029_small.mp4"/></video>
    <div class="relative z-10 w-full max-w-md">
        <div class="bg-white px-10 pb-36 pt-8 shadow-xl">
          
          <?php
            if(isset($signup_errors) && $signup_errors){
              echo "<div class='flex flex-col bg-red-300 px-2 rounded-lg'>";
              foreach($signup_errors as $error){
                echo $error;
              }
              echo "</div>";
            }
          ?>

            <div>
              <h2 class="my-4">SIGN UP</h2>
                <form action="signup.php" method="post" class="flex flex-col gap-3">
                  <div>
                    <input type="text" name="fname" placeholder="First Name:" required>
                  </div>
                  <div>
                    <input type="text" name="sname" placeholder="Surname:" required>
                  </div>
                  <div>
                    <input type="email" name="email" placeholder="Email:" required>
                  </div>
                  <div>
                    <input type="password" name="password" placeholder="Password:" required>
                  </div>
                  <div>
                    <input type="password" name="repeat_password" placeholder="Repeat Password:">
                  </div>
                  <!--Add optional address here-->
                  <div>
                    <input type="submit" value="SIGN UP" name="submit" class="bg-[#2D2D2D] text-white py-3 px-5">
                  </div>
                </form>
            </div>
            <p class="mt-10">Already a member with us? <a href="login.php">Log In</a></p>
        </div>
    </div>


</section>
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
</body>
</html>