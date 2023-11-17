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
    <div class="container">
        <?php include('./layouts/layout.php');
        ?>  
        <section class="vh-100">
            <div class="container py-5 h-100">
              <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
        <div class="about-us">
            
                <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
           
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form>

                  <!-- Email input -->
                  
                  <div class="form-group">
                    <label for="loginEmail">Email Address</label>
                    <input name="loginEmail" type="email" class="form-control" id="email" placeholder="Email">
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
        </div>
    </div>
</div>
</div>
</section>
        
           
                
</body>

</html>