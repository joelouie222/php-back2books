<?php
  session_start();
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
    <div class="cartpage-container">
        <?php include('../layout.php');
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
                    
            </div>
                
            <div>
                <form action="" method="post">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: left; padding: 10px 0px 10px 0px"><h3>Product<h3></th>
                                <th style="text-align: left;"><h3>Price</h3></th>
                                <th style="text-align: left;"><h3>Quantity<h3></th>
                                <th style="text-align: right;"><h3>Total</h3></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                                if ($_SESSION['numInCart'] == 0 )
                                    echo '<tr><td colspan="5" style="text-align:center;"><h3> You have no products added in your Shopping Cart</h3></td></tr>';
                                else {
                                    $tsql = "SELECT BOOK_ID, COUNT(BOOK_ID) AS quantity FROM CART_ITEMS WHERE CART_ID = (SELECT CART_ID FROM CART WHERE USER_ID = '$userId') GROUP BY BOOK_ID";

                                    $getCart = sqlsrv_query($conn, $tsql);

                                    if ($getCart === false) {
                                        die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                    } else {
                                        while($row = sqlsrv_fetch_array($getCart, SQLSRV_FETCH_ASSOC)) {
                                            $bookdId = $row['BOOK_ID'];
                                            $quantity = $row['quantity'];
                                            
                                            $tsql = "SELECT B.BOOK_TITLE, B.BOOK_ISBN, B.PRICE, BI.IMAGE_LINK FROM BOOKS B WHERE B.BOOK_ID = '$bookdId'
                                                     INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
                                                     INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID";

                                            $getBook = sqlsrv_query($conn, $tsql);

                                            if ($getBook != false) {
                                                while($row = sqlsrv_fetch_array($getBook, SQLSRV_FETCH_ASSOC)){
                                                echo '    <tr>';
                                                echo '        <td class="">';
                                                echo '            <img src="'.$row['BI.IMAGE_LINK'].'" alt="Image of Book '.$row['BOOK_TITLE'].'" height="100" width="75">';
                                                echo '        </td>';
                                                echo '        <td>';
                                                echo '            <p>'.$row['B.BOOK_TITLE'].'</p>';
                                                echo '            <p> ISBN: '.$row['B.BOOK_ISBN'].'</p>';
                                                echo '            <br>';
                                                echo '           <a href="">Remove</a>';
                                                echo '        </td>';
                                                echo '        <td class="" style="text-align: left;"><p>$ '.$row['B.PRICE'].'</p></td>';
                                                echo '        <td class="" style="text-align: left;">';
                                                echo '            <input type="" name="'.$row['$bookId'].'" min="1" max="" value="'.$quantity.'" required>';
                                                echo '        </td>';
                                                echo '        <td class="" style="text-align: right;"><p>$ '.number_format(($row['B.PRICE'] * $quantity), 2).'</p></td>';
                                                echo '    </tr>';
                                                }
                                            }
                                            sqlsrv_free_stmt($getBook);
                                        }   
                                    }                             
                                    sqlsrv_free_stmt($getCart);
                                }
                            }
                        ?>
                            
    
                            

                            <tr>
                                <td class="">
                                    <a href="">
                                        <img src="https://images.bwbcovers.com/006/To-Kill-a-Mockingbird-9780060935467.jpg" alt="Image of Book [BOOK_TITLE]" height="100" width="75">
                                    </a>
                                </td>
                                <td>
                                    <p> PRODUCT NAME </p>
                                    <p> </p>
                                    <br>
                                    <a href="" class="remove">Remove</a>
                                </td>
                                <td class="" style="text-align: left;"><p>$$$$</p></td>
                                <td class="" style="text-align: left;">
                                    <input type="" name="quantity-product['id']" value="1" min="1" max="product['quantity']" placeholder="Quantity" required>
                                </td>
                                <td class="" style="text-align: right;"><p>PRICE * NUMBER IN CART</p></td>
                            </tr>

                            <tr>
                                <td class="">
                                    <a href="">
                                        <img src="https://images.bwbcovers.com/006/To-Kill-a-Mockingbird-9780060935467.jpg" alt="Image of Book [BOOK_TITLE]" height="100" width="75">
                                    </a>
                                </td>
                                <td>
                                    <p> PRODUCT NAME </p>
                                    <br>
                                    <a href="" class="remove">Remove</a>
                                </td>
                                <td class="" style="text-align: left;"><p>$$$$</p></td>
                                <td class="" style="text-align: left;">
                                    <input type="" name="quantity-product['id']" value="1" min="1" max="product['quantity']" placeholder="Quantity" required>
                                </td>
                                <td class="" style="text-align: right;"><p>PRICE * NUMBER IN CART</p></td>
                            </tr>
                        </tbody>
                    </table>


                    <div class="">
                        <span class="text">Subtotal</span>
                        <span class="price">$$$$$></span>
                    </div>
                    <div class="">
                        <input type="submit" value="Update" name="update">
                        <input type="submit" value="Place Order" name="placeorder">
                    </div>
                </form>
            </div>
        </div>
        
        <div class="cart-summary">
                <div><span>SUBTOTAL: </span> <span> $$$$ </span> </div>
                <div><span>DISCOUNT: </span> <span> - $$$ </span> </div>
                <div><span>SHIPPING: </span> <span> $$$$ </span> </div>
                <div><span>TAX: </span> <span> $$$$ </span> </div>
                <div><span>SHIPPING: </span> <span> $$$$ </span> </div>
                <div><button>CHECK OUT</button></div>
        </div>
</body>

<script src="js/scripts.js"></script>

</html>