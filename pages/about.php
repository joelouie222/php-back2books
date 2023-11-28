<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Back2Books</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- OUR CSS -->
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <div class="container">
        <?php include('../layout.php');
        ?>

        <div class="about-us">
            <center>
                <img src="/images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
            </center>
            <br>
            <p>
                This is a class project for the course CS 3773 Software Engineering in the term FALL 2023 at University
                of Texas at San Antonio (UTSA).
                <br>Back 2 Books is an retro/Y2K-style online shopping site that enables users to buy or sell books,
                stationary, and other merchandise!<br>
                <br>
            <h2 style="margin-bottom: 10px;">The Team</h2>
            <ul>
                <li style="text-align: center;"><strong>Kip Roberts-Lemus</strong> | <span><i>Product Owner </i></span>
                </li>
                <li style="text-align: center; margin-right: 82px;"><strong>Bernardo Vazquez De La Cruz</strong> |
                    <span><i> Scrum Master </i></span>
                </li>
                <li style="text-align: center; margin-left: 5px;"><strong>Andrea Mendez</strong> | <span style="margin-right: 10px;"><i>Developer</i> </span></li>
                <li style="text-align: center;margin-left: 7px;"><strong>Daniel Hwang</strong> | <span><i>Developer</i>
                    </span></li>
                <li style="text-align: center; margin-left: 38px;"><strong>Joe Louie</strong> | <span><i>Developer</i>
                    </span></li>
            </ul>
            <br>Thank you for coming to our website! This is all about empowering others to be able to make some extra
            cash from old textbooks, cool custom stationary supplies, or other related items.<br>
            </p>
        </div>

</body>

</html>