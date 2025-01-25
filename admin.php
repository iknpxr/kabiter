<?php
// admin.php - Admin page to wipe messages for a specific chatroom

// Start the session to manage user login
session_start();

// Check if the user is already logged in, if not, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Include the database configuration (admin_db.php)
include('admin_db.php');

// Check if the form is submitted to wipe messages for a specific chatroom
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wipe_messages']) && isset($_POST['chatroom_code'])) {
    $chatroom_code = $_POST['chatroom_code'];

    // Sanitize the input to prevent SQL injection
    $chatroom_code = htmlspecialchars($chatroom_code);

    // Prepare the SQL query to delete messages for the specified chatroom
    $sql = "DELETE FROM messages WHERE chatroom_code = :chatroom_code";

    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind the parameter
        $stmt->bindParam(':chatroom_code', $chatroom_code, PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();

        // Provide feedback to the user
        $message = "Messages for chatroom '$chatroom_code' have been successfully wiped!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    // Destroy session and log out
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Wipe Messages for Chatroom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
            background-color: red;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: darkred;
        }
        .logout-btn {
            width: auto;
            background-color: blue;
            margin-top: 10px;
            text-align: center;
            padding: 10px 20px;
        }
        .logout-btn:hover {
            background-color: darkblue;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Panel</h1>
    <p>Enter the chatroom code below to wipe all messages for that chatroom.</p>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="chatroom_code">Chatroom Code:</label>
        <input type="text" id="chatroom_code" name="chatroom_code" required placeholder="Enter chatroom code" maxlength="5">
        
        <button type="submit" name="wipe_messages" class="btn" onclick="return confirm('Are you sure you want to wipe all messages for chatroom code ' + document.getElementById('chatroom_code').value + '? This cannot be undone.');">Wipe Messages</button>
    </form>

    <a href="?logout=true" class="logout-btn">Logout</a>
</div>

</body>
</html>
