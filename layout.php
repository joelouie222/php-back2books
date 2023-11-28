<?php
    include('config.php');
    echo '<header class="header">';
    echo '<div class="logo-container">';
    echo '  <a href="/"><img src="/images/b2b-logo-header.png" width="549" height="142" alt="Back to Books Logo"></a>';
    echo '</div>';
    // echo '<div class="search-container">';
    // echo '    <input type="text" placeholder="Search..." name="search" size="40">';
    // echo '    <button type="submit"><i class="fa fa-search fa-2x"></i></button>';
    // echo '</div>';
    // echo '  <div class="favorites-container"><a href="/pages/favorites.php"><i class="fa fa-heart fa-4x"></i></a></div>';
    echo '  <div class="cart-container">';
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        $userId = $_SESSION["userId"];
        $tsql = "SELECT COUNT(DISTINCT BOOK_ID) AS numInCart FROM CART_ITEMS WHERE CART_ID = (SELECT CART_ID FROM CART WHERE USER_ID = '$userId')";
        $getCartNum = sqlsrv_query($conn, $tsql);

        $num = sqlsrv_fetch_array($getCartNum, SQLSRV_FETCH_ASSOC);
        if ($num != null) {
            $_SESSION['numInCart'] = $num['numInCart'];
            echo '<span class="cart-number">'.$num['numInCart'].'</span>';
        }
    }
    
    echo '            <a href="/pages/cart.php"><i class="fa fa-cart-arrow-down fa-4x"></i></a>
            </div>';
    echo '</header>';

    echo '<div class="sidebar">';
    
    echo '  <a href="/"><i class="fa fa-fw fa-home"></i> Home </a>';
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){
        if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
            echo '<p Welcome back ADMIN, '.$_SESSION['fname'].' '.$_SESSION['lname'].'!</p>';
            echo '<a href="/allOrders.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i> ALL ORDERS </a>';
            echo '<a href="/allUsers.php"><i class="fa fa-users" aria-hidden="true"></i>ALL USERS </a>';
            echo '<a href="/allProducts.php"><i class="fa fa-list-ol" aria-hidden="true"></i> ALL PRODUCTS </a>';
            echo '<a href="/allPromos.php"><i class="fa fa-tags" aria-hidden="true"></i>ALL COUPONS </a>';
            echo '<a href="/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out </a>';
        } else {
            echo '<p Wecome back, '.$_SESSION['fname'].' '.$_SESSION['lname'].'!</p>';
            // echo '<a href="/pages/editProfile.php"><i class=""></i> Edit Profile </a>';
            echo '<a href="/pages/myOrders.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i> My Orders </a>';
            // echo '<a href="/pages/selling.php"><i class="fa fa-fw fa-money"></i>My Listing</a>';
            echo '<a href="/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out </a>';
        }
    } else {
        echo '  <a href="/pages/login.php"><i class="fa fa-fw fa-sign-in"></i> Sign In</a>';
        echo '  <a href="/pages/register.php"><i class="fa fa-fw fa-address-card"></i> Register </a>';
    }
    echo '  <a href="/pages/catalog.php"><i class="fa fa-fw fa-book"></i> Catalog </a>';
    echo '  <a href="/pages/marketplace.php"><i class="fa fa-fw fa-usd"></i> Marketplace </a>';
    echo '  <a href="/pages/promotion.php"><i class="fa fa-fw fa-tag"></i> Promotions</a>';
    echo '  <a href="/pages/about.php"><i class="fa fa-fw fa-info-circle"></i> About Us </a>';
    echo '  <a href="/pages/contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a>';
    echo '</div>';
?>
