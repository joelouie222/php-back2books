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
    <?php include('../layouts/layout.php');
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

        <div>
            <ol class="book-list-view">
                <li style="border: solid;">
                    <div style="margin-left: 0; margin-right: 0;">
                        <div style="align-items: flex-start; width: 30%;">
                            <div>1</div>
                            <div style="display: flex;">
                                <a href="">
                                    <img src="https://png.pngtree.com/png-clipart/20190904/original/pngtree-retro-book-free-material-png-image_4481187.jpg" alt="Product 1" width="100" height="100">
                                </a>
                            </div>
                        </div>
                        <div style="width: 70%">
                            <div><h3><a>[BOOK TITLE]</a><span>(BOOK_PUBDATE)</span></h3></div>
                            <div>Author: [AUTHOR] </div>
                            <div>[PRODUCT_DESC]</div>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Format</th>
                                            <th>ISBN</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>[FORMAT]</td>
                                            <td>[ISBN]</td>
                                            <td>[PRICE]</td>
                                            <td>[AVAIL]</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="display: flex;">
                                <div><input type="hidden" value="[ISBN]"></div>
                                <div style="float: right; cursor: pointer;"><button type="submit" value="ADDTOFAV"> ADD TO FAV </button></div>
                                <div style="float: right; cursor: pointer;"><button type="submit" value="ADDTOCART"> ADD TO CART </button></div>
                            </div>
                        </div>
                    </div> 
                </li>
            </ol>
        </div>


    </div>
</body>

</html>