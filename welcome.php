<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <div class="container">
        <p class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>