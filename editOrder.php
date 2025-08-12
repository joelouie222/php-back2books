<?php
  session_start();
  include("functions.php");
  // MAKE SURE LOGGED IN USER IS AN ADMIN
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
    redirect($HOME);
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
    <?php 
      include('layout.php');
    ?>  
      
    <div class="container">
                              
        <div class="products">
            <center>
                <?php
                // ==================================================
                // UPDATE ORDER LOGIC
                // ==================================================
                if (isset($_POST["orderUpdate"]) && $_POST["orderUpdate"] == "go") {
                  echo '<h1> Updating order details... Please wait for a moment.<h1>';
                  $orderid = (int) preg_replace('/[\'\";#]/', '', trim($_POST["orderid"]));
                  $userid = (int) preg_replace('/[\'\";#]/', '', trim($_POST["userid"]));
                  $orderDate = preg_replace('/[\'\";#]/', '', trim($_POST["orderDate"]));
                  $orderDiscount = preg_replace('/[\'\";#]/', '', trim($_POST["orderDiscount"]));
                  $shipAddr = preg_replace('/[\'\";#]/', '', trim($_POST["shipAddr"]));
                  $payment = preg_replace('/[\'\";#]/', '', trim($_POST["payment"]));
                  $billAddr = preg_replace('/[\'\";#]/', '', trim($_POST["billAddr"]));

                  $tsql = "UPDATE [order]
                    SET
                    order_date = ?, 
                    order_discount = ?,
                    ship_addr = ?,
                    pay_method = ?,
                    bill_addr = ?
                    WHERE order_id = ?";
                  $params = array($orderDate, $orderDiscount, $shipAddr, $payment, $billAddr, $orderid);
                  $updateOrder = sqlsrv_query($conn, $tsql, $params);

                  if ($updateOrder === false) {
                      // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                      redirect($HOME."allOrders.php?update=err");
                  }
                  redirect($HOME."editOrder.php?id=$orderid");
               }

               // ==================================================
               // UPDATE ORDER LINE LOGIC
               // ==================================================
               if (isset($_POST["orderLineUpdate"]) && $_POST["orderLineUpdate"] == "go") {
                  echo '<h1> Updating order line... Please wait for a moment.<h1>';
                  $olineid = (int) preg_replace('/[\'\";#]/', '', trim($_POST["olineid"]));
                  $orderid = (int) preg_replace('/[\'\";#]/', '', trim($_GET['id']));
                  // $bookid = ["bookid"];
                  // $price = ["price"];
                  $orderqty = (int) preg_replace('/[\'\";#]/', '', trim($_POST["orderqty"]));

                  $tsql = "UPDATE order_lines SET order_quantity = ? WHERE oline_id = ?";
                  $params = array($orderqty, $olineid);
                  $updateOrderLine = sqlsrv_query($conn, $tsql, $params);
                  
                  if ($updateOrderLine === false) {
                    redirect($HOME."allOrders.php?update=err");
                  }
                  
                  $tsql = "SELECT order_id FROM order_lines  WHERE oline_id = ?";

                  $getOrderId = sqlsrv_query($conn, $tsql, array($olineid));

                  if ($getOrderId === false) {
                    redirect($HOME."allOrders.php?update=err");
                  }

                  while($orderLineInfo = sqlsrv_fetch_array($getOrderId, SQLSRV_FETCH_ASSOC)) {
                    $orderid = $orderLineInfo['order_id'];
                  }

                  if (!$orderid) {
                    redirect($HOME."allOrders.php?update=err");
                  } else {
                    redirect($HOME."editOrder.php?id=$orderid");
                  }
                }

                // ==================================================
                // DISPLAY ORDER DETAILS
                // ==================================================
                if (isset($_GET['update']) && $_GET['update'] == "err") {
                    echo '<div style="margin: 10px 0 20px 0;"><center><h3> There was an error updating the order details. Please try again later.</h3>';
                    echo '<a href="'.$HOME.'allOrders.php"><button>Go Back to All Orders</button></a></center></div>';
                    die();
                }

                $orderId = (int) preg_replace('/[\'\";#]/', '', trim($_GET['id']));
                $userId = "";
                $orderDate = "";
                $orderDiscount = "";
                $shippingAddr = "";
                $payment = "";
                $billingAddr = "";

                $tsql = "SELECT * FROM [order] WHERE order_id = ?";
                $getOrder = sqlsrv_query($conn, $tsql, array($orderId));

                if ($getOrder === false) {
                  // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                  echo '</br><h3> Unable to fetch order details at the moment. Please try again later.</h3></br><hr>';
                  echo ' <div style="margin: 10px;"><a href="/allOrders.php"><button>DONE</button></a></div>';
                  die();
                }

                if ($orderInfo = sqlsrv_fetch_array($getOrder, SQLSRV_FETCH_ASSOC)) {
                    $userId = $orderInfo['user_id'];
                    $orderDate = $orderInfo['order_date']->format('Y-m-d H:i:s');
                    $orderDiscount = $orderInfo['order_discount'];
                    $shippingAddr = $orderInfo['ship_addr'];
                    $payment = $orderInfo['pay_method'];
                    $billingAddr = $orderInfo['bill_addr'];
                } else {
                  $errorMessage = "No order was found with ID: " . htmlspecialchars($orderId);
                }

                if ($errorMessage) {
                  echo "<h3>" . $errorMessage . "</h3>";
                } else {
                  echo ' <h1> You are editing Order #: '.$orderId.'</h1></br>';
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
                  echo ' </br><hr> ';

                  $tsql = "SELECT * FROM order_lines WHERE order_id = '$orderId'";
                  $getOrderLines = sqlsrv_query($conn, $tsql);

                  if ($getOrderLines === false) {
                    // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                    echo '</br><h3> Unable to fetch order lines at the moment. Please try again later.</h3></br><hr>';
                    echo ' <div style="margin: 10px;"><a href="/allOrders.php"><button>DONE</button></a></div>';
                    die();
                  }

                  echo ' </br><h3> You are editing each product in the order </h3></br><hr>';
                  while($orderLine = sqlsrv_fetch_array($getOrderLines, SQLSRV_FETCH_ASSOC)) {
                    $oline_id = $orderLine['oline_id'];
                    $bookId = $orderLine['book_id'];
                    $price = $orderLine['price'];
                    $orderQty = $orderLine['order_quantity'];

                    echo ' <form style="margin: 10px;" method="post" action="">';
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
                    echo ' <hr> ';
                  
                  }
                }
                echo ' <div style="margin: 10px;"><a href="/allOrders.php"><button>DONE</button></a></div>';
                ?>
            </center>
        </div>
</body>

</html>