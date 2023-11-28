<?php
    include '../config.php'
?>
<h1>Search page</h1>

<div class="catalog-container">
<?php
    if (isset($_POST['search'])) {
        // $search = mysqli_real_escape_string($conn, $_POST['search']);
        $sql = "SELECT * FROM BOOKS WHERE BOOK_TITLE LIKE '%search%'";
        $result = sqlsrv_query($conn, $sql);

        if ($result == false) {
            die(print_r(sqlsrv_errors(), true));
        }
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "
                <h3>".$row['BOOK_TITLE']."</h3>
                ";
        } 
    }
?>
</div>
