<?php
    include('/functions.php');
    if (isset($_SESSION["loggedIn"]) AND $_SESSION["loggedIn"] == true){
        $_SESSION["loggedIn"]="";
        $_SESSION["fname"]="";
        $_SESSION['lname']="";
        $_SESSION["admin"]="";
        $_SESSION["loginEmail"]="";
        $_SESSION["hashedPassword"]="";
        redirect("https://php-back2books.azurewebsites.net/");
    } else {
        redirect("https://php-back2books.azurewebsites.net/");
    }
?>