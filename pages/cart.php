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
    <div class="cart-container">
        <?php include('../layouts/layout.php');
        ?>   

        <div class="cart">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
            </center>
        </div>

        <div class="cart">
            <?php
                        echo '<li style="border: solid; margin: 15px 10px; padding: 5px">';
                        echo '    <div style="margin-left: 0; margin-right: 0; display: flex;">';
                        echo '        <div style="align-items: center; width: 20%; display: flex">';
                        echo '            <div style="margin: 10px"><h2> 1 </h2></div>';
                        echo '            <div style="margin: 10px">';
                        echo '                <a href="">';
                        echo '                    <img src="https://images.bwbcovers.com/006/To-Kill-a-Mockingbird-9780060935467.jpg" alt="Image of Book [BOOK_TITLE] height="100" width="75" >';
                        echo '                </a>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div style="width: 80%; display: flex; flex-direction: column;">';
                        echo '            <div style="margin: 5px 0 5px 0;"><span><h1> [BOOK_TITLE] </h1></span></h3></div>';
                        echo '            <div><span style="margin-right: 20px;">Author:&nbsp;&nbsp;&nbsp;<strong> [author_fname] [author_lname] </strong></span><span>Publisher:&nbsp;&nbsp;&nbsp;<strong> [PUBLISHER_NAME] </strong></span></div>';
                        echo '            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between; align-items: flex-end;">';
                        echo '                <div style="width: 60%;">';
                        echo '                <div style="display: flex; align-items: flex-end;">';
                        echo '                </div>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div style="width: 20%;">
                                        <form><input type="text" name="quantity" value="1" ></input></form>
                                        <form><input></input> <button>REMOVE</button></form>
                                        </div>';
                        echo '    </div> ';
                        echo '</li>';
            ?>
        </div>
        
        <div class="cart-summary">
                <div><span>SUBTOTAL: </span> <span> $$$$ </span> </div>
                <div><span>DISCOUNT: </span> <span> - $$$ </span> </div>
                <div><span>SHIPPING: </span> <span> $$$$ </span> </div>
                <div><span>TAX: </span> <span> $$$$ </span> </div>
                <div><span>SHIPPING: </span> <span> $$$$ </span> </div>
                <div><button>CHECK OUT</button></div>
        </div>
</body>

<script src="js/scripts.js"></script>

</html>