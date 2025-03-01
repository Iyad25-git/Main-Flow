<?php
// process_register.php - Handle User Registration
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

    // Store user in database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$username, $email, $password]);
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Registration failed. Try a different username or email.";
        header("Location: register.php");
        exit();
    }
}
?>
