<?php
    session_start();
    include('functions.php');
    session_unset();
    session_destroy();
    redirect("https://php-back2books.azurewebsites.net/");
    exit;
?>