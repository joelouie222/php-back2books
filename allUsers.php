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

                        if (isset($_POST["userUpdate"]) && $_POST["userUpdate"] == "go") {
                            $userid = $_POST['userid'];
                            $useremail =$_POST['useremail'];
                            $userpass = md5($_POST['userpass']);
                            $userfname =$_POST['fname'];
                            $userlname = $_POST['lname'];
                            $useractive = $_POST['useractive'];
                            $usersq = $_POST['usersq'];
                            $usersa = $_POST['usersa'];

                            // echo 'userid: '.$userid.'';
                            // echo 'useremail: '.$useremail.'';
                            // echo 'userpass: '.$userpass.'';
                            // echo 'userfname: '.$userfname.'';
                            // echo 'userlname: '.$userlname.'';
                            // echo 'useractive: '.$useractive.'';
                            // echo 'usersq: '.$usersq.'';
                            // echo 'usersa: '.$usersa.'';

                            $tsql = "UPDATE B2BUSER
                            SET
                            USER_EMAIL = '$useremail', 
                            USER_PASSWORD = '$userpass',
                            USER_FNAME = '$userfname',
                            USER_LNAME = '$userlname',
                            USER_ACTIVE = '$useractive',
                            USER_SQ = '$usersq',
                            USER_SA = '$usersa'
                            WHERE USER_ID = '$userid'";

                            $updateUser = sqlsrv_query($conn, $tsql);
          
                            if ($updateUser === false) {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                            }
                            redirect("https://php-back2books.azurewebsites.net/allUsers.php");
                        }



                        if (isset($_GET['id'])) {
                            $userid = $_GET['id'];

                            $tsql = "SELECT * FROM B2BUSER WHERE USER_ID = '$userid'";
                            $getUser = sqlsrv_query($conn, $tsql);

                            if ($getUser == NULL) {
                                die(print_r(sqlsrv_errors(), true));  // Print detailed error information
                                //redirect("https://php-back2books.azurewebsites.net/allUsers.php?fetch=err");
                            }

                            while($userInfo = sqlsrv_fetch_array($getUser, SQLSRV_FETCH_ASSOC)) {
                                $userid = $userInfo['USER_ID'];
                                $useremail = $userInfo['USER_EMAIL'];
                                $userpass = $userInfo['USER_PASS'];
                                $userfname = $userInfo['USER_FNAME'];
                                $userlname = $userInfo['USER_LNAME'];
                                // $useradmin = 
                                $useractive = $userInfo['USER_ACTIVE'];
                                $usersq = $userInfo['USER_SQ'];
                                $usersa = $userInfo['USER_SA'];

                            }
                            echo ' <hr><center>';
                            echo ' <h1> You are editing User ID #: '.$userid.'</h1></br>';
                            echo ' <form method="post" action="">';
                            echo '  <div class="form-group">';
                            echo '    <input type="hidden" name="userid" value="'.$userid.'">';
                            echo '    <label for="useridview">User Id: </label>';
                            echo '    <input required disabled name="useridview" value="'.$userid.'">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="useremail">Email Address: </label>';
                            echo '    <input required name="useremail" type="email" value="'.$useremail.'">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="userpass">User Password: </label>';
                            echo '    <input required name="userpass" type="password" value="**************">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="fname">First Name: </label>';
                            echo '    <input required name="fname" value="'.$userfname.'">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="lname">Last Name: </label>';
                            echo '    <input required name="lname" value="'.$userlname.'">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="useractive">Active:</label>';
                            echo '    <input required name="useractive" value="'.$useractive.'">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="usersq">Secret Question:</label>';
                            echo '    <input required name="usersq" value="'.$usersq.'" style="width: 400px;">';
                            echo '  </div>';

                            echo '  <div class="form-group">';
                            echo '    <label for="usersa">Secret Answer:</label>';
                            echo '    <input required name="usersa" value="'.$usersa.'" style="width: 400px;">';
                            echo '  </div>';

                            echo '  <div>';
                            echo '      <button name="userUpdate" type="submit" value="go"> Save </button>';
                            echo '      </div>';
                            echo '  </form>';
                            echo ' </br></center><hr>';
                        }


                        $tsql = "SELECT * FROM B2BUSER WHERE USER_ADMIN = 0";
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
                                echo '                        <div style="margin: 10px 0px;"><a href="/allUsers.php?id='.$userId.'">Edit</a></div>';
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