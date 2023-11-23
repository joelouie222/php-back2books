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
    <?php include('../layouts/layout.php');
    ?>
    <div class="container">
        <div class="about-us">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
            </center>

            <article class="promo-card">
                <div class="promo-card-box">
                    <div class="discount-box">
                        <div> ENTER COUPON CODE</div>
                        <div> AT CHECK OUT</div>
                    </div>

                    <div class="promo-details">
                        <div class="promo-name"><span> COUPON NAME </span></div>
                        <h3 class="coupon-desc"> COUPON DESCRIPTION HERE </h3>
                    </div>

                    <div class="discount-box">
                        <div class="coupon-code">
                            <h3 id="couponCode">COUPON CODE</h3>
                        </div>
                        <div><button onclick="copyCoupon()">COPY CODE</button></div>
                    <div>
                </div>
            </article>
        </div>
</body>

<script src="/js/copy_coupon.js"></script>

</html>