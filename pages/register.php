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
    <?php include('../layouts/layout.php');
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
                    $fnameError = "emptyFname";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$fnameError");
                  } else {
                    $_SESSION['fname'] = str_replace(" ", "", $_POST["fname"]);
                  }

                  if(empty(trim($_POST["lname"]))){
                    $lnameError = "emptyLname";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$lnameError");
                  } else {
                    $_SESSION['lname'] = str_replace(" ", "", $_POST["lname"]);
                  }

                  if(empty(trim($_POST["registerEmail"]))){
                    $emailErr = "emptyEmail";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$emailErr");
                  } else {
                    $_SESSION['registerEmail'] = str_replace(" ", "", $_POST["registerEmail"]);
                  }

                  if(empty(trim($_POST["registerPassword"]))){
                    $passwordErr = "emptyPassword";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$passwordErr");
                  } else {
                    $_SESSION['registerPassword'] = str_replace(" ", "", $_POST["registerPassword"]);
                  }

                  if(empty(trim($_POST["registerPassword2"]))){
                    $password2Err = "emptyPasword2";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$password2Err");
                  } else {
                    $_SESSION['registerPassword2'] = str_replace(" ", "", $_POST["registerPassword2"]);
                  }

                  if(empty(trim($_POST["securityQuestion"]))){
                    $questionError = "emptyQuestion";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$questionError");
                  } else {
                    $_SESSION['securityQuestion'] = str_replace(" ", "", $_POST["securityQuestion"]);
                  }

                  if(empty(trim($_POST["securityAnswer"]))){
                    $answerErr = "emptyAnswer";
                    redirect("https://php-back2books.azurewebsites.net/pages/register.php?err=$answerErr");
                  } else {
                    $_SESSION['securityAnswer'] = str_replace(" ", "", $_POST["securityAnswer"]);
                  }


                  echo '<h1>fname: '.$_SESSION['fname'].' </h1>';
                  echo '<h1>fname: '.$_SESSION['lname'].' </h1>';
                  echo '<h1>fname: '.$_SESSION['registerEmail'].' </h1>';
                  echo '<h1>fname: '.$_SESSION['registerPassword'].' </h1>';
                  echo '<h1>fname: '.$_SESSION['registerPassword2'].' </h1>';
                  echo '<h1>fname: '.$_SESSION['securityQuestion'].' </h1>';
                  echo '<h1>fname: '.$_SESSION['securityAnswer'].' </h1>';
                }


              ?>
            </div>



            <div>
                <form>
                      <!-- First Name input -->
                      <?php
                        if (isset($_SESSION['fname'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="fname">First Name</label>';
                          echo '    <input name="fname" type="test" class="form-control" id="fname" placeholder="'.$_SESSION['fname'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="fname">First Name</label>';
                          echo '    <input name="fname" type="test" class="form-control" id="fname" placeholder="First Name">';
                          
                          if(isset($_GET['err']) && ($_GET['err']) == "emptyFname"){
                            echo '  <p id="fnameStatus">First name cannot be empty.</p>';
                          } else {
                            echo '  <p id="fnameStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Last Name input -->
                      <?php
                        if (isset($_SESSION['fname'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="lname">Last Name</label>';
                          echo '    <input name="lname" type="test" class="form-control" id="lname" placeholder="'.$_SESSION['lname'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="lname">Last Name</label>';
                          echo '    <input name="lname" type="text" class="form-control" id="lname" placeholder="Last Name">';
                          
                          if(isset($_GET['err']) && ($_GET['err']) == "emptyLname"){
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
                          echo '    <input name="registerEmail" type="test" class="form-control" id="registerEmail" placeholder="'.$_SESSION['registerEmail'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerEmail">Email Address</label>';
                          echo '    <input name="registerEmail" type="email" class="form-control" id="registerEmail" placeholder="Email">';

                          if(isset($_GET['err']) && ($_GET['err']) == "emptyEmail"){
                            echo '  <p id="registerEmailStatus">Email cannot be empty.</p>';
                          } else {
                            echo '  <p id="registerEmailStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Password input -->                   
                      <?php
                        if (isset($_SESSION['registerPassword'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerPassword">Password</label>';
                          echo '    <input name="registerPassword" type="password" class="form-control" id="registerPassword" placeholder="'.$_SESSION['registerPassword'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerPassword">Password</label>';
                          echo '    <input name="registerPassword" type="password" class="form-control" id="registerPassword" placeholder="Password">';

                          if(isset($_GET['err']) && ($_GET['err']) == "emptyPassword"){
                            echo '  <p id="registerPasswordStatus">Password cannot be empty.</p>';
                          } else {
                            echo '  <p id="registerPasswordStatus"></p>';
                          }
                          echo '</div>';
                        }
                      ?>
                      
                      <!-- Confirm Password input -->
                      <div class="form-group">
                        <label for="registerPassword2">Confirm Password</label>
                        <input name="registerPassword2" type="password" class="form-control" id="registerPassword2" placeholder="Confirm Password">
                        <p id="registerPasswordStatus2"></p>
                      </div>
                      <?php
                        if (isset($_SESSION['registerPassword2'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerPassword2">Password</label>';
                          echo '    <input name="registerPassword2" type="password" class="form-control" id="registerPassword2" placeholder="'.$_SESSION['registerPassword2'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="registerPassword2">Password</label>';
                          echo '    <input name="registerPassword2" type="password" class="form-control" id="registerPassword2" placeholder="Confirm Password">';

                          if(isset($_GET['err']) && ($_GET['err']) == "emptyPasword2"){
                            echo '  <p id="registerPassword2Status">Password cannot be empty.</p>';
                          } else {
                            echo '  <p id="registerPassword2Status"></p>';
                          }
                          echo '</div>';
                        }
                      ?>

                      <!-- Security Question -->
                      <div class="form-group">
                      <label for="securityQuestion">Choose a security question:</label>
                      <select id="securityQuestion">
                        <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                        <option value="What is your favorite sport?">What is your favorite sport?</option>
                        <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                        <option value="What city were you born in?">What city were you born in?</option>
                        <option value="What is your favorite color?">What is your favorite color?</option>
                        <option value="What was the make and model of your first car?">What was the make and model of your first car?</option>
                      </select>
                      </div>
                      
                      <!-- Security Answer -->
                      <?php
                        if (isset($_SESSION['securityAnswer'])) {
                          echo '  <div class="form-group">';
                          echo '    <label for="securityAnswer">Security question answer</label>';
                          echo '    <input name="securityAnswer" type="text" class="form-control" id="securityAnswer" placeholder="'.$_SESSION['securityAnswer'].'">';
                          echo '  </div>';
                        } else {
                          echo '  <div class="form-group">';
                          echo '    <label for="securityAnswer">Security question answer</label>';
                          echo '    <input name="securityAnswer" type="text" class="form-control" id="securityAnswer" placeholder="This is will used to recover your password.">';

                          if(isset($_GET['err']) && ($_GET['err']) == "emptyPasword2"){
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