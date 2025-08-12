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
    <!-- <link rel="stylesheet" href="/logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <div class="container">
        <?php 
            include('../layout.php');
        ?>
        <div class="about-us window" style="padding: 2rem;">

            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="/images/b2b-logo-horizontal-concept-transparent.png" alt="Back 2 Books Logo" style="max-width: 300px; height: auto;">
            </div>

            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h2 style="margin-bottom: 1rem; border-bottom: 2px solid #ccc; display: inline-block; padding-bottom: 0.5rem;">Our Story</h2>
                <p style="line-height: 1.6; max-width: 800px; margin: 0 auto;">
                    What began as a software engineering project at the University of Texas at San Antonio has grown into a passion for connecting readers. Back 2 Books is a unique online marketplace inspired by the vibrant Y2K aesthetic, designed for users to buy and sell pre-loved books, custom stationery, and unique literary merchandise.
                </p>
            </div>

            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h2 style="margin-bottom: 1rem; border-bottom: 2px solid #ccc; display: inline-block; padding-bottom: 0.5rem;">Our Mission</h2>
                <p style="line-height: 1.6; max-width: 800px; margin: 0 auto;">
                    Our mission is to give old books new life. We believe in creating a sustainable and affordable community where students and creatives can earn from their old textbooks and supplies, and buyers can discover unique items without breaking the bank.
                </p>
            </div>

            <div style="text-align: center; margin-bottom: 2.5rem;">
                <h2 style="margin-bottom: 1rem; border-bottom: 2px solid #ccc; display: inline-block; padding-bottom: 0.5rem;">Meet the Team</h2>
                <p style="line-height: 1.6; max-width: 800px; margin: 0 auto 2rem auto;">
                    Back 2 Books was brought to life by a dedicated team of student developers, each bringing a unique skill set to the project.
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; max-width: 1000px; margin: 0 auto;">
                    <div style="text-align: center;">
                        <img src="/images/avatar-placeholder.png" alt="Team member avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 3px solid #ddd;">
                        <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Kip Roberts-Lemus</h3>
                        <p style="color: #555; font-style: italic; margin: 0;">Product Owner</p>
                    </div>
                    <div style="text-align: center;">
                        <img src="/images/avatar-placeholder.png" alt="Team member avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 3px solid #ddd;">
                        <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Bernardo Vazquez De La Cruz</h3>
                        <p style="color: #555; font-style: italic; margin: 0;">Scrum Master</p>
                    </div>
                    <div style="text-align: center;">
                        <img src="/images/avatar-placeholder.png" alt="Team member avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 3px solid #ddd;">
                        <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Andrea Mendez</h3>
                        <p style="color: #555; font-style: italic; margin: 0;">Developer</p>
                    </div>
                    <div style="text-align: center;">
                        <img src="/images/avatar-placeholder.png" alt="Team member avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 3px solid #ddd;">
                        <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Daniel Hwang</h3>
                        <p style="color: #555; font-style: italic; margin: 0;">Developer</p>
                    </div>
                    <div style="text-align: center;">
                        <img src="/images/avatar-placeholder.png" alt="Team member avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem; border: 3px solid #ddd;">
                        <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Joe Louie Corporal</h3>
                        <p style="color: #555; font-style: italic; margin: 0;">Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>