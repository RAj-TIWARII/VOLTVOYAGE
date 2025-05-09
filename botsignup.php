<?php

$host = "localhost";
$dbUsername = "voltvoya_userindex";
$dbPassword = "tqqfuEsqe8rLHgsSZGF3";
$dbName = "voltvoya_userindex";


$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];
$photo = $_FILES['photo'];

// Validate input fields
if (empty($username) || empty($password) || empty($photo)) {
    die("Please fill in all fields.");
}

// Save uploaded image to the 'uploads' folder
$photoName = uniqid() . "_" . basename($photo["name"]);
$targetDir = "uploads/";
$targetFile = $targetDir . $photoName;

// Create 'uploads' folder if it doesn't exist
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if (move_uploaded_file($photo["tmp_name"], $targetFile)) {
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $sql = "INSERT INTO signupbot (username, password, photo) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $username, $hashedPassword, $photoName);

        if ($stmt->execute()) {
            echo "Signup successful! 🎉";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "SQL error: " . $conn->error;
    }
} else {
    echo "Failed to upload image.";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup Form</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #121212;
      color: #f5f5f5;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-box {
      background: #1f1f1f;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 400px;
    }

    .form-control {
      background-color: #2a2a2a;
      border: none;
      color: #fff;
    }

    .form-control::placeholder {
      color: #aaa;
    }

    .btn-primary {
      background-color: #4a90e2;
      border: none;
    }

    .btn-primary:hover {
      background-color: #357ab8;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2 class="text-center mb-4">Sign Up</h2>

  <form id="simpleForm" action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <input type="text" id="username" class="form-control" name="username" placeholder="Username" required>
    </div>

    <div class="mb-3">
      <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
    </div>

    <div class="mb-3">
      <input type="file" id="photo" class="form-control" name="photo" accept="botimage/*" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Submit</button>
  </form>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
