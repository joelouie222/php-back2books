<?php
    include '../config.php'
?>
<h1>Search page</h1>

<div class="catalog-container">
<?php
    if (isset($_POST['submit-search'])) {
        // $search = mysqli_real_escape_string($conn, $_POST['search']);
        $sql = "SELECT * FROM BOOKS WHERE BOOK_TITLE LIKE '%search%'";
        $cnt = "SELECT COUNT(*) FROM BOOKS WHERE BOOK_TITLE LIKE '%search%'";
        $result = sqlsrv_query($conn, $sql);
        $queryCount = sqlsrv_query($conn, $cnt);

        if ($cnt > 0) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "<div class='book-box'>
                    <h3>".$row['BOOK_TITLE']."</h3>
                    <p>".$row['PROD_DESC']."</p>
                    </div>";
            } 
        }
        else echo "There are not results matching your search!";
    }
?>
</div>
