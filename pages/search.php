<?php
    include '../config.php'
?>
<h1>Search page</h1>

<div class="catalog-container">
<?php
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM BOOKS WHERE BOOK_TITLE LIKE '%$search%'
                OR AUTHOR_FNAME LIKE '%$search%' OR AUTHOR_LNAME LIKE
                '%$search%'";
        $result = sqlsrv_query($conn, $sql);

        if ($result == false) {
            die(print_r(sqlsrv_errors(), true));
        }
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<p>{$row['BOOK_TITLE']}</p>";
            echo "<p>{$row['AUTHOR_FNAME']}</p>";
            echo "<p>{$row['AUTHOR_LNAME']}</p>";
        } 
    }
?>
</div>
