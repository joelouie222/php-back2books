<?php
  session_start();
  include('../functions.php');
  include('../config.php');
  $userId = $_SESSION["userId"];
  $sortSQL = "SELECT * FROM ORDERS WHERE USER_ID = '$userId' ORDER BY ORDER_DATE DESC";

  if (isset($_POST['sortBtn']) && $_POST['sortBtn'] == "apply"){
    switch ($_POST['sortVal']) {
        case "dateAsc":
            $sortSQL = "SELECT * FROM ORDERS WHERE USER_ID = '$userId'";
            break;
        case "priceDesc":
            $sortSQL = "SELECT O.*, SUBQ.TOTAL_AMOUNT FROM ORDERS AS O
            INNER JOIN (SELECT ORDER_ID, SUM(PRICE * ORDER_QUANTITY) AS TOTAL_AMOUNT FROM ORDER_LINES GROUP BY ORDER_ID) AS SUBQ
                ON O.ORDER_ID = SUBQ.ORDER_ID
            WHERE USER_ID = '$userId'
            ORDER BY SUBQ.TOTAL_AMOUNT DESC";
            break;
        case "priceAsc":
            $sortSQL = "SELECT O.*, SUBQ.TOTAL_AMOUNT FROM ORDERS AS O
            INNER JOIN (SELECT ORDER_ID, SUM(PRICE * ORDER_QUANTITY) AS TOTAL_AMOUNT FROM ORDER_LINES GROUP BY ORDER_ID) AS SUBQ
                ON O.ORDER_ID = SUBQ.ORDER_ID
            WHERE USER_ID = '$userId'
            ORDER BY SUBQ.TOTAL_AMOUNT";
            break;
        case "dateDesc":
            $sortSQL = "SELECT * FROM ORDERS WHERE USER_ID = '$userId' ORDER BY ORDER_DATE DESC";
            break;
        default:
            $sortSQL  = "SELECT * FROM ORDERS WHERE USER_ID = '$userId' ORDER BY ORDER_DATE DESC";
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
        include('../layout.php');

    ?>  
      
    <div class="container">
                              
        <div class="products .my-orders">
            <center>
                <h1> MY ORDER HISTORY </h1>
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
                    </select></span>
                    <span><button type="submit" name="sortBtn" value="apply">APPLY</button></span>
                    <p>Current Sort: <?php echo $sortBy;?></p>
                </select></form></div>

                <?php
                    

                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                        $tsql = $sortSQL;
                        $getMyOrders = sqlsrv_query($conn, $tsql);

                        echo '    <div class="products">
                                    <table style="width: 100%; text-align: center;">';
                        echo '        <thead>';
                        echo '            <tr>';
                        echo '                <th style="width: 6%">Order Number</th>';
                        echo '                <th style="width: 6%">Order Date</th>';
                        echo '                <th style="width: 12%">Shipping/Billing Address</th>';
                        echo '                <th colspan="2">Products List</th>';
                        echo '                <th>Subtotal</th>';
                        echo '                <th>Discount</th>';
                        echo '                <th>Payment Method</th>';
                        echo '                 <th style="width: 10%">Fees</th>';
                        echo '                <th style="width: 10% colspan="2">Total</th>';
                        echo '            </tr>';
                        echo '        </thead>';
                        echo '        <tbody>';
                        // echo '<div class="products">';
                        if ($getMyOrders != null){
                            while($orderRow = sqlsrv_fetch_array($getMyOrders, SQLSRV_FETCH_ASSOC)) {
                                $orderId = $orderRow['ORDER_ID'];
                                $orderDate = $orderRow['ORDER_DATE']->format('Y-m-d');
                                $orderDiscount = $orderRow['ORDER_DISCOUNT'];
                                $orderShipAddr = $orderRow['SHIP_ADDR'];
                                $orderPayment = $orderRow['PAY_METHOD'];
                                $shipping = 6.99;
                                $subTotal = 0;

                                    // echo '<p>'.$orderRow['ORDER_ID'] .'</p';
                                    // echo '<p>'.$orderRow['USER_ID'] .'</p';
                                    // echo '<p>'.$orderRow['ORDER_DATE']->format('Y-m-d').'</p';
                                    // echo '<p>'.$orderRow['ORDER_DISCOUNT'] .'</p';
                                    // echo '<p>'.$orderRow['SHIP_ADDR'] .'</p';
                                    // echo '<p>'.$orderRow['PAY_METHOD'] .'</p';
                                    // echo '<p>'.$orderBillAddr.'</p';

                                $tsql = "SELECT * FROM ORDER_LINES WHERE ORDER_ID = '$orderId'";

                                $getOrderLines = sqlsrv_query($conn, $tsql);
                                
                                if ($getOrderLines != null){
                                    echo '            <tr>';
                                    echo '                <td>'.$orderId.'</td>';
                                    echo '                <td>'.$orderDate.'</td>';
                                    echo '                <td>'.$orderShipAddr.'</td>';
                                    echo '<td colspan="2">';
                                    while($orderLines = sqlsrv_fetch_array($getOrderLines, SQLSRV_FETCH_ASSOC)) {
                                        $bookId = $orderLines['BOOK_ID'];
                                        $bookPrice = $orderLines['PRICE'];
                                        $bookQty = $orderLines['ORDER_QUANTITY'];

                                        // echo '<p> BookId: '.$bookId.'</p';
                                        // echo '<p> BookPrice: '.$bookPrice.'</p';
                                        // echo '<p> Book Qty: '.$bookQty.'</p</br></br></br>';

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
                                        //redirect("https://php-back2books.azurewebsites.net/pages/myOrders.php?fetch=err");
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
                                    //redirect("https://php-back2books.azurewebsites.net/pages/myOrders.php?fetch=err");
                                }                                
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            //redirect("https://php-back2books.azurewebsites.net/pages/myOrders.php?fetch=err");
                        }

                    }
                ?>


            </div>
        </div>
</body>

</html>