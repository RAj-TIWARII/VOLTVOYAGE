<?php
$localhost = 'localhost';
$root = '';
$password = '';
$db = '';

// Database Connection
$con = mysqli_connect($localhost, $root, $password, $db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$success = false;

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Server-side Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Error: Invalid email format!";
    } else {
        // Check if username or email already exists
        $check_query = "SELECT * FROM userdbindex WHERE username=? OR email=? LIMIT 1";
        $stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $message = "Error: Username or Email already exists!";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $query = "INSERT INTO userdbindex (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $success = true; // Mark success for frontend
                $message = "Account Created Successfully!";
            } else {
                $message = "Error: " . mysqli_error($con);
            }
        }
    }
}

mysqli_close($con);
?>
