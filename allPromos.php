<?php
  session_start();
  include('functions.php');
  include('config.php');
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
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
                    // MAKE SURE USER IS LOGGED IN AND IS AN ADMIN
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
                        // ================================================================
                        // ADD NEW COUPON LOGIC
                        // ================================================================
                        if (isset($_POST["addPromo"]) && $_POST["addPromo"] == "go") {
                            $discname = preg_replace('/[\'\";#]/', '', trim($_POST['discname']));
                            $discdesc = preg_replace('/[\'\";#]/', '', trim($_POST['discdesc']));
                            $disctag = preg_replace('/[\'\";#]/', '', trim($_POST['disctag']));
                            $disccode = preg_replace('/[\'\";#]/', '', trim($_POST['disccode']));
                            $discval = ((100 - $disctag)/ 100);
  
                            $tsql = "INSERT INTO discount (discount_code, discount_value, discount_name, discount_desc, discount_tag, active)
                            VALUES (?, ?, ?, ?, ?, ?)";
                            $params = array($disccode, $discval, $discname, $discdesc, $disctag, 1);
                            $addCoupon = sqlsrv_query($conn, $tsql, $params);

                            if ($addCoupon == NULL){
                                redirect($HOME."allPromos.php?fetch=err");
                            }
                            redirect($HOME."allPromos.php");
                        } 

                        if (isset($_GET['fetch']) && $_GET['fetch'] == "err") {
                            echo '<div style="margin: 10px 0 20px 0;"><center><h3> There was an error fetching the coupons. Please try again later.</h3>';
                            echo '<a href="'.$HOME.'allPromos.php"><button>Click here to refresh</button></a></center></div>';
                        }

                        // ================================================================
                        // ADD NEW COUPON FORM
                        // ================================================================
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
                            echo '    <label for="disctag">Discount Value: </label>';
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
                        } else {
                            // ================================================================
                            // DISPLAY ALL COUPONS
                            // ================================================================
                            $tsql = "SELECT * FROM discount";
                            $getDiscounts = sqlsrv_query($conn, $tsql);

                            echo '     <div><center><a href="/allPromos.php?action=add"><button style="padding: 10px; color: green;">ADD NEW COUPON</button></a></center></div>';
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
                                    $discountId = $discountRow['discount_id'];
                                    $discountCode = $discountRow['discount_code'];
                                    $dicountValue = $discountRow['discount_value'];
                                    $discountActive = $discountRow['active'];
                                    $discountName = $discountRow['discount_name'];
                                    $discountDesc = $discountRow['discount_desc'];
                                    $discountTag = $discountRow['discount_tag'];

                                    echo '            <tr style="border: 1px solid;">';
                                    echo '                <td><div><h3>'.htmlspecialchars($discountId).'</h3></div>';
                                    //echo '                        <div style="margin: 10px 0px;"><a href="">Edit</a></div>';
                                    echo '                        </td>'; 
                                    echo '                <td>'.htmlspecialchars($discountActive).'</td>';
                                    echo '                <td>'.htmlspecialchars($discountName).'</td>';
                                    echo '                <td>'.htmlspecialchars($discountDesc).'</td>';
                                    echo '                <td>'.htmlspecialchars($discountCode).'</td>';
                                    echo '                <td>'.htmlspecialchars($dicountValue).'</td>';
                                    echo '                <td>'.htmlspecialchars($discountTag).'</td>';
                                    echo '            </tr>';
                                }
                                echo '        </tbody>';
                                echo '    </table></div>';
                            } else {
                                redirect($HOME."allPromos.php?fetch=err");
                            }    
                        }                       
                    } else { // NOT LOGGED IN OR AN ADMIT, redirect to login page
                        redirect($HOME."/pages/login.php");
                    }
                ?>
        </div>
</body>

</html>