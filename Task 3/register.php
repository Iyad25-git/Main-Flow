<?php
// register.php - User Registration
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    // Insert user into database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    try {
        $stmt->execute([$username, $email, $hashed_password]);
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Registration failed. Try a different username or email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($_SESSION['error'])) { echo "<p class='error'>" . $_SESSION['error'] . "</p>"; unset($_SESSION['error']); } ?>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <button type="submit">Register</button>
        </form>
        <p>Already a member? <a href="login.php">Sign in</a></p>
    </div>
</body>
</html>
