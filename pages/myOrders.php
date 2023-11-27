<?php
  session_start();
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
    <?php
        include('../layout.php');
        include('../functions.php');
        include('..config.php');
    ?>  
      
    <div class="container">
                              
        <div class="about-us">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
                <h2> This page will list the orders made by the current logged in user </h2>
            </center>
            <div> 

                <?php
                    $userId = $_SESSION["userId"];

                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                        $tsql = "SELECT * FROM ORDERS WHERE USER_ID = '$userId'";
                        $getMyOrders = sqlsrv_query($conn, $tsql);

                        if ($getMyOrders != null){
                            while($orderRow = sqlsrv_fetch_array($getMyOrders, SQLSRV_FETCH_ASSOC)) {
                                echo '<p>'.$orderRow['ORDER_ID'] .'</p';
                                echo '<p>'.$orderRow['USER_ID'] .'</p';
                                echo '<p>'.$orderRow['ORDER_DATE'] .'</p';
                                echo '<p>'.$orderRow['ORDER_DISCOUNT'] .'</p';
                                echo '<p>'.$orderRow['SHIP_ADDR'] .'</p';
                                echo '<p>'.$orderRow['PAY_METHOD'] .'</p';
                                echo '<p>'.$orderRow['BILL_ADDR'] .'</p';
                            }
                        } else {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            //redirect("https://php-back2books.azurewebsites.net/pages/cart.php?order=err");
                        }

                    }
                ?>


            </div>
        </div>
</body>

</html>