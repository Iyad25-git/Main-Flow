<?php
// dashboard.php - User Dashboard
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'database.php';

$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <p>You are logged in.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
