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
    <?php include('/layouts/layout.php');
    ?>  
      
    <div class="container">
        <section class="vh-100">
            <div class="container py-5 h-100">
              <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
        <div class="about-us">
            
                <img src="../images/b2b-logo-horizontal-concept-transparent.png" width="300" height="150">
           
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form>


                     <!-- Courtesy Title input -->
                  <div class="form-outline mb-4">
                    <input type="courtesy-title" id="form1Example23" class="form-control form-control-lg"style=" margin-left: auto; margin-right: auto; margin-top: 5px" />
                    <label class="form-label" for="form1Example23">Courtesy Title</label>
                  </div>

                    <!-- First Name Input -->
                  
                    <div class="form-outline mb-4">
                        <input type="first-name" id="form1Example13" class="form-control form-control-lg"style=" margin-left: auto; margin-right: auto; margin-top: 5px" />
                        
                        <label class="form-label" for="form1Example13">First Name</label>
                      </div>
                      
                      <!-- Last Name Input -->
                      <div class="form-outline mb-4">
                        <input type="last-name" id="form1Example23" class="form-control form-control-lg" style=" margin-left: auto; margin-right: auto; margin-top: 5px" />
                        <label class="form-label" for="form1Example23">Last Name</label>
                      </div>

                  <!-- Email input -->
                  
                  <div class="form-outline mb-4">
                    <input type="email" id="form1Example13" class="form-control form-control-lg"style=" margin-left: auto; margin-right: auto; margin-top: 5px" />
                    
                    <label class="form-label" for="form1Example13">Email Address</label>
                  </div>
                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" id="form1Example23" class="form-control form-control-lg"style=" margin-left: auto; margin-right: auto; margin-top: 5px" />
                    <label class="form-label" for="form1Example23">Password</label>
                  </div>
                  
        
      
                  <!-- Submit button -->
                  <div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block"style=" margin-left: auto; margin-right: auto; margin-top: 5px">Register</button>
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