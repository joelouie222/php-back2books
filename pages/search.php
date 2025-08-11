<?php
    session_start();
?>

<!DOCTYPE html>
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
    <!-- <link rel="stylesheet" href="../logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body>
    <?php
        include('../layout.php'); // includes configuration
        include('../functions.php');
    ?>
    <div class="container">
        <div id="content">
            <!----------- Search Bar ----------->
            <center>
                <div class="window search">

                    <?php
                        if (isset($_GET['msg']) && $_GET['msg'] == 'noresults') {
                            // Display error message if no results found
                            echo '<p style="color: red;">No results found. Please try a different search term.</p>';
                        }
                    ?>

                    <h2>Search for books</h2>
                    <br />
                    <p>Search for books, authors, or ISBNs. You can also sort the results by price or availability.</p>
                    <br />
                    <p>Note: The search is case-insensitive and will match any part of the book title, author name, or ISBN.</p>
                    <p>Use the search bar below to find books.</p>
                    <br />
                    <form action="search.php" method="POST">
                        <input type="text" id="search" name="search" placeholder="Books title, author, ISBN..." required>
                        <button type="submit"><i class="fa fa-search"></i></button><br />
                        <label for="sortBy">Sort By:</label>
                        <select id="sortBy" name="sortBy">
                            <option value="relevance">Relevance</option>
                            <option value="priceLowToHigh">Price: Low to High</option>
                            <option value="priceHighToLow">Price: High to Low</option>
                            <option value="availability">Availability</option>
                        </select>
                    </form>
                </div>
            </center>

            <center>
                <?php
                    // ===================================================
                    // SEARCH LOGIC
                    // ===================================================
                    if (isset($_POST['search'])) {
                        $search = $_POST['search'];
                        $sortBy = $_POST['sortBy'];

                        // remove invalid sql characters
                        $search = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $search);

                        // add wildcards for LIKE query
                        $search = '%' . $search . '%';

                        // parameterized query to prevent SQL injection
                        $sql = "SELECT B.*, A.*, BI.*, PI.* FROM book B
                                INNER JOIN book_image BI ON B.book_id = BI.book_id
                                INNER JOIN author_list AL ON B.book_id = AL.book_id
                                INNER JOIN author A ON AL.author_id = A.author_id
                                INNER JOIN product_inventory PI ON PI.book_id = B.book_id
                                WHERE B.book_title LIKE ? OR
                                    B.book_isbn LIKE ? OR
                                    A.author_fname LIKE ? OR
                                    A.author_lname LIKE ?";

                        $params = array($search, $search, $search, $search);

                        // switch if statements to switch case for better readability
                        switch ($sortBy) {
                            case "priceLowToHigh":
                                $sql .= " ORDER BY price ASC";
                                break;
                            case "priceHighToLow":
                                $sql .= " ORDER BY price DESC";
                                break;
                            case "availability":
                                $sql .= " ORDER BY inv_quantity DESC";
                                break;
                            default:
                                // Definition of relevance sorting
                                // This will prioritize results based on the search term matching book title, then author name, and lastly ISBN 
                                $sql .= " ORDER BY CASE
                                            WHEN B.book_title LIKE ? THEN 1
                                            WHEN A.author_fname LIKE ? THEN 2
                                            WHEN A.author_lname LIKE ? THEN 2
                                            WHEN B.book_isbn LIKE ? THEN 3
                                            ELSE 4
                                        END ASC";
                                
                                // Add the search term again for each condition in the CASE statement
                                $params[] = $searchTerm; // for book_title
                                $params[] = $searchTerm; // for author_fname
                                $params[] = $searchTerm; // for author_lname
                                $params[] = $searchTerm; // for book_isbn
                                break;
                        }

                        $result = sqlsrv_query($conn, $sql, $params);

                        // empty result check
                        if ($result === false || sqlsrv_has_rows($result) === false) {
                            redirect('search.php?msg=noresults');
                        }

                        // ===================================================
                        // DISPLAY RESULTS
                        // ===================================================
                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                            echo "<a href='product.php?isbn=".htmlspecialchars($row['book_isbn'])."'><div class='book-container'>
                                <img class='search-cover' src=".htmlspecialchars($row['image_link'])." alt='Book Cover'>
                                <div class='book-info-container'>
                                <h1>".htmlspecialchars($row['book_title'])."</h1>
                                <p>".htmlspecialchars($row['author_fname'])." ".htmlspecialchars($row['author_lname'])."</p>
                                <p>ISBN: ".htmlspecialchars($row['book_isbn'])."</p>
                                <p>Price: $".htmlspecialchars($row['price'])."</p>
                                <p>In stock: ".htmlspecialchars($row['inv_quantity'])."</p>
                                </div>
                                <br />
                                </div></a>";
                        } 
                    }
                ?>
            </center>
        </div> <!-- // end of content -->
    </div> <!-- // end of container -->
</body>

</html>