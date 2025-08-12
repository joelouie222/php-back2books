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

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- OUR CSS -->    
    <link rel="stylesheet" href="/style.css">
    <!-- <link rel="stylesheet" href="/logo-style.css"> -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php
        include('../layout.php');
        include('../functions.php');
    ?>  
    <div class="container">
        <div class="about-us">
        <center>
        <div class="login-container">
            <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">

            <div>
              <?php
                if(isset($_POST['submit']) && $_POST['submit']=="submit"){ 
                  
                  $fname= "";
                  $fnameError= "";

                  $lname= "";
                  $lnameError = "";
                  
                  $userEmail = "";
                  $emailErr = "";

                  $userPassword = "";
                  $passwordErr = "";

                  $userPassword2 = "";
                  $password2Err = "";
                  
                  $secretQuestion = "";
                  $questionError = "";

                  $secretAnswer = "";
                  $answerError = "";

                  if(empty(trim($_POST["fname"]))){
                    $fnameError = "&fname=empty";
                  } else {
                    // delete spaces
                    $_SESSION['fname'] = str_replace(" ", "", $_POST['fname']);
                    // delete invalid sql characters
                    $_SESSION['fname'] = preg_replace('/[\'\";#]/', '', $_SESSION['fname']);
                  }

                  if(empty(trim($_POST["lname"]))){
                    $lnameError = "&lname=empty";
                  } else {
                    // delete spaces
                    $_SESSION['lname'] = str_replace(" ", "", $_POST["lname"]);
                    // delete invalid sql characters
                    $_SESSION['lname'] = preg_replace('/[\'\";#]/', '', $_SESSION['lname']);
                  }

                  if(empty(trim($_POST["registerEmail"]))){
                    $emailErr = "&email=empty";
                  } else {
                    // delete spaces
                    $_SESSION['registerEmail'] = str_replace(" ", "", $_POST["registerEmail"]);
                    // delete invalid sql characters
                    $_SESSION['registerEmail'] = preg_replace('/[\'\";#]/', '', $_SESSION['registerEmail']);
                  }

                  if(empty(trim($_POST["registerPassword"]))){
                    $passwordErr = "&pass=empty";
                  } else {
                    // delete spaces
                    $userPassword = str_replace(" ", "", $_POST["registerPassword"]);
                  }

                  if(empty(trim($_POST["registerPassword2"]))){
                    $password2Err = "&pass2=empty";
                  } else {
                    // delete spaces
                    $userPassword2 = str_replace(" ", "", $_POST["registerPassword2"]);
                  }

                  if(empty(trim($_POST["securityQuestion"]))){
                    $questionError = "&question=empty";
                  } else {
                    // delete spaces
                    $secretQuestion = (trim($_POST["securityQuestion"]));
                    // delete invalid sql characters
                    $secretQuestion = preg_replace('/[\'\";#]/', '', $secretQuestion);
                  }

                  if(empty(trim($_POST["securityAnswer"]))){
                    $answerErr = "&answer=empty";
                  } else {
                    // delete spaces
                    $_SESSION['securityAnswer'] = str_replace(" ", "", $_POST["securityAnswer"]);
                    // delete invalid sql characters
                    $_SESSION['securityAnswer'] = preg_replace('/[\'\";#]/', '', $_SESSION['securityAnswer']);
                  }

                  if(empty($fnameError) && empty($lnameError) && empty($emailErr) && empty($passwordErr) && empty($password2Err) && empty($questionError) && empty($password2Err)){

                    if ($userPassword != $userPassword2) {
                      redirect($HOME."pages/register.php?pass2=mismatch");
                    } else {
                      $hashedPassword = md5($userPassword);
                    }

                    $fname = $_SESSION['fname'];                  
                    $lname = $_SESSION['lname'];                  
                    $userEmail = $_SESSION['registerEmail'];        
                    $secretAnswer = $_SESSION['securityAnswer'];
                    $currentDate = date('Y-m-d');

                    // check if email already exists
                    $tsql = "SELECT user_email FROM b2buser WHERE user_email = ?";
                    $checkEmail = sqlsrv_query($conn, $tsql, array($userEmail));
                    if (sqlsrv_fetch($checkEmail)) {
                      sqlsrv_free_stmt($checkEmail);
                      redirect($HOME."pages/register.php?email=exists");
                    }

                    $tsql = "INSERT INTO b2buser (user_email, user_password, user_fname, user_lname, user_sq, user_sa) 
                    VALUES (?, ?, ?, ?, ?, ?); 
                    INSERT INTO cart (user_id, cart_create_date) VALUES ((SELECT user_id FROM b2buser WHERE user_email LIKE ? AND user_password LIKE ?), ?);";

                    $addUser = sqlsrv_query($conn, $tsql, array($userEmail, $hashedPassword, $fname, $lname, $secretQuestion, $secretAnswer, $userEmail, $hashedPassword, $currentDate));

                    if($addUser === false) {
                      sqlsrv_free_stmt($addUser);
                      redirect($HOME."pages/register.php?reg=failed");
                    } else {
                      sqlsrv_free_stmt($addUser);
                      redirect($HOME."pages/login.php?reg=success");
                    }
                  }
                  else {
                    redirect($HOME."pages/register.php?err=true$fnameError$lnameError$emailErr$passwordErr$password2Err$questionError$answerErr");
                  }
                }
              ?>
            </div>



            <div>
                <form method="post" action="">
                      <div style="margin: 1rem 0;"><h2>Register</h2></div>

                      <! -- Email already exists -->
                      <?php
                        if (isset($_GET['email']) && $_GET['email'] == "exists") {
                          echo '<div style="margin-bottom: 1rem;"><p style="color: red;">Email already exists. Please try another email.</p></div>';
                        } else if (isset($_GET['reg']) && $_GET['reg'] == "failed") {
                          echo '<div style="margin-bottom: 1rem;"><p style="color: red;">Registration failed. Please try again.</p></div>';
                        } else if (isset($_GET['reg']) && $_GET['reg'] == "success") {
                          echo '<div style="margin-bottom: 1rem;"><p style="color: green;">Registration successful! Please log in.</p></div>';
                        }
                      ?>

                      <!-- FUTURE: Add a link to recover password -->
                      <!-- <h4>Or, <a href="/pages/forgotPassword.php">recover your password</a></h4> -->

                      <div style="margin-bottom: 1rem;"><p>Please fill in this form to create an account.</p></div>


                      <!-- First Name input -->
                      <?php
                        if (isset($_SESSION['fname'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="fname">First Name</label>';
                          echo '    <input required name="fname" type="text" class="form-control" id="fname" value="'.$_SESSION['fname'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="fname">First Name</label>';
                          echo '    <input required name="fname" type="text" class="form-control" id="fname" placeholder="First Name">';
                          
                          if(isset($_GET['fname']) && ($_GET['fname']) == "empty"){
                            echo '  <p id="fnameStatus">First name cannot be empty.</p>';
                          } else {
                            echo '  <p id="fnameStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Last Name input -->
                      <?php
                        if (isset($_SESSION['lname'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="lname">Last Name</label>';
                          echo '    <input required name="lname" type="text" class="form-control" id="lname" value="'.$_SESSION['lname'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="lname">Last Name</label>';
                          echo '    <input required name="lname" type="text" class="form-control" id="lname" placeholder="Last Name">';
                          
                          if(isset($_GET['lname']) && ($_GET['lname']) == "empty"){
                            echo '  <p id="lnameStatus">Last name cannot be empty.</p>';
                          } else {
                            echo '  <p id="lnameStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Email input -->                      
                      <?php
                        if (isset($_SESSION['registerEmail'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerEmail">Email Address</label>';
                          echo '    <input required name="registerEmail" type="email" class="form-control" id="registerEmail" value="'.$_SESSION['registerEmail'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerEmail">Email Address</label>';
                          echo '    <input required name="registerEmail" type="email" class="form-control" id="registerEmail" placeholder="Email">';

                          if(isset($_GET['email']) && ($_GET['email']) == "empty"){
                            echo '  <p id="registerEmailStatus">Email cannot be empty.</p>';
                          } else {
                            echo '  <p id="registerEmailStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Password input -->                   
                      <div class="form-group">
                          <label for="registerPassword">Password</label>
                          <input required name="registerPassword" type="password" class="form-control" id="registerPassword" placeholder="Password">
                        <?php
                          if(isset($_GET['pass']) && ($_GET['pass']) == "empty"){
                            echo '  <p id="registerPasswordStatus">Password cannot be empty</p>';
                            } else {
                            echo '  <p id="registerPasswordStatus"></p>';
                            }
                            if (isset($_GET['pass2']) && $_GET['pass2'] == "mismatch") {
                              echo '  <p style="color: red;" id="registerPassword2Status">Password must match</p>';
                            }
                        ?>
                      </div>
                      
                      <!-- Confirm Password input -->
                      <div class="form-group">
                        <label for="registerPassword2">Confirm Password</label>
                        <input required name="registerPassword2" type="password" class="form-control" id="registerPassword2" placeholder="Confirm Password">
                        <?php
                            if(isset($_GET['pass2'])){
                              if ($_GET['pass2'] == "empty") {
                                echo '  <p id="registerPassword2Status">Password cannot be empty</p>';
                              }
                              if ($_GET['pass2'] == "mismatch") {
                                echo '  <p style="color: red;" id="registerPassword2Status">Password must match</p>';
                              }
                            } else {
                              echo '  <p id="registerPassword2Status"></p>';
                            }
                        ?>
                      </div>

                      <!-- Security Question -->

                        <div class="form-group">
                        <label for="securityQuestion">Choose a security question:</label>
                        <select name="securityQuestion" id="securityQuestion" required>
                          <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                          <option value="What is your favorite sport?">What is your favorite sport?</option>
                          <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                          <option value="What city were you born in?">What city were you born in?</option>
                          <option value="What is your favorite color?">What is your favorite color?</option>
                          <option value="What was the make and model of your first car?">What was the make and model of your first car?</option>
                        </select>
                          <?php
                            if(isset($_GET['sa']) && ($_GET['sa']) == "empty"){
                              echo '  <p id="questionStatus">Security questions cannot be empty.</p>';
                            } else {
                              echo '  <p id="answerStatus"></p>';
                            }
                          ?>
                        </div>
                      
                      <!-- Security Answer -->
                      <?php
                        if (isset($_SESSION['securityAnswer'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="securityAnswer">Security question answer</label>';
                          echo '    <input required name="securityAnswer" type="text" class="form-control" id="securityAnswer" value="'.$_SESSION['securityAnswer'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="securityAnswer">Security question answer</label>';
                          echo '    <input required name="securityAnswer" type="text" class="form-control" id="securityAnswer" placeholder="This is will used to recover your password.">';

                          if(isset($_GET['sa']) && ($_GET['sa']) == "empty"){
                            echo '  <p id="answerStatus">Answer cannot be empty.</p>';
                          } else {
                            echo '  <p id="answerStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Submit button -->
                      <div>
                      <button name="submit" type="submit" value="submit">Submit</button>
                      </div>
                </form>

                <div style="margin: 2rem 0;"><p>Already have an account? <a href="/pages/login.php">Sign In</a></p></div>
            </div>
            </div>
        </center>
      </div>
    </div>       
</body>

</html>
