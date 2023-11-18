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
                <form>
                      <!-- Email input -->
                      <div class="form-group">
                        <label for="registerEmail">Email Address</label>
                        <input name="registerEmail" type="email" class="form-control" id="registerEmail" placeholder="Email">
                        <p id="registerEmailStatus"></p>
                      </div>
                      
                      <!-- Confirm Email input -->
                      <div class="form-group">
                        <label for="registerEmail2">Confirm Email Address</label>
                        <input name="registerEmail2" type="email" class="form-control" id="registerEmail2" placeholder="Confirm Email">
                        <p id="registerEmailStatus2"></p>
                      </div>

                      <!-- Password input -->
                      <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <input name="registerPassword" type="password" class="form-control" id="registerPassword" placeholder="Password">
                        <p id="registerPasswordStatus"></p>
                      </div>
                      
                      <!-- Confirm Password input -->
                      <div class="form-group">
                        <label for="registerPassword2">Password</label>
                        <input name="registerPassword2" type="password" class="form-control" id="registerPassword2" placeholder="Confirm Password">
                        <p id="registerPasswordStatus2"></p>
                      </div>

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