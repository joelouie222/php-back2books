<?php
    echo '<header class="header">';
    echo '<div class="logo-container">';
    echo '  <a href="/"><img src="/images/b2b-logo-header.png" width="549" height="142" alt="Back to Books Logo"></a>';
    echo '</div>';
    echo '<div class="search-container">';
    echo '    <input type="text" placeholder="Search..." name="search" size="40">';
    echo '    <button type="submit"><i class="fa fa-search fa-2x"></i></button>';
    echo '</div>';
    echo '  <div class="favorites-container"><a href="/pages/favorites.php"><i class="fa fa-heart fa-4x"></i></a></div>';
    echo '  <div class="cart-container"><a href="/pages/cart.php"><i class="fa fa-cart-arrow-down fa-4x"></i></a></div>';
    echo '</header>';

    echo '<div class="sidebar">';
    
    if (isset($_SESSION["loggedIn"]) AND $_SESSION["loggedIn"] == true){
        if (isset($_SESSION["admin"]) AND $_SESSION["admin"] == 1) {
            echo '<a Welcome Back ADMIN, '.$_SESSION['fname'].' '.$_SESSION['lname'].'!</a>';
            echo '<a href=""><i class=""></i> VIEW ORDERS </a>';
            echo '<a href=""><i class=""></i> VIEW USERS </a>';
            echo '<a href=""><i class=""></i> VIEW PRODUCTS </a>';
            echo '<a href=""><i class=""></i> VIEW COUPONS </a>';
            echo '<a href="/logout.php"><i class=""></i> Log Out </a>';
        } else {
            echo '<a Wecome back, '.$_SESSION['fname'].' '.$_SESSION['lname'].'!</a>';
            echo '<a href=""><i class=""></i> Edit Profile </a>';
            echo '<a href=""><i class=""></i> My Orders </a>';
            echo '<a href="/logout.php"><i class=""></i> Log Out </a>';
        }
    } else {
        echo '  <a href="/pages/login.php"><i class="fa fa-fw fa-sign-in"></i> Sign In</a>';
        echo '  <a href="/pages/register.php"><i class="fa fa-fw fa-address-card"></i> Register </a>';
    }
    echo '  <a href="/pages/catalog.php"><i class="fa fa-fw fa-book"></i> Catalog </a>';
    echo '  <a href="/pages/marketplace.php"><i class="fa fa-fw fa-usd"></i> Marketplace </a>';
    echo '  <a href="/pages/selling.php"><i class="fa fa-fw fa-money"></i> Selling</a>';
    echo '  <a href="/pages/promotion.php"><i class="fa fa-fw fa-tag"></i> Promotions</a>';
    echo '  <a href="/pages/about.php"><i class="fa fa-fw fa-info-circle"></i> About Us </a>';
    echo '  <a href="/pages/contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a>';
    echo '</div>';
?>