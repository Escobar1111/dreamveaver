<?php
session_start();

// Hardcoded admin credentials
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', '12345'); // Replace with your desired password

// Initialize error message
$error = "";

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // Check credentials
    if ($adminUsername === ADMIN_USERNAME && $adminPassword === ADMIN_PASSWORD) {
        // Set session variables
        $_SESSION['is_admin'] = true;
        header("Location: admin.php"); // Redirect to admin dashboard
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Esco Car Rental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #1c1c1c;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            text-align: center;
            color: #e67e22;
            margin-bottom: 20px;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container label {
            margin-bottom: 5px;
            font-size: 1rem;
        }
        .login-container input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #2c2c2c;
            color: #fff;
            font-size: 1rem;
        }
        .login-container input:focus {
            border-color: #e67e22;
            outline: none;
        }
        .login-container button {
            padding: 12px;
            background-color: #e67e22;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-container button:hover {
            background-color: #d35400;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
		<a href="home.html" class="home-button">Back to Homepage</a>
    </div>
</body>
</html>
