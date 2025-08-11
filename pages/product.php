<?php
    session_start();
    include('../functions.php');
    include('../config.php');
?>

<?php
    // ===========================================================
    // ADD TO CART LOGIC (SAME AS IN CATALOG PAGE)
    // ===========================================================
    if((isset($_POST['submit'])) && $_POST['submit']=="ADDTOCART") {
        // Check if the user is logged in
        // If logged in, add book to cart
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {

            // Get the book ID from the form
            $bookId = $_POST['cartBookID'];
            $userId = (int) $_SESSION['userId'];

            // CHECK IF BOOK ID IS ALREADY IN CART
            $tsql = "SELECT citem_id, book_id FROM cart_items WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";
            $getCart = sqlsrv_query($conn, $tsql, array($userId));

            if ($getCart === false) {
                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
            }
            
            // IF THERE ARE ITEMS IN CART - FIND BOOK ID, it ITS IN THE CART THEN UPDATE ELSE INSERT ITEM
            if (sqlsrv_has_rows($getCart)) {
                while($row = sqlsrv_fetch_array($getCart, SQLSRV_FETCH_ASSOC)){

                    // IF BOOK ID IS IN CART, UPDATE ITEM QUANTITY
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
        } else { // NOT LOGGED IN redirect to login page
            redirect($HOME."pages/login.php");
        }
    }
?>
<!DOCTYPE html>
<?php
    include '../layout.php';
?>
<html lang="us">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- OUR CSS -->
    <link rel="stylesheet" href="../style.css">
    <!-- <link rel="stylesheet" href="../logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.ico">
</head>

    <h1>Product page</h1>

    <div class="container">
        <?php
            $isbn = $_GET['isbn'];

            // remote invalid sql characters
            $isbn = preg_replace('/[^a-zA-Z0-9]/', '', $isbn);

            // change to exact query to get book details
            $tsql = "SELECT * FROM book B
                INNER JOIN book_image BI ON B.book_id = BI.book_id
                INNER JOIN author_list AL ON B.book_id = AL.book_id
                INNER JOIN author A ON AL.author_id = A.author_id
                INNER JOIN product_inventory PI ON PI.book_id = B.book_id
                WHERE book_isbn = ?";

            $params = array($isbn);
            $result = sqlsrv_query($conn, $tsql, $params);

            // if query fails or returns no results
            if ($result === false || sqlsrv_has_rows($result) === false) {
                echo "<div class='book-container'><center>";
                echo "<h2 style='color: red;'>Book not found.</h2>";
                // point to search page 
                echo "<br /><p><a href='".$HOME."pages/search.php'>Search for another book</a></p><br />";
                echo "</center></div>";
                die();
            }
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "<div class='book-container'><center>
                    <img class='search-cover' src='".htmlspecialchars($row['image_link'])."' alt='".htmlspecialchars($row['book_title'])." Book Cover'>
                    <h1>".htmlspecialchars($row['book_title'])."</h1>
                    <p>".htmlspecialchars($row['author_fname']) . " ".htmlspecialchars($row['author_lname']). "</p>" .
                    "<p>ISBN: ".htmlspecialchars($row['book_isbn'])."</p>
                    <p>Price: $".htmlspecialchars($row['price'])."</p>
                    </br>
                    <p>Synopsis:</br>".htmlspecialchars($row['prod_desc'])."</p>
                    </br>
                    <div style='margin-bottom: 1.5rem;'><form method='post' action=''>
                        <input name='cartBookID' type='hidden' value='".htmlspecialchars($row['book_id'])."'>
                        <div style='cursor: pointer;'><button name='submit' style='padding: 5px;' type='submit' value='ADDTOCART'> ADD TO CART </button></div>
                    </form></div>
                    </center></div>";
            }
        ?>
    </div>

</html>