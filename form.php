<?php
  include 'include/db.php';
   
  if(isset($_POST['submit'])){
     $error = array();
  
     if(empty($_POST['email'])){
      $error['email'] = "Enter Email";
  
     }else{
      $statement = $conn->prepare("SELECT * FROM admin WHERE email = :em");
      $statement->bindParam(":em",$_POST['email']);
      $statement->execute();


          // Prepare query
      $statement = $conn->prepare("SELECT * FROM admin WHERE email = :em");
      $statement->bindParam(":em", $_POST['email']);
      $statement->execute();

      // Check if email exists
      if ($statement->rowCount() === 0) {
          $error['email'] = "Email not found, please enter a correct email.";
      } else {
          $record = $statement->fetch(PDO::FETCH_ASSOC);

          // Verify password (assuming you store it hashed)
          if (!password_verify($_POST['hash'], $record['hash'])) {
              $error['hash'] = "Incorrect password";
          } else {
              // ✅ Email and password are correct
              // You can start session or redirect user here
              $_SESSION['admin'] = $record['id'];
          }
      }



     }


     if(empty($_POST['hash'])){
      $error['hash'] = "Enter Password";

     }

     if(empty($error)){
      $stmt = $conn->prepare("SELECT * FROM admin WHERE email = :em LIMIT 1");
      $stmt->bindParam(":em", $_POST['email'], PDO::PARAM_STR);
      $stmt->execute();
      $record = $stmt->fetch(PDO::FETCH_ASSOC);



       if($stmt->rowCount() > 0 &&password_verify($_POST['hash'], $record['hash'])){
           header("Location: home.php");
           exit();
       }else{
        // $error['hash'] = "Incorrect password";
        header("Location:form.php?error=either email or password incorrect");
       }

     }

    

  }

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register With us</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: white; /* change background if you want */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loader {
      position: relative;
      transform: rotateZ(45deg);
      perspective: 1000px;
      border-radius: 50%;
      width: 80px;
      height: 80px;
      color: black;
    }

    .loader:before,
    .loader:after {
      content: '';
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      width: inherit;
      height: inherit;
      border-radius: 50%;
      transform: rotateX(70deg);
      animation: 1s spin linear infinite;
    }

    .loader:after {
      color: rgb(42, 207, 42);
      transform: rotateY(70deg);
      animation-delay: .4s;
    }

    @keyframes spin {
      0%, 100% { box-shadow: .2em 0px 0 0px currentcolor; }
      12% { box-shadow: .2em .2em 0 0 currentcolor; }
      25% { box-shadow: 0 .2em 0 0px currentcolor; }
      37% { box-shadow: -.2em .2em 0 0 currentcolor; }
      50% { box-shadow: -.2em 0 0 0 currentcolor; }
      62% { box-shadow: -.2em -.2em 0 0 currentcolor; }
      75% { box-shadow: 0px -.2em 0 0 currentcolor; }
      87% { box-shadow: .2em -.2em 0 0 currentcolor; }
    }
  </style>
</head>
<body>
        <div class="preloader">
            <div class="loader"></div>
        </div>
   
 <section class="home min-h-screen flex flex-col justify-between">

  <div class="login flex flex-col md:flex-row justify-between items-center p-6 md:p-10">
    
    <div class="home flex items-center mb-4 md:mb-0 md:ml-10">
      <ion-icon class="bg-green-500 text-white rounded-full p-1 text-2xl md:text-3xl" name="planet-outline"></ion-icon>
      <h1 class="ml-2 text-lg md:text-2xl font-bold">
        Gamecent <span class="block md:inline text-xs">/ support@gamecent.com</span>
      </h1>
    </div>

    <div class="get flex space-x-4 md:mr-20">
      <a class="hover:text-green-500 font-medium mt-4 mr-2" href="signin.html">Sign In</a>
      <a class="text-white hover:text-green-500 font-semibold bg-green-500 hover:bg-white px-5 md:px-7 py-2 md:py-3 rounded-full border border-transparent hover:border-green-500" href="index.html">Get Started</a>
    </div>

  </div>

  <div class="head text-center mt-6 md:mt-10 px-4">
    <h1 class="text-3xl md:text-6xl font-medium font-serif">Login to Your <br class="hidden md:block"> Account</h1>
    <p class="mt-3 text-sm md:text-base font-semibold text-neutral-400">Uncover the Untapped Potential of Your Growth to Connect Games</p>
  </div>


  <div class="login flex flex-col md:flex-row justify-center mt-10 px-4 md:px-0">

 
    <div class="log1 w-full md:w-auto">
      <form method="POST" class="flex flex-col items-center">

      <?php if (isset($error['email'])): ?>
      <p class="text-green-500 text-sm w-full md:w-[350px] text-left">
        <?= $error['email']; ?>
      </p>
    <?php endif; ?>

        <input class="w-full md:w-[350px] border focus:outline-none focus:shadow-2xl focus:border-green-500 border-slate-500 mb-4 pl-4 rounded-full font-medium py-3" type="email" name="email" placeholder="Phone / Email">    


           <?php if (isset($error['hash'])): ?>
      <p class="text-green-500 text-sm w-full md:w-[350px] text-left">
        <?= $error['hash']; ?>
      </p>
    <?php endif; ?>
        <input class="w-full md:w-[350px] border focus:outline-none focus:shadow-2xl focus:border-green-500 border-slate-500 mb-4 pl-4 rounded-full font-medium py-3" type="password" name="hash" placeholder="Passcode">   

          <input 
          class="block text-center w-full sm:w-[250px] md:w-[300px] lg:w-[350px] text-white text-sm md:text-base font-medium  hover:text-green-500 bg-green-500 hover:bg-white hover:border border-green-500 py-3 px-6 rounded-full cursor-pointer transition duration-300 ease-in-out" type="submit" name="submit" value="Login To Your Account">
    

      </form>
    </div>

    <div class="log2 w-full md:w-auto mt-8 md:mt-0 md:ml-20 flex flex-col items-center md:items-start space-y-4">
      <p class="cursor-pointer w-full md:w-auto text-center text-sm text-green-500 border border-green-500 px-6 md:px-12 rounded-full py-3 hover:text-white hover:bg-green-500">
        <ion-icon class="mr-2" name="logo-google"></ion-icon> <a href="http://gmail.com">
          Sign in with Gmail
        </a>
      </p>

      <p class="cursor-pointer w-full md:w-auto text-center text-sm text-green-500 border border-green-500 px-6 md:px-12 rounded-full py-3 hover:text-white hover:bg-green-500">
        <ion-icon class="mr-2" name="logo-facebook"></ion-icon> <a href="http://www.facebook.com">
           Sign in with Facebook
        </a>
      </p>

      <p class="cursor-pointer w-full md:w-auto text-center text-sm text-green-500 border border-green-500 px-6 md:px-12 rounded-full py-3 hover:text-white hover:bg-green-500">
        <ion-icon class="mr-2" name="logo-apple"></ion-icon> <a href="http://www.icloud.com">
          Sign in with Apple
        </a>
      </p>
    </div>

  </div>

  <div class="mt-6 flex justify-center px-4">
    <p class="font-medium text-neutral-600 hover:text-green-500 cursor-pointer">Forgot Passcode?</p>
  </div>

  <footer class="mt-10 px-4 md:px-10 flex flex-col md:flex-row justify-between items-center text-center md:text-left space-y-2 md:space-y-0 pb-6">
    <a class="font-medium text-neutral-600 text-xs md:text-sm" href="#">Privacy Policy | Terms & Conditions</a>
    <a class="font-medium text-neutral-600 text-xs md:text-sm" href="#">Copyright © Gamecent Group 2025</a>
  </footer>

</section>

  


















        <script>
            window.addEventListener("load", function(){
                setTimeout(function(){
                document.querySelector(".preloader").style.display = "none";
                document.getElementById("main-content").style.display = "block";
                }, 2000);
            });
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>