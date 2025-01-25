<?php
// login.php - Login page for admin access

// Start the session to manage user login
session_start();

// Check if the user is already logged in, if so, redirect to admin page
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

// Initialize error message
$error_message = "";

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password match the admin credentials
    if ($username === 'adminer' && $password === 'xcixxcix') {
        // Set session variables to mark the user as logged in
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: darkblue;
        }
        .error {
            text-align: center;
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Login</h1>

    <?php if ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn">Login</button>
    </form>
</div>

</body>
</html>
