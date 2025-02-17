<?php
$localhost = "localhost";
$root = "therajtiwari.1@gmail.com";
$password = "voltvoyageDB@8840";
$db = "voltvoya1_voyage01";
$con = mysqli_connect($localhost, $root, $password, $db);
if (isset($_POST['Submit']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $loginsert = mysqli_query ($con, "INSERT INTO dataTable(email, password) VALUES ('$email', '$password')");

    if($loginsert)
    {
        echo "<b> YOUR FORM HAS BEEN SUCCESSFULLY SUBMITTED!!!! </b>";
    }
    else
    {
        echo " SORRY! FORM NOT SUBMITTED...." .mysqli_error($con);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In - VOLTVOYAGE</title>
  <link 
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet">
  <script 
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
  </script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to bottom, #0f2027, #203a43, #2c5364); 
      min-height: 100vh;
    }
    .custom-shadow {
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center">

  <!-- PHP FILE DATABASE -->

  <div class="container p-3">
    <!-- Main Row -->
    <div class="row shadow-lg rounded-4 bg-white overflow-hidden custom-shadow">
      <!-- Left Image Section -->
      <div class="col-md-6 d-none d-md-block p-0">
        <img src="StarshipLoginimg.jpeg" alt="Starship" class="img-fluid h-100 w-100" style="object-fit: cover;">
      </div>

      <!-- Right Login Section -->
      <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-5 text-center bg-dark text-white">
        <div class="w-100">
          <!-- Logo & Title -->
          <h2 class="text-info mb-4">
            <i class="ri-space-ship-fill"></i> VOLTVOYAGE Login
          </h2>
          <p class="text-secondary">Embark on your next cosmic journey</p>
          
          <!-- Login Form -->
          <form action="" method="POST" class="w-100" style="max-width: 400px;">
            <!-- Username -->
            <div class="mb-3 text-start">
              <label for="Email" class="form-label text-info">Username or Email</label>
              <input type="email" name="email" id="username" class="form-control" placeholder="Enter your username or email" required>
            </div>
            
            <!-- Password -->
            <div class="mb-3 text-start">
              <label for="password" class="form-label text-info">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <!-- Login Button -->
            <input type="submit" name="Submit" class="btn btn-info w-100 fw-bold rounded-3 mb-3" value="Log In">

            <!-- Divider -->
            <div class="d-flex align-items-center mb-3 text-secondary">
              <hr class="flex-grow-1 border-secondary">
              <span class="mx-3">OR</span>
              <hr class="flex-grow-1 border-secondary">
            </div>
            
            <!-- Signup Option -->
            <p class="mb-0 text-light">
              Don't have an account? 
              <a href="#" class="text-info fw-bold">Sign up</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
