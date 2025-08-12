<?php
    session_start();
    include('functions.php');
    include('config.php');
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && isset($_GET['p']))  {
        $userId = (int) $_SESSION['userId'];
        $cartItemId = (int) $_GET['p'];

        // DELETES cart item from cart, making sure that the cart belongs to the logged in user
        $tsql = "DELETE ci FROM cart_items AS ci
                JOIN cart AS c ON ci.cart_id = c.cart_id
                WHERE ci.citem_id = ? AND c.user_id = ?";
        $params = array($cartItemId, $userId);
        $stmt = sqlsrv_query($conn, $tsql, $params);

        $rowsAffected = sqlsrv_rows_affected($stmt);

        // Check for query error or number or rows affected
        if (($rowsAffected === false) || ($rowsAffected === 0)) {
            redirect($HOME."pages/cart.php?rem=err");
        } else {
            // Success! One row was deleted.
            redirect($HOME."pages/cart.php");
        }
    } else {
        redirect($HOME);
    }
?>