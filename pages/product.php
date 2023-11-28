<?php
include '../config.php';
?>

<h1>Product page</h1>

<div class="catalog-container">
<?php
    $isbn = $_GET['isbn'];
    $tsql = "SELECT * FROM BOOKS B
        INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
        INNER JOIN AUTHOR_LIST AL ON B.BOOK_ID = AL.BOOK_ID
        INNER JOIN AUTHOR A ON AL.AUTHOR_ID = A.AUTHOR_ID
        INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID
        BOOK_ISBN LIKE '%$isbn%'";
    
    $result = sqlsrv_query($conn, $tsql);
    
    if ($result == false) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo "<a href='product.php?ISBN=".$row['BOOK_ISBN']."'><div class='book-container'>
            <h1>".$row['BOOK_TITLE']."</h1>
            <p>".$row['author_fname']."</p>
            <p>".$row['author_lname']."</p>
            <p>".$row['BOOK_ISBN']."</p>
            <p>".$row['PRICE']."</p>
            </div>";
    } 
?>
</div>
