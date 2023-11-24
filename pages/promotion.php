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
    <?php
        include('../layouts/layout.php');
        include('../config.php');
    ?>
    <div class="container">
        <div class="about-us">
            <center style="border: double; padding: 10px; background-color: #e0d3c4;">
                <div><img src="https://images.pexels.com/photos/5650026/pexels-photo-5650026.jpeg" width="450" height="225"></div>
                <!-- <img src="/images/patrick-star-dumb.gif" width="300" height="150"> -->
                <div><h1 style="font-size: xxx-large;"> P R O M O T I O N S </h1><div>
            </center>

            <?php
                $tsql = "SELECT DISCOUNT_TAG, DISCOUNT_NAME, DISCOUNT_CODE, DISCOUNT_DESC FROM DISCOUNT WHERE ACTIVE = 1";
                $getDiscounts = sqlsrv_query($conn, $tsql);

                // echo "connectionInfo: ($connectionInfo)";
                // echo "</br>";
                // echo "serverName: ($serverName)";
                // echo "</br>";
                // echo "conn: ($conn)";
                // echo "</br>";

                if( $getDiscounts == false ) {  
                    echo "Error in statement preparation/execution.\n";  
                    die( print_r( sqlsrv_errors(), true));
                }

                while($row = sqlsrv_fetch_array($getDiscounts, SQLSRV_FETCH_ASSOC)) {
                    echo '<article class="promo-card">';
                    echo '    <div class="promo-card-box">';
                    echo '        <div class="discount-box">';
                    echo '        <div> SAVE <h3>'.$row["DISCOUNT_TAG"].'% OFF</h3></div>';
                    echo '        <div> AT CHECK OUT</div>';
                    echo '    </div>';
                    echo '<div class="promo-details">';
                    echo '    <div class="promo-name"><span> '.$row["DISCOUNT_NAME"].'</span></div>';
                    echo '    <h3 class="coupon-desc">'.$row["DISCOUNT_DESC"].'</h3>';
                    echo '</div>';
                    echo '<div class="promo-code-box">';
                    echo '    <div class="coupon-code">';
                    echo '        <input type="text" value="'.$row["DISCOUNT_CODE"].'">';
                    echo '    </div>';
                    echo '    <div></div>';
                    echo '</article>';
                }
                sqlsrv_free_stmt($getDiscounts);
            ?>
            <!-- <article class="promo-card">
                <div class="promo-card-box">
                    <div class="discount-box">
                        <div> SAVE [TAG]% OFF</div>
                        <div> AT CHECK OUT</div>
                    </div>

                    <div class="promo-details">
                        <div class="promo-name"><span> [NAME] </span></div>
                        <h3 class="coupon-desc"> [DESCRIPTION] </h3>
                    </div>

                    <div class="promo-code-box">
                        <div class="coupon-code">
                            <input type="text" value="[CODE]">
                        </div>
                    <div>
                </div>
            </article>
        </div> -->
<script>
    
</script>


</body>



</html>