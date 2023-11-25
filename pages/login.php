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
          
          if(isset($_POST['submit']) && $_POST['submit']=="submit")
          { 
            $userEmail = "";
            $userPassword = "";
            $emailErr = "";
            $passwordErr = "";
            $loginErr = "";

            if(empty(trim($_POST["loginEmail"]))){
              $emailErr = "emptyEmail";
              redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=empty");
            } else {
              $userEmail = trim($_POST["loginEmail"]);
            }
          
            if(empty(trim($_POST["loginPassword"]))){
              $passwordErr = "emptyPassword";
              redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=empty");
            } else {
              $userPassword = trim($_POST["loginPassword"]);
            }
          
            $hashedPassword = md5($userPassword);
            
            if(empty($emailErr) && empty($passwordErr)){
              $tsql = "SELECT USER_FNAME, USER_LNAME, USER_ADMIN FROM B2BUSER 
                      WHERE USER_ACTIVE = 1
                      AND USER_EMAIL LIKE '$userEmail' AND USER_PASSWORD LIKE '$hashedPassword'";
              $getUser = sqlsrv_query($conn, $tsql);

              // echo "<h1>getUser: '.$getUser.' </h1>";

              if( $getUser == false ) { 
                redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
              } else {
                $user = sqlsrv_fetch_array($getUser, SQLSRV_FETCH_ASSOC); 
                  if ($user == null) {
                    redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
                  } else {
                    if ($user["USER_FNAME"] == null || $user["USER_LNAME"] = null) {
                      redirect("https://php-back2books.azurewebsites.net/pages/login.php?verify=failed");
                    } else {
                      $_SESSION["loggedIn"] = true;
                      $_SESSION["fname"] = $user["USER_FNAME"];
                      $_SESSION['lname'] = $user["USER_LNAME"];
                      $_SESSION["admin"] = $user["USER_ADMIN"];
                      $_SESSION["loginEmail"] = $userEmail;
                      $_SESSION["hashedPassword"] = $hashedPassword;
                      sqlsrv_free_stmt($getUser);
                      //sqlsrv_free_stmt($user);
                      redirect("https://php-back2books.azurewebsites.net/");
                    }
                  }
                
                // $user = sqlsrv_fetch_array($getUser, SQLSRV_FETCH_ASSOC);
                // if ($user == null)
                //   echo "<h1>user is null</h1>";
                // if ($user == false)
                //   echo "<h1>user is false</h1>";
                // if ($user == '..')
                //   echo "<h1>user is ..</h1>";
                // echo "<h1>user: '.$user.' </h1>";
                // echo "<h1>getUser: '.$user[USER_FNAME].' </h1>";
                // echo "<h1>getUser: '.$user[USER_LNAME].' </h1>";
                // echo "<h1>getUser: '.$user[USER_ADMIN].' </h1>";
              }
              
            }
          }
        ?>  
        
        <div class="about-us">
          <center>
                <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
            <div>
                <?php
                  if(isset($_GET['verify']) && ($_GET['verify']) == "failed"){
                    echo "<h1> Login failed. Unable to verify email/password. Please try again! </h1>";
                  }
                  if(isset($_GET['verify']) && ($_GET['verify']) == "empty"){
                    echo "<h1> Email or password cannot be empty! Please try again. </h1>";
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