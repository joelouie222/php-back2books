<?php
    session_start();
    include('../functions.php');
    include('../config.php');
    $userId = (int) $_SESSION['userId'];

    // ====================================================================
    // BUILDING SORT SQL QUERY
    // ====================================================================
    // default SQL query to fetch orders
    // orders are sorted by order date in descending order (newest first)
    $sortSQL = "SELECT * FROM [order] WHERE user_id = ? ORDER BY order_date DESC";

    // if the user has clicked the sort button, we will change the SQL query based on the selected value
    if (isset($_POST['sortBtn']) && $_POST['sortBtn'] == "apply"){
        switch ($_POST['sortVal']) {
            case "dateAsc":
                $sortSQL = "SELECT * FROM [order] WHERE user_id = ? ORDER BY order_date";
                break;
            case "priceDesc":
                $sortSQL = "SELECT O.*, SUBQ.total_amount FROM [order] AS O
                INNER JOIN (SELECT order_id, SUM(price * order_quantity) AS total_amount FROM order_lines GROUP BY order_id) AS SUBQ
                    ON O.order_id = SUBQ.order_id
                WHERE user_id = ?
                ORDER BY SUBQ.total_amount DESC";
                break;
            case "priceAsc":
                $sortSQL = "SELECT O.*, SUBQ.total_amount FROM [order] AS O
                INNER JOIN (SELECT order_id, SUM(price * order_quantity) AS total_amount FROM order_lines GROUP BY order_id) AS SUBQ
                    ON O.order_id = SUBQ.order_id
                WHERE user_id = ?
                ORDER BY SUBQ.total_amount";
                break;
            case "dateDesc":
                $sortSQL = "SELECT * FROM [order] WHERE user_id = ? ORDER BY order_date DESC";
                break;
            default:
                $sortSQL  = "SELECT * FROM [order] WHERE user_id = ? ORDER BY order_date DESC";
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
    <!-- <link rel="stylesheet" href="/logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.ico">
</head>

<body id="home">
    <?php
        include('../layout.php');
    ?>  
      
    <div class="container">
        <div class="products my-orders">
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
                </select></form></div>

                <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                        // =========================================================
                        // GET ALL THE ORDERS FOR THE USER
                        // =========================================================
                        $tsql = $sortSQL;
                        $params = array($userId);
                        $getMyOrders = sqlsrv_query($conn, $tsql, $params);

                        echo '    <div class="products">
                                    <table style="width: 100%; text-align: center;border: 1px solid; border-collapse: collapse;">';
                        echo '        <thead>';
                        echo '            <tr style="border: 1px solid;">';
                        echo '                <th style="width: 6%">Order #</th>';
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
                            echo '<a href="'.$HOME.'pages/myOrders.php">Click here to refresh</a>';
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>'; // end of products
                            echo '</div>';
                            echo '</div>'; // end of products .my-orders
                            echo '</div>'; // end of container
                            echo '</body>'; // end of body
                            echo '</html>'; // end of html
                            die();
                        }

                        if ($getMyOrders != null){

                            // get the lines for each order by looping through the orders (need order_id)
                            while($orderRow = sqlsrv_fetch_array($getMyOrders, SQLSRV_FETCH_ASSOC)) {
                                $orderId = $orderRow['order_id'];
                                $orderDate = $orderRow['order_date']->format('Y-m-d');
                                $orderDiscount = $orderRow['order_discount'];
                                $orderShipAddr = $orderRow['ship_addr'];
                                $orderPayment = $orderRow['pay_method'];                                
                                $subTotal = 0;

                                // =========================================================
                                // GET ALL THE ORDER LINES FOR THE ORDER
                                // =========================================================
                                $tsql = "SELECT * FROM order_lines WHERE order_id = ?";
                                $params = array($orderId);
                                $getOrderLines = sqlsrv_query($conn, $tsql, $params);

                                if ($getOrderLines != null) {
                                    echo '            <tr style="border: 1px solid;">';
                                    echo '                <td>'.$orderId.'</td>';
                                    echo '                <td>'.$orderDate.'</td>';
                                    echo '                <td>'.$orderShipAddr.'</td>';
                                    echo '<td colspan="2">';

                                    // Loop through the order lines to get book details 
                                    while($orderLines = sqlsrv_fetch_array($getOrderLines, SQLSRV_FETCH_ASSOC)) {
                                        $bookId = $orderLines['book_id'];
                                        $bookPrice = $orderLines['price'];
                                        $bookQty = $orderLines['order_quantity'];

                                        $subTotal = ($subTotal + ($bookPrice * $bookQty));

                                        $tsql = "SELECT book_title, book_isbn FROM book WHERE book_id = ?";
                                        $params = array($bookId);
                                        $getBookInfo = sqlsrv_query($conn, $tsql, $params);

                                        if ($getBookInfo != null){
                                            while($bookInfo  = sqlsrv_fetch_array($getBookInfo , SQLSRV_FETCH_ASSOC)) {
                                                $bookTitle = $bookInfo['book_title'];
                                                $bookISBN = $bookInfo['book_isbn'];
                                                
                                                echo '<span> '.$bookTitle.' ['.$bookISBN.'] <span></br>
                                                        <span>'.$bookQty.'</span>                                                        
                                                        <span> @ $ '.number_format($bookPrice, 2).' </span></br></br>';       
                                            }
                                        } else {
                                            // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                            // redirect("https://php-back2books.azurewebsites.net/pages/myOrders.php?fetch=err");

                                            // unable to fetch book info, redirect with error
                                            redirect($HOME."pages/myOrders.php?fetch=err");
                                        }
                                    }

                                    $tax = ($subTotal * 0.0825); // 8.25% tax
                                    $shipping = ($subTotal > 0) ? 6.99 : 0;

                                    echo '</td>';
                                    echo '                <td>'.number_format($subTotal, 2).'</td>';
                                    echo '                <td> - $ '.number_format($orderDiscount, 2).'</td>';
                                    echo '                <td>'.$orderPayment.'</td>';
                                    echo '                <td><p style="margin-top: 5px;">Tax</br>$ '.number_format(($tax), 2).'</p></br>
                                                             <p style="margin-bottom: 5px;">Shipping</br>$ '. number_format(($shipping), 2).'</p></td>';
                                    echo '                <td colspan="2">$ '.number_format(($subTotal - $orderDiscount + ($tax) + $shipping), 2).'</td>';
                                    echo '            </tr>';

                                } else {
                                    // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    // redirect("https://php-back2books.azurewebsites.net/pages/myOrders.php?fetch=err");

                                    // unable to fetch order lines, redirect with error
                                    redirect($HOME."pages/myOrders.php?fetch=err");
                                }                                
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            // die(print_r(sqlsrv_errors(), true));  // Print detailed error information

                            // unable to fetch orders, redirect with error
                            redirect($HOME."pages/myOrders.php?fetch=err");
                        }
                    } else { // NOT LOGGED IN redirect to login page
                        redirect($HOME."pages/login.php");
                    }     
                ?>
            </div>
        </div> <!-- end of products .my-orders -->
    </div> <!-- end of container -->
</body>

</html>