<?php
  session_start();
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

    FONT AWESOME 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
    <!-- OUR CSS -->
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body>
    <div class="container">
        <?php
          include('../layouts/layout.php');          
          include('../config.php');
          include('../functions.php');
          
          $userEmail = "";
          $userPassword = "";
          $emailErr = "";
          $passwordErr = "";
          $loginErr = "";
          
          if($_SERVER["REQUEST_METHOD"] == "POST")
          { 
            if(empty(trim($_POST["loginEmail"]))){
              $emailErr = "emptyEmail";
            } else {
              $userEmail = trim($_POST["loginEmail"]);
            }
          
            if(empty(trim($_POST["loginPassword"]))){
              $passwordErr = "emptyPassword";
            } else {
              $userPassword = trim($_POST["loginPassword"]);
            }
          
            $hashedPassword = md5($userPassword);
            

            if(empty($emailErr) && empty($passwordErr)){
              $tsql = "SELECT USER_FNAME, USER_LNAME, USER_ADMIN FROM B2BUSER 
                      WHERE USER_ACTIVE = 1
                      AND USER_EMAIL LIKE '$userEmail' AND USER_PASSWORD LIKE '$hashedPassword'";
              $getUser = sqlsrv_query($conn, $tsql);
              if( $getUser == false ) { 
                redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
              }
                while($user = sqlsrv_fetch_array($getUser, SQLSRV_FETCH_ASSOC)) {
                  echo '<p> USER_FNAME: '.$user["USER_FNAME"].'<p>';
                  echo '<p> USER_LNAME: '.$user["USER_LNAME"].'<p>';
                  echo '<p> USER_ADMIN: '.$user["USER_ADMIN"].'<p>';
  
                  $_SESSION["loggedIn"] = true;
                  $_SESSION["fname"] = $user["USER_FNAME"];
                  $_SESSION['lname'] = $user["USER_LNAME"];
                  $_SESSION["admin"] = $user["USER_ADMIN"];
                  $_SESSION["loginEmail"] = $userEmail;
                  $_SESSION["hashedPassword"] = $hashedPassword;
  
                  sqlsrv_free_stmt($getUser);
                  if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
                    redirect("https://php-back2books.azurewebsites.net/");
                    exit;
                  } else {
                    redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
                  }
                }
            } else {
              redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
            }
          }
          redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
        ?>  
        
        <div class="about-us">
          <center>
                <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
            <div>
                <?php
                  if(isset($_GET['verify']) && ($_GET['verify']) == "failed"){
                    echo "<h1> Login failed. Unable to verify email/password. Please try again! </h1>";
                  }
                ?>
            </div>

            <div>
                <form method="post" action="">
                  <!-- Email input -->
                  <div class="form-group">
                    <label for="loginEmail">Email Address</label>
                    <input name="loginEmail" type="email" class="form-control" id="loginEmail" placeholder="Email">
                    <p id="loginEmailStatus"></p>
                  </div>
                      
                  <!-- Password input -->
                  <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input name="loginPassword" type="password" class="form-control" id="loginPassword" placeholder="Password">
                    <p id="loginPasswordStatus"></p>
                  </div>
                  
                  <!-- Submit button -->
                  <div>
                  <button name="submit" type="submit" value="submit">Submit</button>
                  </div>
                  <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                </form>
            </div>
          </center>
        </div>
    </div>
</div>
</div>
</section>
        
           
                
</body>

</html>
<script src="/js/login_validation.js"></script>  