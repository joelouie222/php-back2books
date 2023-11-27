<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PHP Back2Books</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- OUR CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="logo-style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php
        // Include the configuration file
        //include('config.php');
        include('layout.php');
    ?>
    <div class="container">
        <div class="content">
            <div class="about-us">
                <?php
                    if (isset($_SESSION["loggedIn"]) AND $_SESSION["loggedIn"] == true)
                        echo '<h3> Wecome to Back 2 Books, '.$_SESSION['fname'].' '.$_SESSION['lname'].'!</h3>';
                    else
                        echo '<h3> Wecome to Back 2 Books!</h3>';

                    if (isset($_SESSION["admin"]) AND $_SESSION["admin"] == 1)
                        echo '<h3> You are an ADMIN! </h3>';
                    else
                        echo '<h3> You are NOT an admin! </h3>';
                    echo '<p> SESSION-loggedIn: '.$_SESSION["loggedIn"].'<p>';
                    echo '<p> SESSION-USER_FNAME: '.$_SESSION["fname"].'<p>';
                    echo '<p> SESSION-USER_LNAME: '.$_SESSION['lname'].'<p>';
                    echo '<p> SESSION-USER_ADMIN: '.$_SESSION["admin"].'<p>';
                    echo '<p> SESSION-loginEmail: '.$_SESSION["loginEmail"].'<p>';
                    echo '<p> SESSION-hashedPassword: '.$_SESSION["hashedPassword"].'<p>';
                ?>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="gallery-container-carousel">
                    <!--prev button-->
                    <div>
                        <button class="prev-btn">&larr;</button>
                    </div>
                    <!--next button-->
                    <div>
                        <button class="next-btn">&rarr;</button>
                    </div>
                    
                        <?php
                            $query = "SELECT b.*, bi.IMAGE_LINK FROM BOOKS b LEFT JOIN BOOK_IMAGE bi ON b.BOOK_ID = bi.book_id LIMIT 10";
                            $result = sqlsrv_query($conn, $query);
                            if ($result->num_rows > 0) {
                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <div class="card-container-carousel">
                                        <div class="card-carousel">
                                            <a class="book-card-carousel">
                                            <img src="<?php echo $row['IMAGE_LINK']; ?>"
                                            alt="<?php echo $row['BOOK_TITLE']; ?> book cover">
                                            <p><?php echo $row['BOOK_TITLE']; ?></p>
                                            </a>
                                        </div>
                                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
    <div class="contact-us">
        <h2>Contact Us</h2>
        <p>
            please don't, we will cry if you yell at us. Seriously though, you can contact us at
            1*1-1*1-1111
        </p>
    </div>

    <div class="about-us">
        <p>Copyright 2023 Back 2 Books (B2B)</p>
    </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const cardContainer = document.querySelector(".card-container-carousel");
        const cards = document.querySelectorAll(".card-carousel");

        let currentIndex = 0;

        function showCard(index) {
            const cardWidth = cards[0].offsetWidth;
            currentIndex = index;
            cardContainer.style.transition = "transform 0.5s ease-in-out";
            cardContainer.style.transform = `translateX(${-index * cardWidth}px)`;
        }

        function nextCards() {
            currentIndex = (currentIndex + 4) % cards.length;
            showCard(currentIndex);
        }

        function prevCards() {
            currentIndex = (currentIndex - 4 + cards.length) % cards.length;
            showCard(currentIndex);
        }

        document.querySelector(".prev-btn").addEventListener("click", prevCards);
        document.querySelector(".next-btn").addEventListener("click", nextCards);

        // Initial display
        showCard(currentIndex);
    });
    </script>

</body>


<script src="js/scripts.js"></script>

</html>