<?php
session_start();
require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>alert('User baru berhasil ditambahkan');</script>";

        $_SESSION["login"] = true;
        $_SESSION["username"] = $_POST["username"];

        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <!-- Add Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <h1>Register</h1>
        <form action="register.php" method="POST">
            <!-- Username Input Box with Icon -->
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class="fa fa-user"></i> <!-- User icon -->
            </div>
            <!-- Password Input Box with Icon -->
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fa fa-key"></i> <!-- Key icon for password -->
            </div>
            <!-- Email Input Box with Icon -->
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="fa fa-envelope"></i> <!-- Email icon -->
            </div>
            <!-- Remember me and Forgot Password links -->
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>
            <!-- Register Button -->
            <button type="submit" name="register" class="btn">Register</button>
        </form>
        <div class="register-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
