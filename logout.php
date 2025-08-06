<?php
    session_start();
    include('functions.php');
    include('config.php');
    session_unset();
    session_destroy();
    // redirect("https://php-back2books.azurewebsites.net/");
    redirect($HOME);
    exit;
?>