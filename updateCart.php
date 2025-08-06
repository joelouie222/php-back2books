<?php
    session_start();
    include('functions.php');
    include('config.php');
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        

    }
    // redirect("https://php-back2books.azurewebsites.net/");
    redirect($HOME);
?>