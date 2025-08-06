<?php
  session_start();
  include('functions.php');
  include('config.php');
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
    // redirect("https://php-back2books.azurewebsites.net/");
    redirect($HOME);
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
                <h1> A L L &nbsp &nbsp P R O M O T I O N S </h1>
            </center>

            <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {

                        if (isset($_POST["addPromo"]) && $_POST["addPromo"] == "go") {
                            $discname = $_POST['discname'];
                            $discdesc = $_POST['discdesc'];
                            $disctag = $_POST['disctag'];
                            $disccode = $_POST['disccode'];
                            $discval = ((100 - $disctag)/ 100);
  
                            // echo 'discname: '.$discname.'';
                            // echo 'discdesc: '.$discdesc.'';
                            // echo 'disctag: '.$disctag.'';
                            // echo 'disccode: '.$disccode.'';
                            // echo 'discval: '.$discval.'';

                            $tsql = "INSERT INTO DISCOUNT (DISCOUNT_CODE, DISCOUNT_VALUE, DISCOUNT_NAME, DISCOUNT_DESC, DISCOUNT_TAG, ACTIVE)
                            VALUES ('$disccode', '$discval', '$discname', '$discdesc', '$disctag', 1)";

                            $addCoupon = sqlsrv_query($conn, $tsql);

                            if ($addCoupon == NULL){
                                // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                // redirect("https://php-back2books.azurewebsites.net/allPromos.php?fetch=err");
                                redirect($HOME."allPromos.php?fetch=err");
                            }
                            // redirect("https://php-back2books.azurewebsites.net/allPromos.php");
                            redirect($HOME."allPromos.php");
                        } 

                        if (isset($_GET['action']) && $_GET['action'] == "add") {

                            echo ' <hr><center>';
                            echo ' <h1> You are adding a new Coupon</h1></br>';
                            echo ' <form method="post" action="">';
                            echo '  <div class="form-group">';
                            echo '    <label for="discname">Coupon Name: </label>';
                            echo '    <input required name="discname" placeholder ="Name">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="discdesc">Description: </label>';
                            echo '    <textarea required name="discdesc" style="height: 228px; width: 421px;"></textarea>';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="disctag">Discount Tag: </label>';
                            echo '    <input required name="disctag" type="number" placeholder="How much % off?"">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="disccode">Discount Code: </label>';
                            echo '    <input required name="disccode" placeholder="CODE">';
                            echo '  </div>';

                            echo '  <div>';
                            echo '      <button name="addPromo" type="submit" value="go"> Save </button>';
                            echo '      </div>';
                            echo '  </form>';
                            echo ' </br></center><hr>';
                        }


                        $tsql = "SELECT * FROM DISCOUNT";
                        $getDiscounts = sqlsrv_query($conn, $tsql);

                        echo '     <div><a href="/allPromos.php?action=add"><button>ADD NEW COUPON</button></a></div>';
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
                                //echo '                        <div style="margin: 10px 0px;"><a href="">Edit</a></div>';
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
                            //die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            // redirect("https://php-back2books.azurewebsites.net/allPromos.php?fetch=err");
                            redirect($HOME."allPromos.php?fetch=err");
                        }                                
                    } else {
                        // redirect("https://php-back2books.azurewebsites.net/");
                        redirect($HOME);
                    }
                ?>
        </div>
</body>

</html>