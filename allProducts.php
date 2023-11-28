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
                    if (isset($_POST["addProduct"]) && $_POST["addProduct"] == "go") {
                        $booktitle = $_POST['booktitle'];
                        $bookauthorfname = $_POST['bookauthorfname'];
                        $bookauthorfname = $_POST['bookauthorlname'];
                        $bookdesc = $_POST['bookdesc'];
                        $bookisbn = $_POST['bookisbn'];
                        $bookpubdate = $_POST['bookpubdate'];
                        $bookgenre = $_POST['bookgenre'];
                        $bookformat = $_POST['bookformat'];
                        $bookpages = $_POST['bookpages'];
                        $bookpubname = $_POST['bookpubname'];
                        $stock = $_POST['stock'];
                        $bookprice = $_POST['bookprice'];
                        $bookimg = $_POST['bookimg'];

                        echo '<center>';
                        echo 'booktitle: '.$booktitle.'</br>';
                        echo 'bookauthorfname: '.$bookauthorfname.'</br>';
                        echo 'bookdesc: '.$bookdesc .'  </br>';
                        echo 'bookisbn: '.$bookisbn.'</br>';
                        echo 'bookpubdate: '.$bookpubdate .'</br>';
                        echo 'bookgenre: '.$bookgenre.'</br>';
                        echo 'bookformat: '.$bookformat.'</br>';
                        echo 'bookpages: '.$bookpages.'</br>';
                        echo 'bookpubname: '.$bookpubname.'</br>';
                        echo 'stock: '.$stock.'</br>';
                        echo 'bookprice: '.$bookprice.'</br>';
                        echo 'bookimg: '.$bookimg.'</br>';
                        echo '</center>';

                        // INSERT BOOK
                        $tsql = "INSERT INTO BOOKS (BOOK_TITLE, BOOK_DESC, BOOK_ISBN, BOOK_PUBLISHED_DATE, PRICE, BOOK_FORMAT, NUM_PAGES, PUBLISHER_NAME)
                            VALUES ('$booktitle', '$bookdesc', '$bookisbn', '$bookpubdate', '$bookprice', '$bookformat', '$bookpages', '$bookpubname')";

                        $addBook = sqlsrv_query($conn, $tsql);

                        if ($addBook == NULL) {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                        }

                        // INSERT GENRE

                        // INSERT GENRE LIST

                        // INSERT autho

                        // INSERT AUTHOR LIST


                        // INSERT BOOK IMG

                        // INSERT LISTING

                        // INSERT PRODUCT_INVENTORY
                        

                        // Redirect to current page
                        //redirect("https://php-back2books.azurewebsites.net/allProducts.php");

                    }


                    if (isset($_GET['action']) && $_GET['action'] == "add") {
 
                        echo ' <hr><center>';
                        echo ' <h1> You are adding a new Product</h1></br>';
                        echo ' <form method="post" action="">';
                        echo '  <div class="form-group">';
                        echo '    <label for="booktitle">Book Title: </label>';
                        echo '    <input required name="booktitle" placeholder ="Title">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookauthorfname">Author First Name: </label>';
                        echo '    <input required name="bookauthorfname" placeholder ="First name">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookauthorlname">Author Last Name: </label>';
                        echo '    <input required name="bookauthorlname" placeholder ="Last name">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookdesc">Description: </label>';
                        echo '    <textarea required name="bookdesc" style="height: 228px; width: 421px;"></textarea>';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookisbn">ISBN-13: </label>';
                        echo '    <input required name="bookisbn" maxlength="13" type="text" placeholder="ISBN-13"">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookpubdate">Published Date: </label>';
                        echo '    <input required name="bookpubdate" type="date">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookgenre"> Genre: </label>';
                        echo '    <input required name="bookgenre" placeholder="Genre">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookformat">Format: </label>';
                        echo '    <input required name="bookformat" placeholder="Format">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookpages">Number of Pages: </label>';
                        echo '    <input required name="bookpages" maxlength="6" type="number">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookpubname">Publisher Name: </label>';
                        echo '    <input required name="bookpubname" placeholder="Publisher name">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="stock">How many in Stock?: </label>';
                        echo '    <input required name="stock" maxlength="6" type="number">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookprice">Price: </label>';
                        echo '    <input required name="bookprice" placeholder="Price">';
                        echo '  </div>';

                        echo '  <div class="form-group">';
                        echo '    <label for="bookimg">Link to Book cover image: </label>';
                        echo '    <input required name="bookimg" type="text" type="text">';
                        echo '  </div>';

                        echo '  <div>';
                        echo '      <button name="addProduct" type="submit" value="go"> Save </button>';
                        echo '      </div>';
                        echo '  </form>';
                        echo ' </br></center><hr>';
                    }










                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
                        $tsql = "SELECT * FROM BOOKS";
                        $getBooks = sqlsrv_query($conn, $tsql);

                        echo '     <div><a href="/allProducts.php?action=add"><button>ADD NEW PRODUCT</button></a></div>';
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