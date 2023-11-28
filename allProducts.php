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
                <h1> A L L &nbsp &nbsp P R O D U C T S </h1>
            </center>

            <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
                        $tsql = "SELECT * FROM BOOKS";
                        $getBooks = sqlsrv_query($conn, $tsql);

                        echo '    <div class="products">
                                    <table style="width: 100%; text-align: center;border: 1px solid; border-collapse: collapse;">';
                        echo '        <thead>';
                        echo '            <tr style="border: 1px solid;">';
                        echo '                <th>Book Id</th>';
                        echo '                <th>Title</th>';
                        echo '                <th>ISBN</th>';
                        echo '                <th>Format</th>';
                        echo '                <th>Description</th>';
                        echo '                <th>Pages</th>';
                        echo '                <th>Publisher</th>';
                        echo '                <th>Date Published</th>';
                        echo '                <th>Price</th>';
                        echo '            </tr>';
                        echo '        </thead>';
                        echo '        <tbody>';

                        if ($getBooks != null){
                            while($bookRow = sqlsrv_fetch_array($getBooks, SQLSRV_FETCH_ASSOC)) {
                                $bookId = $bookRow['BOOK_ID'];
                                $bookTitle = $bookRow['BOOK_TITLE'];
                                $bookDesc = $bookRow['PROD_DESC'];
                                $bookISBN = $bookRow['BOOK_ISBN'];
                                $bookPubDate = $bookRow['BOOK_PUBLISHED_DATE']->format('Y-m-d');
                                $bookPrice = $bookRow['PRICE'];
                                $bookFormat = $bookRow['BOOK_FORMAT'];
                                $bookPages = $bookRow['NUM_PAGES'];
                                $bookPubName = $bookRow['PUBLISHER_NAME'];

                                echo '            <tr style="border: 1px solid;">';
                                echo '                <td><div><h3>'.$bookId.'</h3></div>';
                                echo '                        <div style="margin: 10px 0px;"><a href="">Edit</a></div>';
                                echo '                        </td>'; 
                                echo '                <td>'.$bookTitle.'</td>';
                                echo '                <td>'.$bookISBN.'</td>';
                                echo '                <td>'.$bookFormat.'</td>';
                                echo '                <td>'.$bookDesc.'</td>';
                                echo '                <td>'.$bookPages.'</td>';
                                echo '                <td>'.$bookPubName.'</td>';
                                echo '                <td>'.$bookPubDate.'</td>';
                                echo '                <td>'.$bookPrice.'</td>';
                                echo '            </tr>';
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            //redirect("https://php-back2books.azurewebsites.net/allProducts.php?fetch=err");
                        }                                
                    } else {
                        redirect("https://php-back2books.azurewebsites.net/");
                    }
                ?>
        </div>
</body>

</html>