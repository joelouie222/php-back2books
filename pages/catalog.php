<!DOCTYPE html>
<html>

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
    <link rel="icon" type="image/x-icon" href="../images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php 
        include('../layouts/layout.php');
        include('../config.php');
    ?>  
      
    <div class="container">
        <section id="products" class="products">
            <table width="100%">
                <tr>
                    <td colspan="2">
                        <h2>Products</h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="https://png.pngtree.com/png-clipart/20190904/original/pngtree-retro-book-free-material-png-image_4481187.jpg"
                            alt="Product 1" alt="Temporary Product 1" width="100" height="100">
                        <h3>Product 1</h3>
                        <p>This is a product description.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde magni repellendus nemo? Sit
                            rerum unde rem
                            enim commodi repellat laboriosam, dolore delectus velit molestiae, pariatur eius
                            necessitatibus, officiis
                            excepturi ab?
                        </p>
                        <button>Add to Cart</button>
                    </td>

                    <td>
                        <img src="https://png.pngtree.com/png-clipart/20190904/original/pngtree-retro-book-free-material-png-image_4481187.jpg"
                            alt="Product 2" alt="Temporary Product 2" width="100" height="100">
                        <h3>Product 2</h3>
                        <p>This is another product description. Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Deserunt
                            modi, accusantium perferendis vitae eos fugiat expedita repudiandae impedit omnis! Fugit
                            ipsam amet
                            debitis accusantium a atque nostrum, deleniti exercitationem odit?</p>
                        <button>Add to Cart</button>
                    </td>

                </tr>        
            </table>
        </section>

        <div class="products">
            <center>
                <h1> Book Catalog </h1>
            </center>
        </div>

        <div class="products">
            
        </div>

        <div class="products">
            <ol class="book-list-view">
                <?php
                    $tsql = "SELECT TOP (10) *
                            FROM BOOKS B
                            INNER JOIN BOOK_IMAGE BI ON B.BOOK_ID = BI.BOOK_ID
                            INNER JOIN AUTHOR_LIST AL ON B.BOOK_ID = AL.BOOK_ID
                            INNER JOIN AUTHOR A ON AL.AUTHOR_ID = A.AUTHOR_ID
                            INNER JOIN PRODUCT_INVENTORY PI ON PI.BOOK_ID = B.BOOK_ID";
                    $getBooks = sqlsrv_query($conn, $tsql);

                    echo "connectionInfo: ($connectionInfo)";
                    echo "</br>";
                    echo "serverName: ($serverName)";
                    echo "</br>";
                    echo "conn: ($conn)";
                    echo "</br>";
                    echo "</hr>";

                    if($getBooks == false ) {  
                        echo "Error in statement preparation/execution.\n";  
                        die( print_r( sqlsrv_errors(), true));
                    }
                    $count = 1;
                    while($row = sqlsrv_fetch_array($getBooks, SQLSRV_FETCH_ASSOC)) {
                        
                        echo '<p>[BOOK TITLE]: '.$row['BOOK_TITLE'].'</p>';
                        echo '<p>[PROD_DESC]: '.$row['PROD_DESC'].'</p>';
                        echo '<p>[BOOK_ISBN]: '.$row['BOOK_ISBN'].'</p>';
                        // $date = $row['BOOK_PUBLISHED_DATE'];
                        // $formattedDate = date("Y-m-d", strtotime($date));
                        echo '<p>[BOOK_PUBLISHED_DATE]: '.$row['BOOK_PUBLISHED_DATE']->format('Y-m-d').'</p>';
                        echo '<p>[PRICE]: '.$row['PRICE'].'</p>';
                        echo '<p>[BOOK_FORMAT]: '.$row['BOOK_FORMAT'].'</p>';
                        echo '<p>[NUM_PAGES]: '.$row['NUM_PAGES'].'</p>';
                        echo '<p>[PUBLISHER_NAME]: '.$row['PUBLISHER_NAME'].'</p>';
                        echo '<p>[IMAGE_LINK]: '.$row['IMAGE_LINK'].'</p>';
                        echo '<p>[INV_QUANTITY]: '.$row['INV_QUANTITY'].'</p>';
                        echo '<p>[Author_fname]: '.$row['author_fname'].'</p>';
                        echo '<p>[author_lname]: '.$row['author_lname'].'</p>';
                        echo '</br></br>';

                        echo '<li style="border: solid; margin: 5px;">';
                        echo '    <div style="margin-left: 0; margin-right: 0; display: flex;">';
                        echo '        <div style="align-items: center; width: 30%; display: flex">';
                        echo '            <div style="margin: 10px"><h3>'$count'</h3></div>';
                        echo '            <div style="margin: 10px">';
                        echo '                <a href="">';
                        echo '                    <img src="'.$row['IMAGE_LINK'].'" alt="Image of Book '.$row['BOOK_TITLE'].'" width="200" height="200">';
                        echo '                </a>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div style="width: 70%; display: flex; flex-direction: column;">';
                        echo '            <div style="margin: 5px 0 5px 0;"><h3><a>'.$row['BOOK_TITLE'].'</a><span style="margin-left: 10px;">('.$row['BOOK_PUBLISHED_DATE']->format('Y-m-d').')</span></h3></div>';
                        echo '            <div><span style="margin-right: 10px;">Author: <strong>'.$row['author_fname'].' '.$row['author_lname'].'</strong></span><span>Publisher: <strong>'.$row['PUBLISHER_NAME'].'</strong></span></div>';
                        echo '            <div style="margin: 10px 0 10px 0; height: 200px; overflow: scroll;">'.$row['PROD_DESC'].'</div>';
                        echo '            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between; align-items: flex-end;">';
                        echo '                <div>';
                        echo '                    <table>';
                        echo '                        <thead>';
                        echo '                            <tr>';
                        echo '                                <th>ISBN</th>';
                        echo '                                <th>Format</th>';
                        echo '                                <th>Pages</th>';
                        echo '                                <th>Stock</th>';
                        // echo '                                <th>Price</th>';
                        echo '                            </tr>';
                        echo '                        </thead>';
                        echo '                        <tbody>';
                        echo '                            <tr>';
                        echo '                                <td>'.$row['BOOK_ISBN'].'</td> ';
                        echo '                                <td>'.$row['BOOK_FORMAT'].'</td>';
                        echo '                                <td>'.$row['NUM_PAGES'].'</td>';
                        echo '                                <td>'.$row['INV_QUANTITY'].'</td>';
                        // echo '                                <td>'.$row['PRICE'].'</td>';
                        echo '                            </tr>';
                        echo '                        </tbody>';
                        echo '                    </table>';
                        echo '                </div>';
                        echo '                <div><h1>$ '.$row['PRICE'].'</h1></div>  ';
                        echo '                <div style="display: flex; align-items: flex-end;">';
                        echo '                   <div><input type="hidden" value="'.$row['BOOK_ID'].'"></div>';
                        echo '                    <div style="margin-right: 10px; cursor: pointer;"><button type="submit" value="ADDTOFAV"><i class="fa fa-heart fa-2x"></i></button></div>';
                        echo '                   <div style="cursor: pointer;"><button type="submit" value="ADDTOCART"> ADD TO CART </button></div>';
                        echo '                </div>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div> ';
                        echo '</li>';
                        $count++;
                    }
                    sqlsrv_free_stmt($getBooks);
                ?>


                <li style="border: solid; margin: 5px;">
                    <div style="margin-left: 0; margin-right: 0; display: flex;">
                        <div style="align-items: center; width: 30%; display: flex">
                            <div style="margin: 10px"><h3>1</h3></div>
                            <div style="margin: 10px">
                                <a href="">
                                    <img src="https://png.pngtree.com/png-clipart/20190904/original/pngtree-retro-book-free-material-png-image_4481187.jpg" alt="Product 1" width="100" height="100">
                                </a>
                            </div>
                        </div>
                        <div style="width: 70%; display: flex; flex-direction: column;">
                            <div style="margin: 5px 0 5px 0;"><h3><a>[BOOK TITLE]</a><span>(BOOK_PUBDATE)</span></h3></div>
                            <div><span style="margin-right: 10px;">Author: [AUTHOR]</span><span>Publisher: [PUBLISHER_NAME]</span></div>
                            <div style="margin: 10px 0 10px 0; overflow-y: scroll; overflow-x: hidden;">[PRODUCT_DESC: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.]</div>
                            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between">
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ISBN</th>
                                                <th>Format</th>
                                                <th>Pages</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>[ISBN]</td> 
                                                <td>[FORMAT]</td>
                                                <td>[PAGES]</td>
                                                <td>[AVAIL]</td>
                                                <td>[PRICE]</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="display: flex; align-items: flex-end;">
                                    <div><input type="hidden" value="[ISBN]"></div>
                                    <div style="margin-right: 10px; cursor: pointer;"><button type="submit" value="ADDTOFAV"><i class="fa fa-heart fa-2x"></i></button></div>
                                    <div style="cursor: pointer;"><button type="submit" value="ADDTOCART"> ADD TO CART </button></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </li>
            </ol>
        </div>


    </div>
</body>

</html>