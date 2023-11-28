<?php
  session_start();
  include('functions.php');
  include('config.php');
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
    redirect("https://php-back2books.azurewebsites.net/");
  }
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
    <?php include('layout.php');
    ?>  
      
    <div class="container">
                              
        <div class="products">
            <center>
                <img src="/images/patrick-star-dumb.gif" width="300" height="150">
                </br>
                <h1> PAGE UNDER CONSTRUCTION</h1>
                <h2> This page will list ALL PROMOTIONS active or note, be able to create a new COUPON CODE </h2>
            </center>

            <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
                        $tsql = "SELECT * FROM DISCOUNT";
                        $getDiscounts = sqlsrv_query($conn, $tsql);

                        echo '    <div class="products">
                                    <table style="width: 100%; text-align: center;border: 1px solid; border-collapse: collapse;">';
                        echo '        <thead>';
                        echo '            <tr style="border: 1px solid;">';
                        echo '                <th>Discount Id</th>';
                        echo '                <th>Active</th>';
                        echo '                <th>Name</th>';
                        echo '                <th>Description</th>';
                        echo '                <th>Code</th>';
                        echo '                <th>Value</th>';
                        echo '                <th>Tag</th>';
                        echo '            </tr>';
                        echo '        </thead>';
                        echo '        <tbody>';

                        if ($getDiscounts != null){
                            while($discountRow = sqlsrv_fetch_array($getDiscounts, SQLSRV_FETCH_ASSOC)) {
                                $discountId = $discountRow['DISCOUNT_ID'];
                                $discountCode = $discountRow['DISCOUNT_CODE'];
                                $dicountValue = $discountRow['DISCOUNT_VALUE'];
                                $discountActive = $discountRow['ACTIVE'];
                                $discountName = $discountRow['DISCOUNT_NAME'];
                                $discountDesc = $discountRow['DISCOUNT_DESC'];
                                $discountTag = $discountRow['DISCOUNT_TAG'];

                                echo '            <tr style="border: 1px solid;">';
                                echo '                <td><div><h3>'.$discountId.'</h3></div>';
                                echo '                        <div style="margin: 10px 0px;"><a href="">Edit</a></div>';
                                echo '                        </td>'; 
                                echo '                <td>'.$discountActive.'</td>';
                                echo '                <td>'.$discountName.'</td>';
                                echo '                <td>'.$discountDesc.'</td>';
                                echo '                <td>'.$discountCode.'</td>';
                                echo '                <td>'.$dicountValue.'</td>';
                                echo '                <td>'.$discountTag.'</td>';
                                echo '            </tr>';
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            //redirect("https://php-back2books.azurewebsites.net/allPromos.php?fetch=err");
                        }                                
                    } else {
                        redirect("https://php-back2books.azurewebsites.net/");
                    }
                ?>
        </div>
</body>

</html>