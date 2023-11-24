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
            <?php
                $tsql = "SELECT TOP [10] FROM BOOKS";
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


            ?>
        </div>

        <div class="products">
            <ol class="book-list-view">
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
                            <div>Author: [AUTHOR] </div>
                            <div style="margin: 10px 0 10px 0; overflow: scroll;">[PRODUCT_DESC: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.]</div>
                            <div style="display: flex; padding: 5px 25px 10px 0; justify-content: space-between">
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Format</th>
                                                <th>ISBN</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>[FORMAT]</td>
                                                <td>[ISBN]</td>                                                
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