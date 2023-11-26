<?php
  session_start();
  if (!isset($_SESSION['discountValue']) || $_SESSION['discountValue'] == 0){
    $_SESSION['discountValue'] = 0;
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
    <div class="container">
        <?php 
            include('../layout.php');
            include('../functions.php');


            
            echo '<div class="cart">';
            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                if ((isset($_POST['update'])) && $_POST['update'] == "update") {
                    echo '<p>citemId: '.$_POST['citemId'].'</p>';
                    echo '<p>productId: '.$_POST['productId'].'</p>';
                    echo '<p>quantity: '.$_POST['quantity'].'</p>';

                    $cartItemId = $_POST['citemId'];
                    $newQuantity = $_POST['quantity'];

                    $tsql = "UPDATE CART_ITEMS SET ITEM_QUANTITY = '$newQuantity' WHERE CITEM_ID = '$cartItemId'";

                    $updateCart = sqlsrv_query($conn, $tsql);
                    if ($updateCart === false) {
                        redirect("https://php-back2books.azurewebsites.net/pages/cart.php?update=err");
                    }
                    $newQuantity = "";
                    $cartItemId = "";
                    redirect("https://php-back2books.azurewebsites.net/pages/cart.php");
                }

                if ((isset($_POST['placeOrder'])) && $_POST['placeOrder'] == "go") {
                    // echo '<p>placeOrder is a '.$_POST['placeOrder'].'!</p>';
                    // echo '<p>Street Add: '.$_POST['streetAddress1'].'!</p>';
                    // echo '<p>Street Add2: '.$_POST['streetAddress2'].'!</p>';
                    // echo '<p>City: '.$_POST['city'].'!</p>';
                    // echo '<p>State: '.$_POST['state'].'!</p>';
                    // echo '<p>Zip: '.$_POST['zipCode'].'!</p>';
                    // echo '<p>Payment: '.$_POST['payment'].'!</p>';

                    $address = ''.$_POST['streetAddress1'].', '.$_POST['streetAddress2'].',  '.$_POST['city'].', '.$_POST['state'].' '.$_POST['zipCode'].'';
                    $payment = $_POST['payment'];
                    $currentDate = date('Y-m-d');                    
                    $orderDiscount = $_SESSION['DISCOUNT'];
                    
                    
                    echo '<p>address: '.$address.'</p>';
                    echo '<p>payment: '.$payment.'</p>';
                    echo '<p>currentDate: '.$currentDate.'</p>';
                    echo '<p>orderDiscount: '.$orderDiscount.'</p>';
                    echo '<p>userId: '.$userId.'</p>';
                    echo '<p>bookId: '.$userId.'</p>';

                    $tsql = "INSERT INTO ORDERS (USER_ID, ORDER_DATE, ORDER_DISCOUNT, SHIP_ADDR, PAY_METHOD, BILL_ADDR) 
                    VALUES ('$userId', '$currentDate', '$orderDiscount', '$address', '$payment', '$address')";

                    $addOrder = sqlsrv_query($conn, $tsql);

                    if($addOrder== false) {
                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                        redirect("https://php-back2books.azurewebsites.net/pages/cart.php?order=err");
                    } else {
                        // GET ORDER ID
                        $tsql = "SELECT ORDER_ID FROM ORDERS WHERE USER_ID = '$userId'' AND ORDER_DATE = '$currentDate' AND ORDER_DISCOUNT = '$orderDiscount'";
                        
                        $getOrderId = sqlsrv_query($conn, $tsql);

                        while($orderRow = sqlsrv_fetch_array($getOrderId , SQLSRV_FETCH_ASSOC)) {
                            $orderId = $orderRow['ORDER_ID'];

                            if($orderId != false) {
                                // GET CART ITEMS
                                $tsql = "SELECT * FROM CART_ITEMS WHERE CART_ID = (SELECT CART_ID FROM CART WHERE USER_ID = '$userId')";

                               $orderCart = sqlsrv_query($conn, $tsql);

                               while($cartRow = sqlsrv_fetch_array($orderCart, SQLSRV_FETCH_ASSOC)) {
                                    // CONVERT CART ITEMS INTO ORDER LINES (NEED ORDER_ID, BOOK_ID, PRICE, QUANTITY)
                                    $transferBOOKID = $cartRow['BOOK_ID'];
                                    $transferPRICE = $cartRow['PRICE'];
                                    $transferQTY = ['ORDER_QUANTITY'];

                                    $tsql = "INSERT INTO ORDER_LINES (ORDER_ID, BOOK_ID, PRICE, ORDER_QUANTITY)
                                            VALUES ('$orderId', '$transferBOOKID', '$transferPRICE', '$transferQTY')";

                                    $addOrderLine = sqlsrv_query($conn, $tsql);

                                    if ($addOrderLine == false) {
                                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                        //redirect("https://php-back2books.azurewebsites.net/pages/cart.php?order=err");
                                    }

                                    // UPDATE STOCK in PRODUCT INVENTORY (NEED BOOK ID)
                                    $tsql = "UPDATE PRODUCT_INVENTORY SET INV_QUANTITY = (INV_QUANTITY - '$transferQTY') WHERE BOOK_ID = '$transferBOOKID'";

                                    $updateProductQty = sqlsrv_query($conn, $tsql);

                                    if ($updateProductQty == false) {
                                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                        //redirect("https://php-back2books.azurewebsites.net/pages/cart.php?order=err");
                                    }

                                    // DELETE CART ITEMS (NEED CITEM_ID)
                                    $deleteCItemId = $cartRow['CITEM_ID'];
                                    $tsql = "DELETE FROM CART_ITEMS WHERE CITEM_id = '$deleteCItemId'";

                                    $deleteCI = sqlsrv_query($conn, $tsql);
                                    if ($deleteCI == false) {
                                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                        //redirect("https://php-back2books.azurewebsites.net/pages/cart.php?order=err");
                                    }
                                }
                            } else {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                //redirect("https://php-back2books.azurewebsites.net/pages/cart.php?order=err");
                            }
                            // ORDER CREATION SUCCESS REDIRECT TO MY ORDERS

                        }
                    }   
                }                    
            }
            echo '</div>';

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
            <?php
                if (isset($_GET['update']) && $_GET['update'] == "err") {
                    echo '<h3 style="color: red"> Unable to update product quantity. Please try again later. </h3>';
                }
                if (isset($_GET['order']) && $_GET['order'] == "err") {
                    echo '<h3 style="color: red"> There was a problem submitting your order. Please try again later. </h3>';
                }
                if ((isset($_POST['checkout'])) && $_POST['checkout'] == "go") {
                    echo '<div style="margin: 10px 0px 10px 0px"> <h1>Checkout</h1> <div>';
                } else {
                    echo '<div style="margin: 10px 0px 10px 0px"> <h1>Shopping Cart</h1> <div>';
                }
            ?>

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
                                            $citemId = $row['CITEM_ID'];
                                            $bookId = $row['BOOK_ID'];
                                            $quantity = $row['ITEM_QUANTITY'];
                                            
                                            $tsql = "SELECT B.BOOK_TITLE, B.BOOK_ISBN, B.PRICE, BI.IMAGE_LINK, PI.INV_QUANTITY
                                                     FROM BOOKS B 
                                                     INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
                                                     INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID
                                                     WHERE B.BOOK_ID = '$bookId'";

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
                                                if (!(isset($_POST['checkout'])) && $_POST['checkout'] != "go") {
                                                    echo '           <a href="https://php-back2books.azurewebsites.net/removeCartItem.php?p='.$citemId.'">Remove</a>';
                                                }
                                                echo '        </td>';
                                                echo '        <td class="" style="text-align: left;"><p>$ '.$row['PRICE'].'</p></td>';
                                                echo '        <td class="" style="text-align: left;">';
                                                if ((isset($_POST['checkout'])) && $_POST['checkout'] == "go") {
                                                    echo '<p>'.$row['INV_QUANTITY'].'</p>';
                                                } else {
                                                    echo '        <form method="post" action="">';
                                                    echo '                  <input type="hidden" name="citemId" value="'.$citemId.'">';
                                                    echo '                  <input type="hidden" name="productId" value="'.$bookId.'">';
                                                    echo '            <input type="number" name="quantity" min="1" max="'.$row['INV_QUANTITY'].'" value="'.$quantity.'" required>';
                                                    echo '            <button type="submit" name="update" value="update">Update</button>';
                                                    echo '         </form>';
                                                }
                                                
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
                                    echo '</form>';
                                    echo '<div>';
                                    if (!(isset($_POST['checkout'])) && $_POST['checkout'] != "go") {
                                        echo '<form method="post" action="">';
                                        echo '    <input type="text" name="discountCode" placeholder="Discount Code" value="'.$_SESSION['discountCode'].'"></input>';
                                        echo '    <button type="submit" name="coupon" value="apply">Apply</button>';
                                        echo '</form>';
                                    }
                                    echo '</div>';
                                    echo '<div> <h3>SUBTOTAL: $ '.number_format($subtotal, 2).'</h3></div>';    
                                    $_SESSION['DISCOUNT'] = ($subtotal * $_SESSION['discountValue']);
                                    echo '<div><h3>DISCOUNT: - $ '.number_format($_SESSION['DISCOUNT'], 2).'</h3></div>';                                    
                                    echo '<div><h3>TAX (8.25%): $'.number_format(($subtotal * 0.0825), 2).' </h3></div>';
                                    echo '<div><h3>SHIPPING: $ '.$shipping.'</h3></div>';
                                    echo '<div><h3>TOTAL: $ '.number_format(($subtotal - ($subtotal * $_SESSION['discountValue']) + ($subtotal * 0.0825) + $shipping), 2).'</h3></div>';
                                    if (!(isset($_POST['checkout'])) && $_POST['checkout'] != "go") {
                                        echo '<div><button type="submit" value="go" name="checkout">CHECKOUT</button></div>';
                                    }
                                    echo '<div class="">';
                                }            
                    echo '</div>';  
                    
                    if ((isset($_POST['checkout'])) && $_POST['checkout'] == "go") {
                        echo '<div class="checkout">';
                        echo '<div style="margin: 10px 0px 10px 0px"> <h1>Shipping/Billing Information</h1> <div>';
                        echo '<form name="shippingInfo" id="shippingInfo" method="post" action="">';
                        
                        // <!-- StreetAddress1 input -->
                        echo '                        
                        <div class="form-group">
                            <label for="streetAddress1">Street Address: </label>
                            <input name="streetAddress1" type="text" class="form-control" id="streetAddress1" placeholder="Street Address" required>
                            <p id="streetAddress1Status"></p>
                        </div>';
                        
                         // <!-- StreetAddress2 input -->
                        echo '
                        <div class="form-group">
                            <label for="streetAddress2">Street Address 2: </label>
                            <input name="streetAddress2" type="text" class="form-control" id="streetAddress2" placeholder="(Optional)">
                            <p id="streetAddress2Status"></p>
                        </div>';

                        // <!-- City input -->
                        echo '
                        <div class="form-group">
                            <label for="city">City: </label>
                            <input name="city" type="text" class="form-control" id="city" placeholder="City">
                            <p id="cityStatus"></p>
                        </div>';

                        // <!-- State input -->
                        echo '
                        <div class="form-group">
                        <label for="state">State: </label>
                        <select name="state" id="state">
                                <option selected value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming </option>
                        </select>
                        </div>';

                        // <!-- Zipcode input -->
                        echo '
                        <div class="form-group">
                            <label for="zipCode">Zipcode: </label>
                            <input id="zipCode" maxlength="5" name="zipCode" type="text">
                        </div>';

                        // <!-- Payment Method input -->
                        echo '<div class="form-group">
                            <label for="payment">Payment Method: </label>
                            <select name="payment" id="payment">
                                <option selected value="CREDIT CARD">CREDIT CARD</option>
                                <option value="PAYPAL">PAYPAL</option>
                                <option value="GOOGLE PAY">GOOGLE PAY</option>
                                <option value="AMAZON PAY">AMAZON PAY</option>
                                <option value="APPLE PAY">APPLE PAY</option>
                            </select>
                        </div>';

                        // <!-- Submit button input -->
                        echo '<div><button type="submit" value="go" name="placeOrder">PLACE ORDER</button></div>';
                        echo '</form>';
                        echo '</div>';
                    }
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