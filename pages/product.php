<?php
    session_start();
    include('../functions.php');
?>

<?php
                    // echo '<p> SESSION-loggedIn: '.$_SESSION["loggedIn"].'<p>';
                    // echo '<p> SESSION-userId: '.$_SESSION["userId"].'<p>';
                    // echo '<p> SESSION-USER_FNAME: '.$_SESSION["fname"].'<p>';
                    // echo '<p> SESSION-USER_LNAME: '.$_SESSION['lname'].'<p>';
                    // echo '<p> SESSION-USER_ADMIN: '.$_SESSION["admin"].'<p>';
                    // echo '<p> SESSION-loginEmail: '.$_SESSION["loginEmail"].'<p>';
                    // echo '<p> SESSION-hashedPassword: '.$_SESSION["hashedPassword"].'<p>';
                    if((isset($_POST['submit'])) && $_POST['submit']=="ADDTOCART") {
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
                            echo '$_POST[cartBookID] = '.$_POST['cartBookID'];

                            $bookId = $_POST['cartBookID'];
                            $userId = $_SESSION["userId"];

                            // CHECK IF BOOK ID IS ALREADY IN CART
                            $tsql = "SELECT CITEM_ID, BOOK_ID FROM CART_ITEMS WHERE CART_ID = (SELECT CART_ID FROM CART WHERE USER_ID = '$userId')";

                            $getCart = sqlsrv_query($conn, $tsql);
                            if ($getCart === false) {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            }
                            

                            // IF THERE ARE ITEMS IN CART - FIND BOOK ID, it ITS IN THE CART THEN UPDATE ELSE INSERT ITEM
                            if (sqlsrv_has_rows($getCart)) {
                                while($row = sqlsrv_fetch_array($getCart, SQLSRV_FETCH_ASSOC)){
                                    if ($row['BOOK_ID'] == $bookId) {
                                        $cartItemId = $row['CITEM_ID'];
                                        $tsql = "UPDATE CART_ITEMS SET ITEM_QUANTITY = (ITEM_QUANTITY + 1) WHERE CITEM_ID = '$cartItemId'";
                                        $updateCart = sqlsrv_query($conn, $tsql);
                                        if ($updateCart === false) {
                                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                        }
                                        $bookId = "";
                                        $cartItemId = "";
                                        redirect("https://php-back2books.azurewebsites.net/pages/catalog.php");
                                    }
                                }
                                $tsql = "INSERT INTO CART_ITEMS (CART_ID, BOOK_ID, ITEM_QUANTITY, PRICE) 
                                        VALUES ((SELECT CART_ID FROM CART WHERE USER_ID = '$userId'), '$bookId', 1, (SELECT PRICE FROM BOOKS WHERE BOOK_ID = '$bookId')) ";             
                                $addBookToCart = sqlsrv_query($conn, $tsql);
                                if ($addBookToCart === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                }
                                redirect("https://php-back2books.azurewebsites.net/pages/catalog.php");
                            } else {  // IF THERE ARE NOTHING IN CART, INSERT ITEM
                                $tsql = "INSERT INTO CART_ITEMS (CART_ID, BOOK_ID, ITEM_QUANTITY, PRICE) 
                                VALUES ((SELECT CART_ID FROM CART WHERE USER_ID = '$userId'), '$bookId', 1, (SELECT PRICE FROM BOOKS WHERE BOOK_ID = '$bookId')) ";             
                                $addBookToCart = sqlsrv_query($conn, $tsql);
                                if ($addBookToCart === false) {
                                    die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                }
                                redirect("https://php-back2books.azurewebsites.net/pages/catalog.php");
                            }
                        } else { // NOT LOGGED IN
                            redirect("https://php-back2books.azurewebsites.net/pages/login.php");
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
    <link rel="stylesheet" href="../logo-style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<h1>Product page</h1>

<div class="container">
    <?php
$isbn = $_GET['isbn'];
$tsql = "SELECT * FROM BOOK B
    INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
    INNER JOIN AUTHOR_LIST AL ON B.BOOK_ID = AL.BOOK_ID
    INNER JOIN AUTHOR A ON AL.AUTHOR_ID = A.AUTHOR_ID
    INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID
    WHERE BOOK_ISBN LIKE '%$isbn%'";

$result = sqlsrv_query($conn, $tsql);

if ($result == false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    echo "<div class='book-container window'>
        <img class='search-cover' src=".$row['IMAGE_LINK']." alt='Book Cover'>
        <h1>".$row['BOOK_TITLE']."</h1>
        <p>".$row['author_fname'] . " ".$row['author_lname']. "</p>" .
        "<p>ISBN: ".$row['BOOK_ISBN']."</p>
        <p>Price: $".$row['PRICE']."</p>
        <p>Synopsis:</br>".$row['PROD_DESC']."</p>
        </br>
        <form method='post' action=''>
            <input name='cartBookID' type='hidden' value='".$row['BOOK_ID']."'>
            <div style='cursor: pointer;'><button name='submit' style='padding: 5px;' type='submit' value='ADDTOCART'> ADD TO CART </button></div>
        </form>
        </div>";
} 
?>
</div>

</html>