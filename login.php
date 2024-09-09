<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to check user credentials
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Start session and set session variables
                session_start();
                $_SESSION['username'] = $username;
                header("Location: welcome.php"); // Redirect to a welcome page
                exit();
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "Username not found.";
        }

        $stmt->close();
    } else {
        $error_message = "Error preparing statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="submit" value="Login">
            <br/>
            <a href="signup.php" class="signup-button">Don't have an account? Sign up here.</a>
        </form>
    </div>
</body>
</html>
