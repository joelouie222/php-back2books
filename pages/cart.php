<?php
  session_start();
  $_SESSION['discountValue'] = 0;
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
    <div class="container">
        <?php 
            include('../layout.php');
            include('../functions.php');

            if (isset($_POST['discountCode'])) {
                $found = false;
                $tsql = "SELECT DISCOUNT_CODE, DISCOUNT_TAG FROM DISCOUNT WHERE ACTIVE = 1";
                $getDiscount = sqlsrv_query($conn, $tsql);
                if ($getDiscount != false){
                    while (($row = sqlsrv_fetch_array($getDiscount, SQLSRV_FETCH_ASSOC)) && $found == false) {
                        if (($row['DISCOUNT_CODE']) == $_POST['discountCode']) {
                            $_SESSION['discountCode'] = $_POST['discountCode'];
                            $_SESSION['discountValue'] = ($row['DISCOUNT_TAG'] / 100);
                            $found = true;
                        }
                    }
                } else {
                    $_SESSION['discountCode'] = "Invalid Code";
                    $_SESSION['discountValue'] = 0;
                }
            }
        ?>   

        <div class="cart">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
            </center>
        </div>

        <div class="cart">
            <div style="margin: 10px 0px 10px 0px"> <h1>Shopping Cart</h1> <div>
                
            <div>
                <?php
                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                    echo '<form action="" method="post">';
                    echo '   <table style="width: 100%">';
                    echo '        <thead>';
                    echo '            <tr>';
                    echo '                <th colspan="2" style="text-align: left; padding: 10px 0px 10px 0px"><h3>Product<h3></th>';
                    echo '                <th style="text-align: left;"><h3>Price</h3></th>';
                    echo '                <th style="text-align: left;"><h3>Quantity<h3></th>';
                    echo '                <th style="text-align: right;"><h3>Total</h3></th>';
                    echo '            </tr>';
                    echo '        </thead>';
                    echo '        <tbody>';
                              
                                if ($_SESSION['numInCart'] == 0 )
                                    echo '<tr><td colspan="5" style="text-align:center;"><h3> You have no products added in your Shopping Cart</h3></td></tr>';
                                else {
                                    $subtotal = 0;
                                    $discount = 0;
                                    $shipping = 6.99;
                                    $tsql = "SELECT CITEM_ID, BOOK_ID, ITEM_QUANTITY FROM CART_ITEMS WHERE CART_ID = (SELECT CART_ID FROM CART WHERE USER_ID = '$userId')";

                                    $getCart = sqlsrv_query($conn, $tsql);

                                    if ($getCart === false) {
                                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    } else {
                                        while($row = sqlsrv_fetch_array($getCart, SQLSRV_FETCH_ASSOC)) {
                                            $citemId = $row['CITEM_ID']
                                            $bookdId = $row['BOOK_ID'];
                                            $quantity = $row['ITEM_QUANTITY'];
                                            
                                            $tsql = "SELECT B.BOOK_TITLE, B.BOOK_ISBN, B.PRICE, BI.IMAGE_LINK, PI.INV_QUANTITY
                                                     FROM BOOKS B 
                                                     INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
                                                     INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID
                                                     WHERE B.BOOK_ID = '$bookdId'";

                                            $getBook = sqlsrv_query($conn, $tsql);


                                            if ($getBook === false) {
                                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                            }

                                            if ($getBook != false) {
                                                while($row = sqlsrv_fetch_array($getBook, SQLSRV_FETCH_ASSOC)){
                                                echo '    <tr>';
                                                echo '        <td class="">';
                                                echo '            <img src="'.$row['IMAGE_LINK'].'" alt="Image of Book '.$row['BOOK_TITLE'].'" height="100" width="75">';
                                                echo '        </td>';
                                                echo '        <td>';
                                                echo '            <p>'.$row['BOOK_TITLE'].'</p>';
                                                echo '            <p> ISBN: '.$row['BOOK_ISBN'].'</p>';
                                                echo '            <p> Stock left: '.$row['INV_QUANTITY'].'</p>';
                                                echo '            </br>';
                                                echo '           <a href="https://php-back2books.azurewebsites.net/removeCartItem?p='.$citemId.'">Remove</a>';
                                                echo '        </td>';
                                                echo '        <td class="" style="text-align: left;"><p>$ '.$row['PRICE'].'</p></td>';
                                                echo '        <td class="" style="text-align: left;">';
                                                echo '            <input type="number" name="'.$row['$bookId'].'" min="1" max="'.$row['INV_QUANTITY'].'" value="'.$quantity.'" required>';
                                                echo '        </td>';
                                                echo '        <td class="" style="text-align: right;"><p>$ '.number_format(($row['PRICE'] * $quantity), 2).'</p></td>';
                                                echo '    </tr>';
                                                $subtotal = $subtotal + ($row['PRICE'] * $quantity);
                                                }
                                            }
                                            //sqlsrv_free_stmt($getBook);
                                        }   
                                    }                             
                                    sqlsrv_free_stmt($getCart);

                                        echo '</tbody>';
                                        echo '</table>';
                                        echo '<div> <h3>SUBTOTAL: $ '.number_format($subtotal, 2).'</h3></div>';
                                        echo '<div>';
                                        echo '<form method="post" action="">';
                                        echo '    <input type="text" name="discountCode" placeholder="Discount Code" value="'.$_SESSION['discountCode'].'"></input>';
                                        echo '    <button type="submit" name="coupon" value="apply">Apply</button>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '<div><h3>DISCOUNT: - $ '.number_format(($subtotal * $_SESSION['discountValue']), 2).'</h3></div>';
                                        echo '<div><h3>TAX: $'.number_format(($subtotal * 0.0825), 2).' </h3></div>';
                                        echo '<div><h3>SHIPPING: $ '.$shipping.'</h3></div>';
                                        echo '<div><h3>TOTAL: $ '.number_format(($subtotal - ($subtotal * $_SESSION['discountValue']) + ($subtotal * 0.0825) + $shipping), 2).'</h3></div>';
                                        echo '<div class="">';
                                        echo '<button type="submit" value="update" name="updateOrder">Update Order</button>';
                                        echo '<button type="submit" value="order" name="placeOrder">Place Order</button>';
                                }
                            
                    
                    echo '</div>';
                    echo'</form>';
                } else {
                    redirect("https://php-back2books.azurewebsites.net/pages/login.php");
                }
                    
                ?>
            </div>
                    
        <!-- <div class="cart-summary">
                <div><span>SUBTOTAL: </span> <span> $$$$ </span> </div>
                <div><span>DISCOUNT: </span> <span> - $$$ </span> </div>
                <div><span>SHIPPING: </span> <span> $$$$ </span> </div>
                <div><span>TAX: </span> <span> $$$$ </span> </div>
                <div><span>SHIPPING: </span> <span> $$$$ </span> </div>
                <div><button>CHECK OUT</button></div>
        </div> -->
</body>

<script src="js/scripts.js"></script>

</html>