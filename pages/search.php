<?php
    include '../config.php'
?>
<h1>Search page</h1>

<div class="catalog-container">
<?php
    if (isset($_POST['submit-search'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        $sql = "SELECt * FROM BOOKS WHERE book_title LIKE '%search%'";
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);

        if ($queryResult > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='book-box'>
                    <h3>".$row['book_title']."</h3>
                    <p>".$row['prod_desc']."</p>
                    </div>";
            } 
        }
        else echo "There are not results matching your search!";
    }
?>
</div>
