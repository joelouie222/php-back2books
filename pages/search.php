<!DOCTYPE html>
<?php
include '../layout.php'
?>
<html lang="us">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- OUR CSS -->
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="../logo-style.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
    </head>

<h1>Search page</h1>

<div class="catalog-container">
<?php
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sortBy = $_POST['sortBy'];

    $sql = "SELECT * FROM BOOKS B
        INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
        INNER JOIN AUTHOR_LIST AL ON B.BOOK_ID = AL.BOOK_ID
        INNER JOIN AUTHOR A ON AL.AUTHOR_ID = A.AUTHOR_ID
        INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID
        WHERE BOOK_TITLE LIKE '%$search%' OR
        BOOK_ISBN LIKE '%$search%' OR
        author_fname LIKE '%$search%' OR 
        author_lname LIKE '%$search%'";

    if ($sortBy == "priceLowToHigh") {
        $sql .= " ORDER BY PRICE ASC";
    } elseif ($sortBy == "priceHighToLow") {
        $sql .= " ORDER BY PRICE DESC";
    } elseif ($sortBy == "availability") {
        $sql .= " ORDER BY INV_QUANTITY DESC";
    }

    $result = sqlsrv_query($conn, $sql);

    if ($result == false) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo "<a href='product.php?isbn=".$row['BOOK_ISBN']."'><div class='book-container'>
            <img class='search-cover' src=".$row['IMAGE_LINK']." alt='Book Cover'>
            <div class='book-info-container'>
            <h1>".$row['BOOK_TITLE']."</h1>
            <p>".$row['author_fname']." ".$row['author_lname']."</p>
            <p>".$row['BOOK_ISBN']."</p>
            <p>".$row['PRICE']."</p>
            <p>".$row['INV_QUANTITY']."</p>
            </div>
            </div></a>";
        echo '<div>
            <button class="search-add" name="submit" type="submit"> ADD TO CART </button>
            </div>';
    } 
}
?>
</div>
</html>
