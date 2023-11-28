<?php
    include '../config.php'
?>
<h1>Search page</h1>

<div class="catalog-container">
<?php
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM BOOKS WHERE 
            BOOK_TITLE LIKE '%$search%' OR 
            author_fname LIKE '%$search%' OR 
            author_lname LIKE '%$search%'";
        $result = sqlsrv_query($conn, $sql);

        if ($result == false) {
            die(print_r(sqlsrv_errors(), true));
        }
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "div class='book-box'
                <h1>".$row['BOOK_TITLE']."</h1>
                <p>".$row['author_fname']."</p>
                <p>".$row['author_lname']."</p>
                </div>";
        } 
    }
?>
</div>
