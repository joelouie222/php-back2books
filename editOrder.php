<?php
  session_start();
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
    // PUT ALL HTML HERE


    
  }
  else {
    //redirect
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Back2Books</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- OUR CSS -->
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php include('../layout.php');
    ?>  
      
    <div class="container">
                              
        <div class="about-us">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
                
                <form method="post" action="">
                    
                    <!-- User Id -->
                
                    <!-- Order Date -->

                    <!-- shipping addr -->

                    <!-- billing address -->

                    <!-- order discount -->

                    <!-- payment method -->

                    <!-- SAVE button (by order id) -->

                    <!-- bookid -->

                    <!-- Qty -->

                    <!-- save (by citem) -->

                    <!-- bookid -->

                    <!-- Qty -->

                    <!-- save (by citem) -->





                <form>


            </center>
        </div>
</body>

</html>