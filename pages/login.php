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
        <?php include('../layouts/layout.php');
        ?>  
        
        <div class="about-us">
          <center>
                <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
            <div>
                <form>
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