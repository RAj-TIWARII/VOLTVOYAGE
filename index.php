<?php
session_start(); // Start session for user login tracking

$localhost = 'localhost';
$root = 'voltvoya_userindex';
$password = 'tqqfuEsqe8rLHgsSZGF3';
$db = 'voltvoya_userindex';

// Database Connection
$con = mysqli_connect($localhost, $root, $password, $db);
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

$message = ""; // Error message placeholder
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim(mysqli_real_escape_string($con, $_POST['email']));
    $password = trim($_POST['password']);

    // Check if email exists
    $query = "SELECT * FROM userdbindex WHERE email = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Verify password (plain text check; replace with password_verify() if storing hashed passwords)
        if ($password === $user['password']) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; // This stores the username in the session

$to = $email;
$subject = "Welcome to VOLTVOYAGE!";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: VOLTVOYAGE <no-reply@voltvoyage.com>" . "\r\n";

$body = '
<html>
<head>
  <style>
    .email-container {
      font-family: Arial, sans-serif;
      background-color: #0b0c10;
      color: #ffffff;
      padding: 30px;
      text-align: center;
    }
    .header {
      font-size: 22px;
      color: #99CCFF;
      margin-bottom: 10px;
    }
    .banner {
      width: 100%;
      max-width: 600px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .message {
      font-size: 16px;
      margin-bottom: 30px;
      color: #c5c6c7;
    }
    .social-icons a {
      margin: 0 10px;
      display: inline-block;
    }
    .social-icons img {
      width: 40px;
      height: 40px;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">Welcome to <hr> <br> <span style="color: skyblue; font-size: 20px;"> VOLTVOYAGE, </span>' . htmlspecialchars($user['username']) . '!</div>
    <img class="banner" src="https://media.discordapp.net/attachments/1180153996183355422/1360546454258847965/voyagemail.png?ex=67fb8320&is=67fa31a0&hm=5b832448ca4e75869854b1777fa53e64148eecd532482d0ea965a8f1133e1dfb&=&format=webp&quality=lossless&width=1317&height=659" width="140%" alt="Welcome Banner">
    <div class="message">
      Hey ' . htmlspecialchars($user['username']) . ',<br><br>
      We\'re over the moon to have you on board!<br>
      Keep exploring the cosmos and never stop looking up 🚀<br><br>
      – The VOLTVOYAGE Team
    </div>
    <div class="social-icons">
      <a href="https://discord.gg/mkcN8R5UYQ" target="_blank">
        <img src="https://img.icons8.com/ios-filled/50/66fcf1/discord-logo.png" alt="Discord">
      </a>
      <a href="https://x.com/voltvoyage_in" target="_blank">
        <img src="https://img.icons8.com/ios-filled/50/66fcf1/twitterx.png" alt="X (Twitter)">
      </a>
      <a href="https://www.instagram.com/voltvoyage.in" target="_blank">
        <img src="https://img.icons8.com/ios-filled/50/66fcf1/instagram-new.png" alt="Instagram">
      </a>
    </div>
  </div>
</body>
</html>
';

mail($to, $subject, $body, $headers);

            header("Location: main.php"); // Redirect to main page on success
            exit();
        } else {
            $message = "Error: Incorrect password!";
        }
    } else {
        $message = "Error: Email not found!";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VOLTVOYAGE</title>
    <link rel="icon" type="image/png" href="Images/VOYAGELOGO.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .site-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
        }

        .text-shyblue {
            background: linear-gradient(to right, #4e9af1, #6fb3f7);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        body {
            background: #dbeeff;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-box img {
            height: 100px;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 20px;
            border: 1px solid #4e9af1;
            padding: 10px;
        }

        .btn-primary {
            background: #4e9af1;
            border: none;
            padding: 10px;
            border-radius: 20px;
        }

        .btn-primary:hover {
            background: #3a89d1;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #4e9af1;
        }

        .message {
            color: red;
            margin-top: 10px;
        }

        /* Explore Us Button */
        .explore-btn {
            display: none;
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 114, 255, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        .explore-btn:hover {
            background: linear-gradient(90deg, #005bb5, #0098cc);
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="voltvoyageicon.png" alt="Logo" height="40" class="me-2">
                <span class="site-title text-shyblue">VOLTVOYAGE</span>
            </a>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <img src="Images/VOYAGELOGO.png" alt="VOLTVOYAGE Logo">
            <h2 class="site-title text-shyblue">VOLTVOYAGE</h2>

            <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>

            <form method="POST" id="loginForm">
                <div class="mb-3">
                    <input type="email" id="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3 password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Log In</button>
            </form>

            <!-- Signup Link -->
            <p class="mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p> 
        </div>
        <div style="margin-top: 15px;">
    <a href="forgot_password.php" style="color: #4e9af1;">Forgot Password?</a>
</div>

    </div>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            } else {
                passwordField.type = "password";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            }
        });

        <?php if ($success) { ?>
            document.getElementById("signupBox").style.display = "none";
            document.getElementById("exploreBtn").style.display = "block";
        <?php } ?>
    </script>
</body>
</html>
