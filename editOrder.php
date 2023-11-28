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
                <?php
                if (isset($_POST["orderUpdate"]) && $_POST["orderUpdate"] == "go") {
                  echo '<h1> ORDER UPDATE is a GO<h1>';
                  $orderid = $_POST["orderid"];
                  $userid = $_POST["userid"];
                  $orderDate = $_POST["orderDate"];
                  $orderDiscount = $_POST["orderDiscount"];
                  $shipAddr = $_POST["shipAddr"];
                  $payment = $_POST["payment"];
                  $billAddr = $_POST["billAddr"];

                  $tsql = "UPDATE ORDERS
                  SET
                  ORDER_DATE = '$orderDate', 
                  ORDER_DISCOUNT = '$orderDiscount',
                  SHIP_ADDR = '$shipAddr',
                  PAY_METHOD = '$payment',
                  BILL_ADDR = '$billAddr'
                  WHERE ORDER_ID = '$orderid'";
                  $updateOrder = sqlsrv_query($conn, $tsql);

                  if ($updateOrder === false) {
                      die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                  }
                  redirect("https://php-back2books.azurewebsites.net/editOrder.php?id='.$orderId.'");
               }

               if (isset($_POST["orderLineUpdate"]) && $_POST["orderLineUpdate"] == "go") {
                  echo '<h1> ORDER LINE UPDATE is a GO<h1>';
                  $olineid = $_POST["olineid"];
                  // $bookid = ["bookid"];
                  // $price = ["price"];
                  $orderqty = ["orderqty"];

                  $tsql = "UPDATE ORDER_LINES SET ORDER_QUANTITY = '$orderqty' WHERE OLINE_ID = '$olineid'";

                  $updateOrderLine = sqlsrv_query($conn, $tsql);

                  if ($updateOrderLine === false) {
                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                  }
                  redirect("https://php-back2books.azurewebsites.net/editOrder.php?id='.$orderId.'");
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
                  $orderDate = $orderInfo['ORDER_DATE']->format('Y-m-d H:i:s');
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

                echo ' <h3> You are editing each product in the order </h3>';
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
                  echo '    <label for="price">Book price:</label>';
                  echo '    <input required disabled name="price" value="'.$price.'">';
                  echo '  </div>';

                  echo '  <div class="form-group">';
                  echo '    <label for="orderqty">Order Quantity: </label>';
                  echo '    <input required name="orderqty" type="number" value="'.$orderQty.'">';
                  echo '  </div>';

                  echo '  <div>';
                  echo '      <button name="orderLineUpdate" type="submit" value="go"> Save </button>';
                  echo '      </div>';
                  echo '  </form>';
                }


                ?>
            </center>
        </div>
</body>

</html>