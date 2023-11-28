<?php
  session_start();
  include('functions.php');
  include('config.php');
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true || $_SESSION["admin"] != true) {
    redirect("https://php-back2books.azurewebsites.net/");
  }
?>
<!DOCTYPE html>
<html lang="en">

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
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php include('layout.php');
    ?>  
      
    <div class="container">
                              
        <div class="products">
            <center>
                <h1> A L L &nbsp &nbsp U S E R S </h1>
            </center>
            <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && $_SESSION["admin"] == true) {
                        $tsql = "SELECT * FROM B2BUSER";
                        $getUsers = sqlsrv_query($conn, $tsql);

                        echo '    <div class="products">
                                    <table style="width: 100%; text-align: center;border: 1px solid; border-collapse: collapse;">';
                        echo '        <thead>';
                        echo '            <tr style="border: 1px solid;">';
                        echo '                <th>User Id</th>';
                        echo '                <th>Active</th>';
                        echo '                <th>Email</th>';
                        echo '                <th>Password</th>';
                        echo '                <th>First Name</th>';
                        echo '                <th>Last Name</th>';
                        echo '                <th>Secret Question</th>';
                        echo '                <th>Secret Answer</th>';
                        echo '            </tr>';
                        echo '        </thead>';
                        echo '        <tbody>';

                        if ($getUsers != null){
                            while($userRow = sqlsrv_fetch_array($getUsers, SQLSRV_FETCH_ASSOC)) {
                                $userId = $userRow['USER_ID'];
                                $userEmail = $userRow['USER_EMAIL'];
                                // $userPassword = $userRow['USER_PASSWORD'];
                                $userFName = $userRow['USER_FNAME'];
                                $userLName = $userRow['USER_LNAME'];
                                $userActive = $userRow['USER_ACTIVE'];
                                $userSQ = $userRow['USER_SQ'];
                                // $userSA = $userRow['USER_SA'];

                                echo '            <tr style="border: 1px solid;">';
                                echo '                <td><div><h3>'.$userId.'</h3></div>';
                                echo '                        <div style="margin: 10px 0px;"><a href="">Edit</a></div>';
                                echo '                        </td>'; 
                                echo '                <td>'.$userActive.'</td>';
                                echo '                <td>'.$userEmail.'</td>';
                                echo '                <td> ********** </td>';
                                echo '                <td>'.$userFName.'</td>';
                                echo '                <td>'.$userLName.'</td>';
                                echo '                <td>'.$userSQ.'</td>';
                                echo '                <td> ********** </td>';
                                echo '            </tr>';
                            }
                            echo '        </tbody>';
                            echo '    </table></div>';
                        } else {
                            die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            //redirect("https://php-back2books.azurewebsites.net/allUsers.php?fetch=err");
                        }                                
                    } else {
                        redirect("https://php-back2books.azurewebsites.net/");
                    }
                ?>
        </div>
</body>

</html>