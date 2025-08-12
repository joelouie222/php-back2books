<?php
    session_start();
    include('functions.php');
    include('config.php');
    // REDIRECT TO HOME if not logged in, or logged in but not admin
    if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true || $_SESSION['admin'] != true) {
        redirect($HOME);
    }

    $feedbackMessage = '';

    //=============================================================
    // ADD NEW PRODUCT LOGIC
    //=============================================================
    if (isset($_POST["addProduct"]) && $_POST["addProduct"] == "go") {

        // Start the transaction
        if (sqlsrv_begin_transaction($conn) === false) {
            die("Could not begin transaction.");
        }

        $booktitle = preg_replace('/[\'\";#]/', '', trim($_POST['booktitle']));
        $bookauthorfname = preg_replace('/[\'\";#]/', '', trim($_POST['bookauthorfname']));
        $bookauthorlname = preg_replace('/[\'\";#]/', '', trim($_POST['bookauthorlname']));
        $bookdesc = preg_replace('/[\'\";#]/', '', trim($_POST['bookdesc']));
        $bookisbn = preg_replace('/[\'\";#]/', '', trim($_POST['bookisbn']));
        $bookpubdate = preg_replace('/[\'\";#]/', '', trim($_POST['bookpubdate']));
        $bookgenre = preg_replace('/[\'\";#]/', '', trim($_POST['bookgenre']));
        $bookformat = preg_replace('/[\'\";#]/', '', trim($_POST['bookformat']));
        $bookpages = preg_replace('/[\'\";#]/', '', trim($_POST['bookpages']));
        $bookpubname = preg_replace('/[\'\";#]/', '', trim($_POST['bookpubname']));
        $stock = (int) preg_replace('/[\'\";#]/', '', trim($_POST['stock']));
        $bookprice = (float) preg_replace('/[\'\";#]/', '', trim($_POST['bookprice']));
        $bookimg = preg_replace('/[\'\";#]/', '', trim($_POST['bookimg']));


        // INSERT NEW BOOK
        $tsql_book = "INSERT INTO book (book_title, prod_desc, book_isbn, book_published_date, price, book_format, num_pages, publisher_name)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?); SELECT SCOPE_IDENTITY() AS book_id;";

        $params_book = array($booktitle, $bookdesc, $bookisbn, $bookpubdate, $bookprice, $bookformat, $bookpages, $bookpubname);
        $stmt_book = sqlsrv_query($conn, $tsql_book, $params_book);

        if ($stmt_book === false) {
            sqlsrv_rollback($conn);
            redirect($HOME."allProducts.php?msg=bookErr");
        }

        // get result from SCOPE_IDENTITY to get the book_id of the newly added book
        sqlsrv_next_result($stmt_book);
        $newBookId = sqlsrv_fetch_array($stmt_book, SQLSRV_FETCH_ASSOC)['book_id'];

        // CHECK IF AUTHOR EXIST in db, if not create a new author
        $tsql_author_check = "SELECT author_id FROM author WHERE author_fname = ? AND author_lname = ?";
        $params_author_check = array($bookauthorfname, $bookauthorlname);
        $stmt_author_check = sqlsrv_query($conn, $tsql_author_check, $params_author_check);

        if ($stmt_author_check === false) {
            sqlsrv_rollback($conn);
            redirect($HOME."allProducts.php?msg=authorCheckErr");
        }

        $authorId = sqlsrv_fetch_array($stmt_author_check, SQLSRV_FETCH_ASSOC)['author_id'];

        if ($authorId == null) {
            $tsql_author_insert = "INSERT INTO author (author_fname, author_lname) VALUES (?, ?); SELECT SCOPE_IDENTITY() AS author_id;";
            $stmt_author_insert = sqlsrv_query($conn, $tsql_author_insert, $params_author_check);
            if ($stmt_author_insert === false) {
                sqlsrv_rollback($conn);
                redirect($HOME."allProducts.php?msg=authorInsertErr");
            }
            sqlsrv_next_result($stmt_author_insert);
            $authorId = sqlsrv_fetch_array($stmt_author_insert, SQLSRV_FETCH_ASSOC)['author_id'];
        } 

        // 3. LINK AUTHOR AND BOOK in author_list
        $tsql_author_list = "INSERT INTO author_list (book_id, author_id) VALUES (?, ?)";
        $stmt_author_list = sqlsrv_query($conn, $tsql_author_list, array($newBookId, $authorId));
        
        if ($stmt_author_list === false) {
            sqlsrv_rollback($conn);
            redirect($HOME."allProducts.php?msg=authorListErr");
        }

        // INSERT BOOK IMAGE
        $tsql_image = "INSERT INTO book_image (image_link, book_id) VALUES (?, ?)";
        $stmt_image = sqlsrv_query($conn, $tsql_image, array($bookimg, $newBookId));

        if ($stmt_image === false) {
            sqlsrv_rollback($conn);
            redirect($HOME."allProducts.php?msg=imageErr");
        }

        // INSERT INTO PRODUCT_INVENTORY
        $tsql_inv = "INSERT INTO product_inventory (book_id, inv_quantity) VALUES (?, ?)";
        $stmt_inv = sqlsrv_query($conn, $tsql_inv, array($newBookId, (int) $stock));

        if ($stmt_inv === false) {
            sqlsrv_rollback($conn);
            redirect($HOME."allProducts.php?msg=invErr");
        }

        // If everything was successful, commit the transaction
        sqlsrv_commit($conn);
        $feedbackMessage = "Success! Product added with Book ID: " . $newBookId;
    

        // FUTURE IMPLEMENTATIONS --- INSERT GENRE (Check if genre exists and get genre id, if not create a new genre)
        // FUTURE IMPLEMENTATIONS --- INSERT GENRE LIST (A book can have many genres/list of genres)
        // FUTURE IMPLEMENTATIONS --- INSERT LISTING (FOR USERS SELLING THEY OWN PRODUCTS)
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Admin Panel</title>

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
        include('layout.php');
    ?>  
      
    <div class="container">                  
        <div class="products">
            <center>
                <h1> A L L &nbsp &nbsp P R O D U C T S </h1>
            </center>

            <?php
                if (isset($_GET['msg'])) {
                    switch($_GET['msg']) {
                        case "bookErr":
                            echo '<center><h2>Failed to insert book. The transaction has been rolled back.</h2></center>';
                            break;
                        case "authorCheckErr":
                            echo '<center><h2>Failed to check author. The transaction has been rolled back.</h2></center>';
                            break;
                        case "authorInsertErr":
                            echo '<center><h2>Failed to insert new author. The transaction has been rolled back.</h2></center>';
                            break;
                        case "authorListErr";
                            echo '<center><h2>Failed to link author to book. The transaction has been rolled back.</h2></center>';
                            break;
                        case "imageErr":
                            echo '<center><h2>Failed to insert book image. The transaction has been rolled back.</h2></center>';
                            break;
                        case "invErr":
                            echo '<center><h2>Failed to set product inventory. The transaction has been rolled back.</h2></center>';
                            break;
                        default:
                            break;
                    }
                } 

                if ($feedbackMessage != null) {
                    echo '<center><h2>'. $feedbackMessage .'</h2></center>';
                    unset($_GET['action']);
                }

                if (isset($_GET['fetch']) && $_GET['fetch'] == "err") {
                    echo '<div style="margin: 10px 0 20px 0;"><center><h3> There was an error fetching the products. Please try again later.</h3>';
                    echo '<a href="'.$HOME.'allProducts.php"><button>Click here to refresh</button></a></center></div>';
                }

                // ===================================================
                // ADD NEW PRODUCT FORM
                // ===================================================
                if (isset($_GET['action']) && $_GET['action'] == "add") {

                    echo ' <hr><div><center>';
                    echo ' <h1> You are adding a new Product</h1></br>';
                    echo ' <form method="post" action="" style="max-width: 600px; margin: auto; text-align: left;">';
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
                    echo '    <textarea required name="bookdesc" style="height: 150px;"></textarea>';
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
                    echo '    <input required name="bookgenre" placeholder="Genre (Note: Not yet implemented)">';
                    echo '  </div>';

                    echo '  <div class="form-group">';
                    echo '    <label for="bookformat">Format: </label>';
                    echo '    <input required name="bookformat" placeholder="e.g., Hardcover">';
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
                    echo '    <input required name="bookprice" placeholder="e.g., 19.99">';
                    echo '  </div>';

                    echo '  <div class="form-group">';
                    echo '    <label for="bookimg">Book Cover Image URL: </label>';
                    echo '    <input required name="bookimg" type="url" placeholder="https://...">';
                    echo '  </div>';

                    echo '  <div>';
                    echo '      <button name="addProduct" type="submit" value="go"> Save </button>';
                    echo '      </div>';
                    echo '  </form>';
                    echo ' </br></center></div><hr>';
                } else {
                    // ===================================================
                    // LIST ALL PRODUCT
                    // ===================================================
                    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && $_SESSION['admin'] == true) {
                        $tsql = "SELECT * FROM book";
                        $getBooks = sqlsrv_query($conn, $tsql);

                        echo '     <div><center><a href="/allProducts.php?action=add"><button style="padding: 10px; color: green;">ADD NEW PRODUCT</button></a></center></div>';
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
                                $bookId = $bookRow['book_id'];
                                $bookTitle = $bookRow['book_title'];
                                $bookDesc = $bookRow['prod_desc'];
                                $bookISBN = $bookRow['book_isbn'];
                                $bookPubDate = $bookRow['book_published_date']->format('Y-m-d');
                                $bookPrice = $bookRow['price'];
                                $bookFormat = $bookRow['book_format'];
                                $bookPages = $bookRow['num_pages'];
                                $bookPubName = $bookRow['publisher_name'];

                                echo '            <tr style="border: 1px solid;">';
                                echo '                <td><div><h3>'.htmlspecialchars($bookId).'</h3></div>';
                                // echo '                        <div style="margin: 10px 0px;"><a href="">Edit</a></div>';  //FUTURE IMPLEMENTATION
                                // echo '                        <div style="margin: 10px 0px;"><a href="">Delete</a></div>';  //FUTURE IMPLEMENTATION
                                // echo '                        <div style="margin: 10px 0px;"><a href="">Inactive</a></div>';  //FUTURE IMPLEMENTATION
                                echo '                        <div style="margin: 10px 0px;"><a href="'.$HOME.'/pages/product.php?isbn='.urlencode($bookISBN).'" target="_blank">View</a></div>';
                                echo '                        </td>'; 
                                echo '                <td>'.htmlspecialchars($bookTitle).'</td>';
                                echo '                <td>'.htmlspecialchars($bookISBN).'</td>';
                                echo '                <td>'.htmlspecialchars($bookFormat).'</td>';
                                echo '                <td>'.htmlspecialchars($bookDesc).'</td>';
                                echo '                <td>'.htmlspecialchars($bookPages).'</td>';
                                echo '                <td>'.htmlspecialchars($bookPubName).'</td>';
                                echo '                <td>'.htmlspecialchars($bookPubDate).'</td>';
                                echo '                <td>'.number_format($bookPrice, 2).'</td>';
                                echo '            </tr>';
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            // die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            redirect($HOME."allProducts.php?fetch=err");
                        }                                
                    } else { // NOT LOGGED IN redirect to login page
                        redirect($HOME."pages/login.php");
                    }
                }
            ?>
        </div>
    </div> <!-- end of container -->
</body>

</html>