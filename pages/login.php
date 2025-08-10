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
    <!-- <link rel="stylesheet" href="/logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.ico">
</head>

<body>
    <div class="container">
        <?php
          include('../layout.php');          
          include('../functions.php');
          
          if(isset($_POST['submit']) && $_POST['submit']=="submit")
          { 
            $userEmail = "";
            $userPassword = "";
            $emailErr = "";
            $passwordErr = "";
            //$loginErr = "";

            if(empty(trim($_POST['loginEmail']))){
              $emailErr = "emptyEmail";
              redirect($HOME."pages/login.php?verify=empty");
            } else {
              $userEmail = trim($_POST['loginEmail']);
            }
          
            if(empty(trim($_POST['loginPassword']))){
              $passwordErr = "emptyPassword";
              redirect($HOME."pages/login.php?verify=empty");
            } else {
              $userPassword = trim($_POST['loginPassword']);
            }
          
            $hashedPassword = md5($userPassword);
            
            if(empty($emailErr) && empty($passwordErr)){
              $tsql = "SELECT user_id, user_fname, user_lname, user_admin FROM b2buser 
                      WHERE user_active = 1
                      AND user_email LIKE ? AND user_password LIKE ?";
              $getUser = sqlsrv_query($conn, $tsql, array($userEmail, $hashedPassword));

              if( $getUser == false ) { 
                redirect($HOME."pages/login.php?verify=failed");
              } else {
                $user = sqlsrv_fetch_array($getUser, SQLSRV_FETCH_ASSOC); 
                if ($user == null) {
                  redirect($HOME."pages/login.php?verify=failed");
                } else {
                  $_SESSION['loggedIn'] = true;
                  $_SESSION['fname'] = $user['user_fname'];
                  $_SESSION['lname'] = $user['user_lname'];
                  $_SESSION['admin'] = $user['user_admin'];
                  $_SESSION['userId'] = $user['user_id'];
                  $_SESSION['loginEmail'] = $userEmail;
                  $_SESSION['hashedPassword'] = $hashedPassword;
                  sqlsrv_free_stmt($getUser);
                  redirect($HOME);
                }
              }
            }
          }
        ?>  
        
        <div class="about-us">
          <center>
        <div class="login-container">
                <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
            <div>
                <?php
                  if(isset($_GET['verify']) && ($_GET['verify']) == "failed"){
                    echo "<h1> Login failed. Unable to verify email/password. Please try again! </h1>";
                  }
                  if(isset($_GET['verify']) && ($_GET['verify']) == "empty"){
                    echo "<h1> Email or password cannot be empty! Please try again. </h1>";
                  }

                  if(isset($_GET['reg']) && ($_GET['reg']) == "success"){
                    echo "<h1> Registration success. You can log in now. </h1>";
                  }
                ?>
            </div>

            <div>
                <form method="post" action="login.php">
                  <!-- Email input -->
                  <div class="form-group">
                    <label for="loginEmail">Email Address</label>
                    <input name="loginEmail" type="email" class="form-control" id="loginEmail" placeholder="Email" required>
                    <!-- <p id="loginEmailStatus"></p> -->
                  </div>
                      
                  <!-- Password input -->
                  <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input name="loginPassword" type="password" class="form-control" id="loginPassword" placeholder="Password" required>
                    <!-- <p id="loginPasswordStatus"></p> -->
                  </div>
                  
                  <!-- Submit button -->
                  <div>
                  <button name="submit" type="submit" value="submit">Submit</button>
                  </div>
                  <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                </form>
            </div>
            </div>
          </center>
        </div>
    </div>
</div>
</div>
</section>
        
           
                
</body>

</html>
<script src="../js/login_validation.js"></script>
