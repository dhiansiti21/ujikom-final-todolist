<?php
session_start();
require 'functions.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Gunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Simpan session untuk login
            $_SESSION["login"] = true;
            $_SESSION["username"] = $row["username"];
            $_SESSION["user_id"] = $row["id"]; // Simpan user_id untuk filter tasks

            // Redirect to home page with success notification using JavaScript
            echo "<script>
                    alert('Login Successful!');
                    window.location.href = 'index.php';
                  </script>";
            exit;
        }
    }
    // Display an error notification if login fails
    echo "<script>
            alert('Username atau Password salah!');
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <h1>Login</h1>

        <form action="login.php" method="POST">
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fa fa-lock"></i>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>
