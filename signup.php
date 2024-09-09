<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Username already exists. Please choose a different username.";
        } else {
            // Close the statement as it is no longer needed
            $stmt->close();
            
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute SQL statement to insert the new user
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    echo "Signup successful!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close(); // Close the statement after use
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <p><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="submit" value="Sign Up">
            <br/>
            <a href="login.php" class="login-button">Already have an account? Log in here.</a>
        </form>
    </div>
</body>
</html>