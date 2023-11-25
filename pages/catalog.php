<?php
  session_start();
?>
<!DOCTYPE html>
<html>

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
    <link rel="icon" type="image/x-icon" href="../images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php 
        include('../layouts/layout.php');
        include('../config.php');
    ?>  
      
    <div class="container">
        <div class="products">
            <center>
                <h1> Book Catalog </h1>
                <?php
                    echo 'BEFORE ISSET SUBMIT';
                    if((isset($_POST['submit'])) && $_POST['submit']=="ADDTOCART") {
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){
                            echo '$_POST[cartBookID] = '.$_POST['cartBookID'];
                        } else {
                            echo 'MUST LOG IN!';
                        }
                    }
                    echo 'AFTER ISSET SUBMIT';
                ?>
            </center>

            <ol class="book-list-view">
                <?php
                    $tsql = "SELECT TOP (10) *
                            FROM BOOKS B
                            INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
                            INNER JOIN AUTHOR_LIST AL ON B.BOOK_ID = AL.BOOK_ID
                            INNER JOIN AUTHOR A ON AL.AUTHOR_ID = A.AUTHOR_ID
                            INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID";
                    $getBooks = sqlsrv_query($conn, $tsql);

                    if($getBooks == false ) {  
                        echo "Error in statement preparation/execution.\n";  
                        die( print_r( sqlsrv_errors(), true));
                    }
                    $count = 1;
                    while($row = sqlsrv_fetch_array($getBooks, SQLSRV_FETCH_ASSOC)) {
                        
                        // echo '<p>[BOOK TITLE]: '.$row['BOOK_TITLE'].'</p>';
                        // echo '<p>[PROD_DESC]: '.$row['PROD_DESC'].'</p>';
                        // echo '<p>[BOOK_ISBN]: '.$row['BOOK_ISBN'].'</p>';
                        // // $date = $row['BOOK_PUBLISHED_DATE'];
                        // // $formattedDate = date("Y-m-d", strtotime($date));
                        // echo '<p>[BOOK_PUBLISHED_DATE]: '.$row['BOOK_PUBLISHED_DATE']->format('Y-m-d').'</p>';
                        // echo '<p>[PRICE]: '.$row['PRICE'].'</p>';
                        // echo '<p>[BOOK_FORMAT]: '.$row['BOOK_FORMAT'].'</p>';
                        // echo '<p>[NUM_PAGES]: '.$row['NUM_PAGES'].'</p>';
                        // echo '<p>[PUBLISHER_NAME]: '.$row['PUBLISHER_NAME'].'</p>';
                        // echo '<p>[IMAGE_LINK]: '.$row['IMAGE_LINK'].'</p>';
                        // echo '<p>[INV_QUANTITY]: '.$row['INV_QUANTITY'].'</p>';
                        // echo '<p>[Author_fname]: '.$row['author_fname'].'</p>';
                        // echo '<p>[author_lname]: '.$row['author_lname'].'</p>';
                        // echo '</br></br>';

                        echo '<li style="border: solid; margin: 15px 10px; padding: 5px">';
                        echo '    <div style="margin-left: 0; margin-right: 0; display: flex;">';
                        echo '        <div style="align-items: center; width: 20%; display: flex">';
                        echo '            <div style="margin: 10px"><h2>'.$count.'</h2></div>';
                        echo '            <div style="margin: 10px">';
                        echo '                <a href="">';
                        echo '                    <img src="'.$row['IMAGE_LINK'].'" alt="Image of Book '.$row['BOOK_TITLE'].'" height="200" width="150" >';
                        echo '                </a>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div style="width: 80%; display: flex; flex-direction: column;">';
                        echo '            <div style="margin: 5px 0 5px 0;"><span><h1>'.$row['BOOK_TITLE'].'</h1></span><span>('.$row['BOOK_PUBLISHED_DATE']->format('Y-m-d').')</span></h3></div>';
                        echo '            <div><span style="margin-right: 20px;">Author:&nbsp;&nbsp;&nbsp;<strong>'.$row['author_fname'].' '.$row['author_lname'].'</strong></span><span>Publisher:&nbsp;&nbsp;&nbsp;<strong>'.$row['PUBLISHER_NAME'].'</strong></span></div>';
                        echo '            <div style="margin: 5px 0px 0px 0px; height: 150px; overflow-x: hidden; overflow-y: auto;">'.$row['PROD_DESC'].'</div>';
                        echo '            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between; align-items: flex-end;">';
                        echo '                <div style="width: 60%;">';
                        echo '                    <table style="width: 100%;">';
                        echo '                        <thead>';
                        echo '                            <tr style="border-bottom: 1px solid; border-top: 1px solid;">';
                        echo '                                <th>ISBN-13</th>';
                        echo '                                <th>Format</th>';
                        echo '                                <th>Pages</th>';
                        echo '                                <th>Stock</th>';
                        // echo '                                <th>Price</th>';
                        echo '                            </tr>';
                        echo '                        </thead>';
                        echo '                        <tbody>';
                        echo '                            <tr>';
                        echo '                                <td>'.$row['BOOK_ISBN'].'</td> ';
                        echo '                                <td>'.$row['BOOK_FORMAT'].'</td>';
                        echo '                                <td>'.$row['NUM_PAGES'].'</td>';
                        echo '                                <td>'.$row['INV_QUANTITY'].'</td>';
                        // echo '                                <td>'.$row['PRICE'].'</td>';
                        echo '                            </tr>';
                        echo '                        </tbody>';
                        echo '                    </table>';
                        echo '                </div>';
                        echo '                <div><h1>$ '.$row['PRICE'].'</h1></div>  ';
                        echo '                <div style="display: flex; align-items: flex-end;">';
                        echo '                   <div>
                                                    <form method="post" action="">
                                                        <input name="favBookID" type="hidden" value="'.$row['BOOK_ID'].'">
                                                        <div style="margin-right: 10px; cursor: pointer;"><button style="border: none; background-color: antiquewhite;" type="submit" value="ADDTOFAV"><i class="fa fa-heart fa-2x"></i></button></div>
                                                    </form>
                                                </div>';                  
                        echo '                   <div>
                                                    <form method="post" action="">
                                                        <input name="cartBookID" type="hidden" value="'.$row['BOOK_ID'].'">
                                                        <div style="cursor: pointer;"><button style="padding: 5px;" type="submit" value="ADDTOCART"> ADD TO CART </button></div>
                                                    </form>
                                                </div>';
                        echo '                </div>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div> ';
                        echo '</li>';
                        $count++;
                    }
                    sqlsrv_free_stmt($getBooks);
                ?>
            </ol>
        </div>


    </div>
</body>

</html>