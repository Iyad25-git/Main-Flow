<?php
session_start();
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "Entered Password: " . $password . "<br>";
        echo "Stored Hash: " . $user['password'] . "<br>";

        if (password_verify($password, $user['password'])) {
            echo "✅ Password Matched! Redirecting...";
            $_SESSION['user_id'] = $user['id'];
            header("Refresh:3; url=dashboard.php"); // Redirect after 3 seconds
            exit();
        } else {
            echo "❌ Password Incorrect!";
        }
    } else {
        echo "❌ User Not Found!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>
            
            <label>Password</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <p>Not yet a member? <a href="register.php">Sign up</a></p>
    </div>
</body>
</html>
