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
    <link rel="stylesheet" href="/logo-style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php include('../layout.php');
    ?>

    <div class="container">

        <div class="contact-us">
            <div style="margin-bottom: 5px;">
                <h1>Contact Us</h1>
            </div>
            <div style="margin-bottom: 5px;">
                <p>Thank you for reaching out! We here at Back2Books appreciate the interest shown and value your
                    feedback.</p>
            </div>
            <p>If you have any comments, concerns, or suggestions, please reach out at the following. </p>

            <br>
            <h2 style="margin-bottom: 5px;">Customer Support</h2>
            <ul>
                <li><strong>Email:</strong> back2books@fakeemail.com </li>
                <li><strong>Phone:</strong> (123) 456-7891</li>
            </ul>
            <br>
            <h2 style="margin-bottom: 5px;">Business Inquiries</h2>
            <ul>
                <li><strong>Email:</strong> back2books@fakebusiness.com</li>
                <li><strong>Phone:</strong> (123) 456-7891</li>
            </ul>
            <br>
            <h2 style="margin-bottom: 5px;">Office Hours</h2>
            <p><strong>Monday-Sunday</strong>: Never Open (we are a fully remote business)</p><br>
            <p>Again please feel free to reach out to us at any of these
                modes of contact we will get back to you as promptly as possible.</p>
        </div>
</body>

<script src="js/scripts.js"></script>

</html>