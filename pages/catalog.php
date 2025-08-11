<?php
  session_start();
?>
<!DOCTYPE html>
<html>

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
    <link rel="icon" type="image/x-icon" href="../images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php 
        include('../layout.php');
        include('../functions.php');
    ?>  
      
    <div class="container">
        <div class="products">
            <center>
                <h1> Book Catalog </h1>
                <?php
                    // ===========================================================
                    // ADD TO CART LOGIC (SAME AS IN PRODUCT PAGE)
                    // ===========================================================
                    if((isset($_POST['submit'])) && $_POST['submit']=="ADDTOCART") {
                        // IF USER IS LOGGED IN
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                            $bookId = $_POST['cartBookID'];
                            $userId = (int) $_SESSION['userId'];

                            // CHECK IF BOOK ID IS ALREADY IN CART
                            $tsql = "SELECT citem_id, book_id FROM cart_items WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";
                            $params = array($userId);
                            $getCart = sqlsrv_query($conn, $tsql, $params);

                            if ($getCart === false) {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            }
                            
                            // IF THERE ARE ITEMS IN CART - FIND BOOK ID, it ITS IN THE CART THEN UPDATE ELSE INSERT ITEM
                            if (sqlsrv_has_rows($getCart)) {
                                // Loop through the cart items to check if the book is already in the cart
                                while($row = sqlsrv_fetch_array($getCart, SQLSRV_FETCH_ASSOC)){

                                    // BOOK_ID IS ALREADY IN CART, UPDATE ITEM QUANTITY
                                    if ($row['book_id'] == $bookId) {
                                        $tsql = "UPDATE cart_items SET item_quantity = (item_quantity + 1) WHERE citem_id = ?";
                                        $params = array($row['citem_id']);
                                        $updateCart = sqlsrv_query($conn, $tsql, $params);
                                        if ($updateCart === false) {
                                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                        }
                                        $bookId = "";
                                        $cartItemId = "";
                                        redirect($HOME."pages/cart.php");
                                    }
                                }

                                // IF BOOK ID IS NOT IN CART, INSERT ITEM
                                $tsql = "INSERT INTO cart_items (cart_id, book_id, item_quantity, price) 
                                        VALUES ((SELECT cart_id FROM cart WHERE user_id = ?), ?, 1, (SELECT price FROM book WHERE book_id = ?))";             
                                $params = array($userId, $bookId, $bookId);
                                $addBookToCart = sqlsrv_query($conn, $tsql, $params);
                                
                                if ($addBookToCart === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                }
                                redirect($HOME."pages/cart.php");

                            } else {  // IF THERE ARE NOTHING IN CART, INSERT ITEM
                                $tsql = "INSERT INTO cart_items (cart_id, book_id, item_quantity, price) 
                                VALUES ((SELECT cart_id FROM cart WHERE user_id = ?), ?, 1, (SELECT price FROM book WHERE book_id = ?))";             
                                $params = array($userId, $bookId, $bookId);
                                $addBookToCart = sqlsrv_query($conn, $tsql, $params);

                                if ($addBookToCart === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                }

                                redirect($HOME."pages/cart.php");
                            }
                        } else { // NOT LOGGED IN REDIRECT TO LOGIN PAGE
                            redirect($HOME."pages/login.php");
                        }
                    }

                    // ===========================================================
                    // ADD TO FAVORITES LOGIC
                    // ===========================================================
                    // FUTURE IMPLEMENTATION
                ?>

            
            <!-- SORTING OPTIONS -->
            <div style=" margin: 0px 50px 20px 0px;"><form method="post" action="">
                    <span><label for="sortVal">Sort by: </label></span>
                    <span><select name="sortVal" id="sortBy">
                        <option selected value=""> - </option>
                        <option value="priceDesc"> Price Descending </option>
                        <option value="priceAsc"> Price Ascending </option>
                        <option value="availDesc"> Availability Descending </option>
                        <option value="availAsc"> Availability Acending </option>
                    </select></span>
                    <span><button type="submit" name="sortBtn" value="apply">APPLY</button></span>
                </select></form></div>
            </center>

            <ol class="book-list-view">
                <?php
                    // DEFAULT SQL QUERY TO GET BOOKS
                    $sortSQL = "SELECT TOP (100) * FROM book B
                    INNER JOIN book_image BI ON B.book_id = BI.book_id
                    INNER JOIN author_list AL ON B.book_id = AL.book_id
                    INNER JOIN author A ON AL.author_id = A.author_id
                    INNER JOIN product_inventory PI ON PI.book_id = B.book_id";

                    if (isset($_POST['sortBtn']) && $_POST['sortBtn'] == "apply") {
                        switch ($_POST['sortVal']) {
                            case "priceDesc":
                                $sortSQL = "SELECT TOP (100) * FROM book B
                                INNER JOIN book_image BI ON B.book_id = BI.book_id
                                INNER JOIN author_list AL ON B.book_id = AL.book_id
                                INNER JOIN author A ON AL.author_id = A.author_id
                                INNER JOIN product_inventory PI ON PI.book_id = B.book_id
                                ORDER BY price DESC";
                                break;
                            case "priceAsc":
                                $sortSQL = "SELECT TOP (100) * FROM book B
                                INNER JOIN book_image BI ON B.book_id = BI.book_id
                                INNER JOIN author_list AL ON B.book_id = AL.book_id
                                INNER JOIN author A ON AL.author_id = A.author_id
                                INNER JOIN product_inventory PI ON PI.book_id = B.book_id
                                ORDER BY price";
                                break;
                            case "availDesc":
                                $sortSQL = "SELECT TOP (100) * FROM book B
                                INNER JOIN book_image BI ON B.book_id = BI.book_id
                                INNER JOIN author_list AL ON B.book_id = AL.book_id
                                INNER JOIN author A ON AL.author_id = A.author_id
                                INNER JOIN product_inventory PI ON PI.book_id = B.book_id
                                ORDER BY inv_quantity DESC";
                                break;
                            case "availAsc":
                                $sortSQL = "SELECT TOP (100) * FROM book B
                                INNER JOIN book_image BI ON B.book_id = BI.book_id
                                INNER JOIN author_list AL ON B.book_id = AL.book_id
                                INNER JOIN author A ON AL.author_id = A.author_id
                                INNER JOIN product_inventory PI ON PI.book_id = B.book_id
                                ORDER BY inv_quantity";
                                break;
                            default:
                                $sortSQL  = "SELECT TOP (100) * FROM book B
                                INNER JOIN book_image BI ON B.book_id = BI.book_id
                                INNER JOIN author_list AL ON B.book_id = AL.book_id
                                INNER JOIN author A ON AL.author_id = A.author_id
                                INNER JOIN product_inventory PI ON PI.book_id = B.book_id";
                        }
                      }

                    // Execute the SQL query
                    $tsql = $sortSQL;
                    $getBooks = sqlsrv_query($conn, $tsql);

                    if($getBooks == false ) {  
                        echo "Error in statement preparation/execution.\n";  
                        die( print_r( sqlsrv_errors(), true));
                    }
                    $count = 1;
                    while($row = sqlsrv_fetch_array($getBooks, SQLSRV_FETCH_ASSOC)) {
                        // Check if the book's image link is empty OR not a valid URL format 
                        if (empty($row['image_link']) || !filter_var($row['image_link'], FILTER_VALIDATE_URL)) {
                            $row['image_link'] = $HOME . 'images/default-book-image.png';
                        }
                        echo '<li style="border: solid; margin: 15px 10px; padding: 5px">';
                        echo '    <div style="margin-left: 0; margin-right: 0; display: flex;">';
                        echo '        <div style="align-items: center; width: 20%; display: flex">';
                        echo '            <div style="margin: 10px"><h2>'.$count.'</h2></div>';
                        echo '            <div style="margin: 10px">';
                        echo "                <a href=/pages/product.php?isbn=" .urlencode($row['book_isbn']) .">";
                        echo '                    <img src="'.htmlspecialchars($row['image_link']).'" alt="Image of Book '.htmlspecialchars($row['book_title']).'" height="200" width="150" >';
                        echo '                </a>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div style="width: 80%; display: flex; flex-direction: column;">';
                        echo '            <div style="margin: 5px 0 5px 0;"><span><h1>'.htmlspecialchars($row['book_title']).'</h1></span><span>('.htmlspecialchars($row['book_published_date']->format('Y-m-d')).')</span></h3></div>';
                        echo '            <div><span style="margin-right: 20px;">Author:&nbsp;&nbsp;&nbsp;<strong>'.htmlspecialchars($row['author_fname']).' '.htmlspecialchars($row['author_lname']).'</strong></span><span>Publisher:&nbsp;&nbsp;&nbsp;<strong>'.htmlspecialchars($row['publisher_name']).'</strong></span></div>';
                        echo '            <div style="margin: 5px 0px 0px 0px; height: 150px; overflow-x: hidden; overflow-y: auto;">'.htmlspecialchars($row['prod_desc']).'</div>';
                        echo '            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between; align-items: flex-end;">';
                        echo '                <div style="width: 60%;">';
                        echo '                    <table style="width: 100%;">';
                        echo '                        <thead>';
                        echo '                            <tr style="border-bottom: 1px solid; border-top: 1px solid;">';
                        echo '                                <th>ISBN-13</th>';
                        echo '                                <th>Format</th>';
                        echo '                                <th>Pages</th>';
                        echo '                                <th>Stock</th>';
                        // echo '                                <th>price</th>';
                        echo '                            </tr>';
                        echo '                        </thead>';
                        echo '                        <tbody>';
                        echo '                            <tr>';
                        echo '                                <td>'.htmlspecialchars($row['book_isbn']).'</td> ';
                        echo '                                <td>'.htmlspecialchars($row['book_format']).'</td>';
                        echo '                                <td>'.htmlspecialchars($row['num_pages']).'</td>';
                        echo '                                <td>'.htmlspecialchars($row['inv_quantity']).'</td>';
                        // echo '                                <td>'.htmlspecialchars($row['price']).'</td>';
                        echo '                            </tr>';
                        echo '                        </tbody>';
                        echo '                    </table>';
                        echo '                </div>';
                        echo '                <div><h1>$ '.htmlspecialchars($row['price']).'</h1></div>  ';

                        // ADD TO FAVORITES BUTTONS
                        echo '                <div style="display: flex; align-items: flex-end;">';
                        echo '                   <div>
                                                    <form method="post" action="">
                                                        <input name="favBookID" type="hidden" value="'.$row['book_id'].'">
                                                        <div style="margin-right: 10px; cursor: pointer;"><button style="border: none; background-color: antiquewhite;" name="submit" type="submit" value="ADDTOFAV"><i class="fa fa-heart fa-2x"></i></button></div>
                                                    </form>
                                                </div>';  
                                                
                        // ADD TO CART BUTTONS
                        echo '                   <div>
                                                    <form method="post" action="">
                                                        <input name="cartBookID" type="hidden" value="'.$row['book_id'].'">
                                                        <div style="cursor: pointer;"><button name="submit" style="padding: 5px;" type="submit" value="ADDTOCART"> ADD TO CART </button></div>
                                                    </form>
                                                </div>';
                        echo '                </div>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div> ';
                        echo '</li>';
                        $count++;
                    }
                    sqlsrv_free_stmt($getBooks);
                ?>
            </ol>
        </div>


    </div>



</body>

</html>
