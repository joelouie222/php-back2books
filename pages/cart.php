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
        <?php include('../layouts/layout.php');
        ?>   

        <div class="about-us">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
            </center>
        </div>

        <div class="about-us">
            <?php
                        echo '<li style="border: solid; margin: 15px 10px; padding: 5px">';
                        echo '    <div style="margin-left: 0; margin-right: 0; display: flex;">';
                        echo '        <div style="align-items: center; width: 20%; display: flex">';
                        echo '            <div style="margin: 10px"><h2> 1 </h2></div>';
                        echo '            <div style="margin: 10px">';
                        echo '                <a href="">';
                        echo '                    <img src="https://images.bwbcovers.com/006/To-Kill-a-Mockingbird-9780060935467.jpg" alt="Image of Book [BOOK_TITLE] height="200" width="150" >';
                        echo '                </a>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div style="width: 80%; display: flex; flex-direction: column;">';
                        echo '            <div style="margin: 5px 0 5px 0;"><span><h1> [BOOK_TITLE] </h1></span><span> ([BOOK_PUBLISHED_DATE) </span></h3></div>';
                        echo '            <div><span style="margin-right: 20px;">Author:&nbsp;&nbsp;&nbsp;<strong> [author_fname] [author_lname] </strong></span><span>Publisher:&nbsp;&nbsp;&nbsp;<strong> [PUBLISHER_NAME] </strong></span></div>';
                        echo '            <div style="margin: 5px 0px 0px 0px; height: 150px; overflow-x: hidden; overflow-y: auto;"> [PROD_DESC] </div>';
                        echo '            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between; align-items: flex-end;">';
                        echo '                <div style="width: 60%;">';
                        echo '                <div><h1>$ [PRICE]</h1></div> ';
                        echo '                <div style="display: flex; align-items: flex-end;">';
                        echo '                </div>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div> ';
                        echo '</li>';
            ?>
        </div>
        
        <div class="cart-summary">
                <a href="/pages/catalog.php"><i class="fa fa-fw fa-book"></i> Catalog </a>
                <a href="/pages/catalog.php"><i class="fa fa-fw fa-book"></i> Catalog </a>
                <a href="/pages/catalog.php"><i class="fa fa-fw fa-book"></i> Catalog </a>
                <a href="/pages/catalog.php"><i class="fa fa-fw fa-book"></i> Catalog </a>
        </div>
</body>

<script src="js/scripts.js"></script>

</html>