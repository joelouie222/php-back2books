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
    <?php include('layout.php');
    ?>  
      
    <div class="container">
                              
        <div class="about-us">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
                
                
                
                <?php
                $orderId = $_GET['id'];
                $userId = "";
                $orderDate = "";
                $orderDiscount = "";
                $shippingAddr = "";
                $payment = "";
                $billingAddr = "";


                $tsql = "SELECT * FROM ORDERS WHERE ORDER_ID = '$orderId'";
                $getOrder = sqlsrv_query($conn, $tsql);

                if ($getOrder == NULL) {
                  die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                  //redirect("https://php-back2books.azurewebsites.net/allOrders.php?fetch=err");
                }

                while($orderInfo = sqlsrv_fetch_array($getOrder, SQLSRV_FETCH_ASSOC)) {
                  $userId = $orderInfo['USER_ID'];
                  $orderDate = $orderInfo['ORDER_DATE']->format('Y-m-d H:i:s');;
                  $orderDiscount = $orderInfo['ORDER_DISCOUNT'];
                  $shippingAddr = $orderInfo['SHIP_ADDR'];
                  $payment = $orderInfo['PAY_METHOD'];
                  $billingAddr = $orderInfo['BILL_ADDR'];

                }
                echo '<form method="post" action="">';
                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required name="userid" value="'.$userId.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required name="userid" value="'.$orderDate.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required name="userid" value="'.$orderDiscoun.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required name="userid" value="'.$shippingAddr.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required name="userid" value="'.$payment.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required name="userid" value="'.$billingAddr.'">';
                echo '  </div>';

                echo '  <div>';
                echo '      <button name="orderUpdate" type="submit" value="go"> Save </button>';
                echo '      </div>';
                echo '  </form>'





                ?>

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