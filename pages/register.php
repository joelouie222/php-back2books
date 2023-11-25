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
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon-16x16.png">
</head>

<body id="home">
    <?php
        include('../layouts/layout.php');
        include('../config.php');
        include('../functions.php');
    ?>  
    <div class="container">
        <div class="about-us">
        <center>
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
                    $_SESSION['fname'] = str_replace(" ", "", $_POST["fname"]);
                  }

                  if(empty(trim($_POST["lname"]))){
                    $lnameError = "&lname=empty";
                  } else {
                    $_SESSION['lname'] = str_replace(" ", "", $_POST["lname"]);
                  }

                  if(empty(trim($_POST["registerEmail"]))){
                    $emailErr = "&email=empty";
                  } else {
                    $_SESSION['registerEmail'] = str_replace(" ", "", $_POST["registerEmail"]);
                  }

                  if(empty(trim($_POST["registerPassword"]))){
                    $passwordErr = "&pass=empty";
                  } else {
                    $pass = str_replace(" ", "", $_POST["registerPassword"]);
                  }

                  if(empty(trim($_POST["registerPassword2"]))){
                    $password2Err = "&pass2=empty";
                  } else {
                    $pass2 = str_replace(" ", "", $_POST["registerPassword2"]);
                  }

                  if(empty(trim($_POST["securityQuestion"]))){
                    $questionError = "&question=empty";
                  } else {
                    $_SESSION['securityQuestion'] = (trim($_POST["securityQuestion"]));
                  }

                  if(empty(trim($_POST["securityAnswer"]))){
                    $answerErr = "&answer=empty";
                  } else {
                    $_SESSION['securityAnswer'] = str_replace(" ", "", $_POST["securityAnswer"]);
                  }

                  if(empty($fnameError) && empty($lnameError) && empty($emailErr) && empty($passwordErr) && empty($password2Err) && empty($questionError) && empty($password2Err)){
                    echo '<h1>fname: '.$_SESSION['fname'].' </h1>';
                    echo '<h1>lname: '.$_SESSION['lname'].' </h1>';
                    echo '<h1>email: '.$_SESSION['registerEmail'].' </h1>';
                    echo '<h1>p1: '.$pass.' </h1>';
                    echo '<h1>p2: '.$pass2.' </h1>';
                    echo '<h1>post-qa: '.$_POST['securityQuestion'].' </h1>';
                    echo '<h1>session-qa: '.$_SESSION['securityQuestion'].' </h1>';
                    echo '<h1>post-sa: '.$_POST['securityAnswer'].' </h1>';
                    echo '<h1>session-sa: '.$_SESSION['securityAnswer'].' </h1>';

                    if ($pass != $pass2) {
                      redirect("https://php-back2books.azurewebsites.net/pages/register.php?pass2=mismatch")
                    } else {
                      $hashedPassword = md5($pass);
                    }

                    echo '<h1>hashPassword = '.$hashedPassword.'</h1>';

                    // $tsql = "INSERT INTO B2BUSER (USER_EMAIL, USER_PASSWORD, USER_FNAME, USER_LNAME, USER_SQ, USER_SA)
                    //         VALUES
                    //         ($_SESSION['registerEmail'], $hashedPassword, $_SESSION['fname'], $_SESSION['lname'], USER_SQ, USER_SA);
                    
                    
                    // $addUser = sqlsrv_query($conn, $tsql);





                  }
                  else {
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=true$fnameError$lnameError$emailErr$passwordErr$password2Err$questionError$answerErr");
                  }
              

                 
                }
              ?>
            </div>



            <div>
                <form method="post" action="">
                      <!-- First Name input -->
                      <?php
                        if (isset($_SESSION['fname'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="fname">First Name</label>';
                          echo '    <input required name="fname" type="test" class="form-control" id="fname" value="'.$_SESSION['fname'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="fname">First Name</label>';
                          echo '    <input required name="fname" type="test" class="form-control" id="fname" placeholder="First Name">';
                          
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
                          echo '    <input required name="lname" type="test" class="form-control" id="lname" value="'.$_SESSION['lname'].'">';
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
                                echo '  <p id="registerPassword2Status">Password does not match</p>';
                              }
                            } else {
                              echo '  <p id="registerPassword2Status"></p>';
                            }
                        ?>
                      </div>

                      <!-- Security Question -->

                        <div class="form-group">
                        <label for="securityQuestion">Choose a security question:</label>
                        <select id="securityQuestion" required>
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
            </div>
        </center>
      </div>
    </div>       
</body>

</html>