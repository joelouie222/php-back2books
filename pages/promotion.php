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
            <center style="border: double; padding: 10px; ">
                <div><img src="https://images.pexels.com/photos/5650026/pexels-photo-5650026.jpeg" width="450" height="225"></div>
                <!-- <img src="/images/patrick-star-dumb.gif" width="300" height="150"> -->
                <div><h1 style="font-size: xxx-large;"> P R O M O T I O N S </h1><div>
            </center>

            <?php
                $tsql = "SELECT * FROM dbo.DISCOUNT WHERE 1";
                $getDiscounts = sqlsrv_query($conn, $tsql);

                echo "connectionInfo: ($connectionInfo)";
                echo "</br>";
                echo "serverName: ($serverName)";
                echo "</br>";
                echo "conn: ($conn)";
                echo "</br>";

                if( $getDiscounts === false ) {  
                    echo "Error in statement preparation/execution.\n";  
                    die(FormatErrors(sqlsrv_errors()));
                }

                while($row = sqlsrv_fetch_array($getDiscounts, SQLSRV_FETCH_ASSOC)) {
                    echo "($row[DISCOUNT_ID])</br>";
                    echo "($row[DISCOUNT_CODE])</br>";
                    echo "($row[DISCOUNT_VALUE])</br>";
                    echo "($row[ACTIVE])</br>";
                    echo "($row[DISCOUNT_NAME])</br>";
                    echo "($row[DISCOUNT_DESC])</br>";
                    echo "($row[DISCOUNT_TAG])</br>";
                    echo "<hr>";
                }
                sqlsrv_free_stmt($getDiscounts);
            ?>


            <article class="promo-card">
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
        </div>

<script>
    
</script>


</body>



</html>