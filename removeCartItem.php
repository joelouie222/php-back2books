<?php
    session_start();
    include('functions.php');
    include('config.php');
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        if (isset($_GET['p']))
        { 
            $itemId = $_GET['p'];
            $tsql = "DELETE FROM CART_ITEMS WHERE CITEM_ID = '$itemId'";
            $removeItem = sqlsrv_query($conn, $tsql);
            if ($removeItem == false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                echo "Row deleted successfully.";
            }
            //redirect("https://php-back2books.azurewebsites.net/pages/cart.php");
        }
        //redirect("https://php-back2books.azurewebsites.net/pages/cart.php");
    }
    //redirect("https://php-back2books.azurewebsites.net/");
?>