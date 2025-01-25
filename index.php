<?php
session_start();

// If the user is already in a chatroom, redirect them to the chatroom page
if (isset($_SESSION['chatroom_id'])) {
    header("Location: chatroom.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Chatroom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 60%;
        }
        button {
            padding: 10px 20px;
            background-color: teal;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: darkcyan;
        }
        #errorMessage {
            color: red;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enter Chatroom Code</h1>
        <form id="joinForm" method="POST" action="join_chatroom.php">
            <input type="text" name="chatroom_code" id="chatroom_code" placeholder="Enter 5-digit code" maxlength="5" required>
            <br>
            <button type="submit">Join Chatroom</button>
        </form>
        <p id="errorMessage"></p>
    </div>

    <script>
        // Optional: You can add JavaScript here to validate the chatroom code format
        document.getElementById('joinForm').addEventListener('submit', function(event) {
            const chatroomCode = document.getElementById('chatroom_code').value;
            if (!/^\d{5}$/.test(chatroomCode)) {
                event.preventDefault();
                document.getElementById('errorMessage').textContent = 'Please enter a valid 5-digit chatroom code.';
                document.getElementById('errorMessage').style.display = 'block';
            }
        });
    </script>
</body>
</html>
