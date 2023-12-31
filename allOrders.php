<?php
  session_start();
  include('functions.php');
  include('config.php');
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
    redirect("https://php-back2books.azurewebsites.net/");
  }
  //$userId = $_SESSION["userId"];
  $sortSQL = "SELECT * FROM ORDERS ORDER BY ORDER_DATE DESC";

  if (isset($_POST['sortBtn']) && $_POST['sortBtn'] == "apply"){
    switch ($_POST['sortVal']) {
        case "dateAsc":
            $sortSQL = "SELECT * FROM ORDERS ORDER BY ORDER_DATE";
            break;
        case "priceDesc":
            $sortSQL = "SELECT O.*, SUBQ.TOTAL_AMOUNT FROM ORDERS AS O
            INNER JOIN (SELECT ORDER_ID, SUM(PRICE * ORDER_QUANTITY) AS TOTAL_AMOUNT FROM ORDER_LINES GROUP BY ORDER_ID) AS SUBQ
                ON O.ORDER_ID = SUBQ.ORDER_ID
            ORDER BY SUBQ.TOTAL_AMOUNT DESC";
            break;
        case "priceAsc":
            $sortSQL = "SELECT O.*, SUBQ.TOTAL_AMOUNT FROM ORDERS AS O
            INNER JOIN (SELECT ORDER_ID, SUM(PRICE * ORDER_QUANTITY) AS TOTAL_AMOUNT FROM ORDER_LINES GROUP BY ORDER_ID) AS SUBQ
                ON O.ORDER_ID = SUBQ.ORDER_ID
            ORDER BY SUBQ.TOTAL_AMOUNT";
            break;
        case "userDesc":
            $sortSQL = "SELECT * FROM ORDERS ORDER BY USER_ID DESC";
            break;
        case "userAsc":
            $sortSQL = "SELECT * FROM ORDERS ORDER BY USER_ID";
            break;
        case "dateDesc":
            $sortSQL = "SELECT * FROM ORDERS ORDER BY ORDER_DATE DESC";
            break;
        default:
            $sortSQL  = "SELECT * FROM ORDERS ORDER BY ORDER_DATE DESC";
    }
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
                <h1> A L L &nbsp &nbsp O R D E RS </h1>
            </center>
            <div> 
                <div style="float: right; margin: 10px 50px 10px 0px;"><form method="post" action="">
                    <span><label for="sortVal">Sort by: </label></span>
                    <span><select name="sortVal" id="sortBy">
                        <option selected value=""> - </option>
                        <option value="dateDesc"> New to Old </option>
                        <option value="dateAsc"> Old to New </option>
                        <option value="priceDesc"> Total Descending </option>
                        <option value="priceAsc"> Total Ascending </option>
                        <option value="userDesc"> User Descending </option>
                        <option value="userAsc"> User Acending </option>
                    </select></span>
                    <span><button type="submit" name="sortBtn" value="apply">APPLY</button></span>
                </select></form></div>

                <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
                        $tsql = $sortSQL;
                        $getMyOrders = sqlsrv_query($conn, $tsql);

                        echo '    <div class="products">
                                    <table style="width: 100%; text-align: center;border: 1px solid; border-collapse: collapse;">';
                        echo '        <thead>';
                        echo '            <tr style="border: 1px solid;">';
                        echo '                <th style="width: 6%">Order #</th>';
                        echo '                <th style="width: 6%">User Id</th>';
                        echo '                <th style="width: 6%">Date</th>';
                        echo '                <th style="width: 12%">Shipping/Billing Address</th>';
                        echo '                <th colspan="2">Products List</th>';
                        echo '                <th style="width: 8%">Subtotal</th>';
                        echo '                <th style="width: 6%">Discount</th>';
                        echo '                <th style="width: 6%">Payment Method</th>';
                        echo '                 <th style="width: 10%">Fees</th>';
                        echo '                <th style="width: 10%; colspan="2">Total</th>';
                        echo '            </tr>';
                        echo '        </thead>';
                        echo '        <tbody>';
                        // echo '<div class="products">';
                        if (isset($_GET['fetch']) && $_GET['fetch'] == "err") {
                            echo '<div><h3> There was an error fetching your order history. Please try again later. </h3><div>';
                        }
                        if ($getMyOrders != null){
                            while($orderRow = sqlsrv_fetch_array($getMyOrders, SQLSRV_FETCH_ASSOC)) {
                                $orderId = $orderRow['ORDER_ID'];
                                $userId = $orderRow['USER_ID'];
                                $orderDate = $orderRow['ORDER_DATE']->format('Y-m-d');
                                $orderDiscount = $orderRow['ORDER_DISCOUNT'];
                                $orderShipAddr = $orderRow['SHIP_ADDR'];
                                $orderPayment = $orderRow['PAY_METHOD'];
                                $shipping = 6.99;
                                $subTotal = 0;

                                $tsql = "SELECT * FROM ORDER_LINES WHERE ORDER_ID = '$orderId'";

                                $getOrderLines = sqlsrv_query($conn, $tsql);
                                
                                if ($getOrderLines != null){
                                    echo '            <tr style="border: 1px solid;">';
                                    echo '                <td><div><h3>'.$orderId.'</h3></div>';
                                    echo '                        <div style="margin: 10px 0px;"><a href="https://php-back2books.azurewebsites.net/editOrder.php?id='.$orderId.'">Edit</a></div>';
                                    // echo '                        <div><a href="">Delete</a></div>';
                                    echo '                        </td>';
                                    echo '                <td>'.$userId.'</td>';
                                    echo '                <td>'.$orderDate.'</td>';
                                    echo '                <td>'.$orderShipAddr.'</td>';
                                    echo '<td colspan="2">';
                                    while($orderLines = sqlsrv_fetch_array($getOrderLines, SQLSRV_FETCH_ASSOC)) {
                                        $bookId = $orderLines['BOOK_ID'];
                                        $bookPrice = $orderLines['PRICE'];
                                        $bookQty = $orderLines['ORDER_QUANTITY'];

                                        $subTotal = ($subTotal + ($bookPrice * $bookQty));

                                        $tsql = "SELECT BOOK_TITLE, BOOK_ISBN FROM BOOKS WHERE BOOK_ID = '$bookId'";

                                        $getBookInfo = sqlsrv_query($conn, $tsql);

                                        if ($getOrderLines != null){

                                            
                                            while($bookInfo  = sqlsrv_fetch_array($getBookInfo , SQLSRV_FETCH_ASSOC)) {
                                                $bookTitle = $bookInfo['BOOK_TITLE'];
                                                $bookISBN = $bookInfo['BOOK_ISBN'];
                                                
                                                echo '<span> '.$bookTitle.' ['.$bookISBN.'] <span></br>
                                                        <span>'.$bookQty.'</span>                                                        
                                                        <span> @ $ '.number_format($bookPrice, 2).' </span></br></br>';       
                                            }
                                            
                                        } else {
                                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                            redirect("https://php-back2books.azurewebsites.net/allOrders.php?fetch=err");
                                        }
                                    }
                                    echo '</td>';
                                    echo '                <td>'.number_format($subTotal, 2).'</td>';
                                    echo '                <td> - $ '.number_format($orderDiscount, 2).'</td>';
                                    echo '                <td>'.$orderPayment.'</td>';
                                    echo '                <td><p style="margin-top: 5px;">Tax</br>$ '.number_format(($subTotal * 0.0825), 2).'</p></br>
                                                             <p style="margin-bottom: 5px;">Shipping</br>$ '.$shipping.'</p></td>';
                                    echo '                <td colspan="2">$ '.number_format(($subTotal - $orderDiscount + ($subTotal * 0.0825) + $shipping), 2).'</td>';
                                    echo '            </tr>';

                                } else {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    redirect("https://php-back2books.azurewebsites.net/allOrders.php?fetch=err");
                                }                                
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            (print_r(sqlsrv_errors(), true));  // Print detailed error information
                            redirect("https://php-back2books.azurewebsites.net/allOrders.php?fetch=err");
                        }

                    }
                ?>


            </div>
        </div>
</body>

</html>