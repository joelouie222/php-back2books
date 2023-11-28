<?php
  session_start();
  include("functions.php");
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
    redirect("https://php-back2books.azurewebsites.net/");
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
                              
        <div class="products">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
                
                
                
                <?php
                if (isset($_POST["orderUpdate"]) && $_SESSION["orderUpdate"] == "go") {
                  echo '<h1> ORDER UPDATE is a GO<h1>';
                  echo '<h1> orderid = '.$_POST["orderid"].'<h1>';
                  echo '<h1> userid = '.$_POST["userid"].'<h1>';
                  echo '<h1> orderDate = '.$_POST["orderDate"].'<h1>';
                  echo '<h1> orderDiscount = '.$_POST["orderDiscount"].'<h1>';
                  echo '<h1> shipAddr = '.$_POST["shipAddr"].'<h1>';
                  echo '<h1> payment = '.$_POST["payment"].'<h1>';
                  echo '<h1> billAddr = '.$_POST["billAddr"].'<h1>';
               }

               if (isset($_POST["orderLineUpdate"]) && $_SESSION["orderLineUpdate"] == "go") {
                echo '<h1> ORDER LINE UPDATE is a GO<h1>';
                echo '<h1> olineid = '.$_POST["olineid"].'<h1>';
                echo '<h1> bookid = '.$_POST["bookid"].'<h1>';
                echo '<h1> price = '.$_POST["price"].'<h1>';
                echo '<h1> orderqty = '.$_POST["orderqty"].'<h1>';
                }

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
                echo ' <h1> You are editing Order #: '.$orderId.'</h1>';
                echo ' <form method="post" action="">';
                echo '  <input type="hidden" name="orderid" value="'.$orderId.'">';
                echo '  <div class="form-group">';
                echo '    <label for="userid">User Id: </label>';
                echo '    <input required disabled name="userid" value="'.$userId.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="orderDate">Order Date: </label>';
                echo '    <input required name="orderDate" type="datetime-local" value="'.$orderDate.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="orderDiscount">Order Discount: </label>';
                echo '    <input required name="orderDiscount" value="'.$orderDiscount.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="shipAddr">Shipping Address: </label>';
                echo '    <input required name="shipAddr" value="'.$shippingAddr.'" style="width: 400px;">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="payment">Payment Method: </label>';
                echo '    <input required name="payment" value="'.$payment.'">';
                echo '  </div>';

                echo '  <div class="form-group">';
                echo '    <label for="billAddr">Billing Address:</label>';
                echo '    <input required name="billAddr" value="'.$billingAddr.'" style="width: 400px;">';
                echo '  </div>';

                echo '  <div>';
                echo '      <button name="orderUpdate" type="submit" value="go"> Save </button>';
                echo '      </div>';
                echo '  </form>';

                $tsql = "SELECT * FROM ORDER_LINES WHERE ORDER_ID = '$orderId'";
                $getOrderLines = sqlsrv_query($conn, $tsql);

                if ($getOrderLines == NULL) {
                  die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                  //redirect("https://php-back2books.azurewebsites.net/allOrders.php?fetch=err");
                }

                echo ' <h1> You are editing each product in the order </h1>';
                while($orderLine = sqlsrv_fetch_array($getOrderLines, SQLSRV_FETCH_ASSOC)) {
                  $oline_id = $orderLine['OLINE_ID'];
                  $bookId = $orderLine['BOOK_ID'];
                  $price = $orderLine['PRICE'];
                  $orderQty = $orderLine['ORDER_QUANTITY'];

                  echo ' <form method="post" action="">';
                  echo '  <input type="hidden" name="olineid" value="'.$oline_id.'">';
                  echo '  <div class="form-group">';
                  echo '    <label for="bookid">Book Id: </label>';
                  echo '    <input required disabled name="bookid" value="'.$bookId.'">';
                  echo '  </div>';

                  echo '  <div class="form-group">';
                  echo '    <label for="price">Book Id: </label>';
                  echo '    <input required disabled name="price" value="'.$price.'">';
                  echo '  </div>';

                  echo '  <div class="form-group">';
                  echo '    <label for="orderqty">Book Id: </label>';
                  echo '    <input required name="orderqty" type="number" value="'.$orderQty.'">';
                  echo '  </div>';

                  echo '  <div>';
                  echo '      <button name="orderLineUpdate" type="submit" value="go"> Save </button>';
                  echo '      </div>';
                  echo '  </form>'
                }


                ?>
            </center>
        </div>
</body>

</html>