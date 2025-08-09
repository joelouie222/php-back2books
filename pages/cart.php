<?php
  session_start();
  if (!isset($_SESSION['discountValue'])) {
      $_SESSION['discountValue'] = 0;
  }
  if (!isset($_SESSION['discountCode'])) {
      $_SESSION['discountCode'] = '';
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Back2Books</title>

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
    <div class="container">
        <?php 
            include('../layout.php');
            include('../functions.php');

            echo '<div class="cart">';
            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {

                $userId = (int) $_SESSION['userId'];

                //=============================================================
                // UPDATE CART ITEMS LOGIC
                //=============================================================
                if ((isset($_POST['update'])) && $_POST['update'] == "update") {
                    $cartItemId = (int) $_POST['citemId'];
                    $newQuantity = (int) $_POST['quantity'];

                    $tsql = "UPDATE cart_items SET item_quantity = ? WHERE citem_id = ?";

                    $updateCart = sqlsrv_query($conn, $tsql, array($newQuantity, $cartItemId));

                    if ($updateCart === false) {
                        redirect($HOME."pages/cart.php?update=err");
                    }

                    // On successful update, refresh the cart
                    $newQuantity = "";
                    $cartItemId = "";
                    redirect($HOME."pages/cart.php");
                }

                //=============================================================
                // APPLY DISCOUNT CODE LOGIC
                //=============================================================
                if (isset($_POST['coupon']) && isset($_POST['discountCode'])) {
                    $discountCode = $_POST['discountCode'];

                    $tsql_get_discount = "SELECT discount_code, discount_value FROM discount WHERE ACTIVE = 1 AND discount_code = ?";
                    $getDiscount = sqlsrv_query($conn, $tsql_get_discount, array($discountCode));

                    if ($getDiscount && sqlsrv_has_rows($getDiscount)) {
                        $row = sqlsrv_fetch_array($getDiscount, SQLSRV_FETCH_ASSOC);
                        $_SESSION['discountCode'] = $row['discount_code'];
                        $_SESSION['discountValue'] = (float) $row['discount_value'];
                    } else {
                        $_SESSION['discountCode'] = "Invalid Code";
                        $_SESSION['discountValue'] = 0;
                    }
                }

                //=============================================================
                // PLACE ORDER LOGIC
                //=============================================================
                if ((isset($_POST['placeOrder'])) && $_POST['placeOrder'] == "go") {

                    // Define variables that will be used to create the order
                    $address = ''.$_POST['streetAddress1'].', '.$_POST['streetAddress2'].', '.$_POST['city'].', '.$_POST['state'].' '.$_POST['zipCode'].'';
                    $payment = $_POST['payment'];
                    $currentDate = date('Y-m-d H:i:s');
                    $orderDiscount = (float) $_SESSION['discount'];

                    // Prepare parametized query to prevent SQL injection
                    $tsql_insert_order = "INSERT INTO [order] (user_id, order_date, order_discount, ship_addr, pay_method, bill_addr) VALUES (?, ?, ?, ?, ?, ?)";

                    // create an array of parameters in correct order
                    $params = array($userId, $currentDate, $orderDiscount, $address, $payment, $address);

                    // Execute the query
                    $addOrder = sqlsrv_query($conn, $tsql_insert_order, $params);

                    if($addOrder === false) {
                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                        redirect($HOME."pages/cart.php?order=err");
                    } else {
                        // GET THE ORDER ID
                        $tsql_get_id = "SELECT TOP (1) order_id FROM [order] WHERE USER_ID = ? ORDER BY order_date DESC";
                        $getOrderId = sqlsrv_query($conn, $tsql_get_id, array($userId));

                        if ($getOrderId === false) {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            redirect($HOME."pages/cart.php?order=err");
                        }

                        if ($orderRow = sqlsrv_fetch_array($getOrderId, SQLSRV_FETCH_ASSOC)) {
                            $orderId = $orderRow['order_id'];

                            // GET CART ITEMS 
                            $tsql_cart = "SELECT * FROM cart_items WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";
                            $orderCart = sqlsrv_query($conn, $tsql_cart, array($userId));

                            if ($orderCart === false) {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                redirect($HOME."pages/cart.php?order=err");
                            }

                            // LOOP THROUGH CART ITEMS AND ADD THEM TO ORDER LINES
                            while($cartRow = sqlsrv_fetch_array($orderCart, SQLSRV_FETCH_ASSOC)) {
                                // CHECK IF ITEM QUANTITY IS ZERO OR LESS
                                if (empty($cartRow['item_quantity']) || $cartRow['item_quantity'] <= 0) {
                                    die("Item quantity is zero or less. Cannot process order for this item.");
                                    continue; 
                                }

                                // Get the book ID and quantity to process
                                $bookIdToProcess = $cartRow['book_id'];
                                $quantityToProcess = $cartRow['item_quantity'];

                                // Get the price of the book table
                                $tsql_price = "SELECT price FROM book WHERE book_id = ?";
                                $stmt_price = sqlsrv_query($conn, $tsql_price, array($bookIdToProcess));

                                if ($stmt_price === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    redirect($HOME."pages/cart.php?order=err");
                                }

                                $bookPrice = 0; // Default price
                                if ($priceRow = sqlsrv_fetch_array($stmt_price, SQLSRV_FETCH_ASSOC)) {
                                    $bookPrice = $priceRow['price'];
                                }

                                sqlsrv_free_stmt($stmt_price);

                                // INSERT ORDER LINE 
                                $tsql_order_line = "INSERT INTO order_lines (order_id, book_id, price, order_quantity) VALUES (?, ?, ?, ?)";
                                $params_order_line = array($orderId, $bookIdToProcess, $bookPrice, $quantityToProcess);
                                $addOrderLine = sqlsrv_query($conn, $tsql_order_line, $params_order_line);

                                if ($addOrderLine === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    redirect($HOME."pages/cart.php?order=err");
                                }

                                // UPDATE STOCK in PRODUCT INVENTORY (NEED BOOK ID)
                                $tsql_inv = "UPDATE product_inventory SET inv_quantity = (inv_quantity - ?) WHERE book_id = ?";
                                $params_inv = array($quantityToProcess, $bookIdToProcess);
                                $updateProductQty = sqlsrv_query($conn, $tsql_inv, $params_inv);

                                if ($updateProductQty === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    redirect($HOME."pages/cart.php?order=err");
                                }

                                // DELETE CART ITEMS (NEED CITEM_ID)
                                $tsql_del = "DELETE FROM cart_items WHERE citem_id = ?";
                                $params_del = array($cartRow['citem_id']);
                                $deleteCI = sqlsrv_query($conn, $tsql_del, $params_del);

                                if ($deleteCI === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information                                
                                    redirect($HOME."pages/cart.php?order=err");
                                }
                            }

                            sqlsrv_free_stmt($getOrderId);
                            sqlsrv_free_stmt($orderCart);
                            // ORDER CREATION SUCCESS REDIRECT TO MY ORDERS
                            $_SESSION['discountValue'] = 0;
                            $_SESSION['discount'] = "";
                            $_SESSION['discountCode'] = "";
                            $_SESSION['numInCart'] = "";
                            redirect($HOME."pages/myOrders.php?order=success");
                        } else {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            redirect($HOME."pages/cart.php?order=err");
                        }
                    }   
                }                    
            } else { // NOT LOGGED IN redirect to login page
                redirect($HOME."pages/login.php");
            }
            echo '</div>';
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
                        
                        // =============================================================
                        // DISPLAY CART CONTENTS
                        // =============================================================
                        if (!isset($_SESSION['numInCart']) || $_SESSION['numInCart'] == 0) {
                            echo '<tr><td colspan="5" style="text-align:center;"><h3> You have no products added in your Shopping Cart</h3></td></tr>';
                        } else {
                            $subtotal = 0;

                            $tsql = "SELECT
                                    ci.citem_id,
                                    ci.item_quantity,
                                    b.book_id,
                                    b.book_title,
                                    b.book_isbn,
                                    b.price,
                                    bi.image_link,
                                    pi.inv_quantity
                                FROM cart_items ci
                                JOIN book b ON ci.book_id = b.book_id
                                JOIN book_image bi ON b.book_id = bi.book_id
                                JOIN product_inventory pi ON b.book_id = pi.book_id
                                WHERE ci.cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";

                            $getCartDetails = sqlsrv_query($conn, $tsql, array($userId));

                            if ($getCartDetails === false) {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            }
                            
                            while($row = sqlsrv_fetch_array($getCartDetails, SQLSRV_FETCH_ASSOC)) {
                                echo '<tr>';
                                echo '<td><img src="'.htmlspecialchars($row['image_link']).'" alt="Cover of '.htmlspecialchars($row['book_title']).'" height="100" width="75"></td>';
                                echo '<td>';
                                echo '<p>'.htmlspecialchars($row['book_title']).'</p>';
                                echo '<p> ISBN: '.htmlspecialchars($row['book_isbn']).'</p>';
                                echo '<p> Stock left: '.htmlspecialchars($row['inv_quantity']).'</p>';
                                echo '</br>';

                                if (!(isset($_POST['checkout'])) && $_POST['checkout'] != "go") {
                                    echo '<a href="'.$HOME.'removeCartItem.php?p='.urlencode($row['citem_id']).'">Remove</a>';
                                }
                                echo '</td>';

                                echo '<td style="text-align: left;"><p>$ '.number_format($row['PRICE'], 2).'</p></td>';
                                
                                echo '<td class="" style="text-align: left;">';
                                // If the user is checking out, display quantity as text
                                if ((isset($_POST['checkout'])) && $_POST['checkout'] == "go") {
                                    echo '<p>'.htmlspecialchars($row['item_quantity']).'</p>';
                                } else {
                                    echo '<form method="post" action="">';
                                    echo '<input type="hidden" name="citemId" value="'.htmlspecialchars($row['citem_id']).'">';
                                    echo '<input type="hidden" name="productId" value="'.htmlspecialchars($row['book_id']).'">';
                                    echo '<input type="number" name="quantity" min="1" max="'.htmlspecialchars($row['inv_quantity']).'" value="'.htmlspecialchars($row['item_quantity']).'" required>';
                                    echo '<button type="submit" name="update" value="update">Update</button>';
                                    echo '</form>';
                                }                                    
                                echo '</td>';

                                echo '<td style="text-align: right;"><p>$ '.number_format(($row['price'] * $row['item_quantity']), 2).'</p></td>';
                                echo '</tr>';
                                $subtotal += ($row['price'] * $row['item_quantity']);
                            }
                            sqlsrv_free_stmt($getCartDetails);
                        } 
                                                                    
                        echo '</tbody>';
                        echo '</table>';
                        echo '</form>';

                        // Coupon form
                        echo '<div>';
                        if (!(isset($_POST['checkout'])) && $_POST['checkout'] != "go") {
                            echo '<form method="post" action="">';
                            echo '<input type="text" name="discountCode" placeholder="Discount Code" value="'.htmlspecialchars($_SESSION['discountCode']).'"></input>';
                            echo '<button type="submit" name="coupon" value="apply">Apply</button>';
                            echo '</form>';
                        }                    
                        echo '</div>';
                        
                        // Total calculations
                        $_SESSION['discount'] = ($subtotal * $_SESSION['discountValue']);
                        $tax = $subtotal * 0.0825;
                        $shipping = ($subtotal > 0) ? 6.99 : 0;
                        $total = $subtotal - $_SESSION['discount'] + $tax + $shipping;

                        echo '<div><h3>SUBTOTAL: $ '.number_format($subtotal, 2).'</h3></div>';    
                        echo '<div><h3>DISCOUNT: - $ '.number_format($_SESSION['discount'], 2).'</h3></div>';  
                        echo '<div><h3>TAX (8.25%): $ '.number_format($tax, 2).' </h3></div>';
                        echo '<div><h3>SHIPPING: $ '.number_format($shipping, 2).'</h3></div>';
                        echo '<div><h3>TOTAL: $ '.number_format($total, 2).'</h3></div>';

                        if (!(isset($_POST['checkout'])) && $_POST['checkout'] != "go") {
                            echo '<div><button type="submit" value="go" name="checkout">CHECKOUT</button></div>';
                        }
                        
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
                                <input name="city" type="text" class="form-control" id="city" placeholder="City" required>
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
                                <input id="zipCode" maxlength="5" name="zipCode" type="text" required>
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
                    } else { // NOT LOGGED IN redirect to login page
                        // redirect("https://php-back2books.azurewebsites.net/pages/login.php");
                        redirect($HOME."pages/login.php");
                    }                    
                ?>
            </div>                   
        </div> <!-- End of cart div -->
    </div> <!-- End of container div -->
</body> <!-- End of body -->

<script src="js/scripts.js"></script>

</html>