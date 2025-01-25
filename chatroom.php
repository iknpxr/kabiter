<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['chatroom_code'])) {
    header("Location: index.php");
    exit();
}

// Generate a unique username if it doesn't exist in session
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'User_' . uniqid();
}

$chatroom_code = $_SESSION['chatroom_code'];
$username = $_SESSION['username'];

// Fetch messages from the database
$query = "SELECT * FROM messages WHERE chatroom_code = ? ORDER BY timestamp ASC";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $chatroom_code);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$stmt->close();

// Handle Exit Button Click
if (isset($_POST['exit'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chatroom</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Welcome to Chatroom: <?php echo htmlspecialchars($chatroom_code); ?></h1>
<h2>Username: <?php echo htmlspecialchars($username); ?></h2>
<div id="messagesContainer">
<?php foreach ($messages as $message): ?>
<div class="message">
<span><?php echo htmlspecialchars($message['sender']); ?>:</span> <?php echo htmlspecialchars($message['message']); ?>
<div class="timestamp"><?php echo htmlspecialchars($message['timestamp']); ?></div>
</div>
<?php endforeach; ?>
</div>

<form id="sendMessageForm">
<input type="text" id="messageInput" placeholder="Type your message here" required />
<button type="submit">Send</button>
</form>

<form id="exitForm" method="POST">
<button id="exitButton" type="submit" name="exit" value="true">Exit Chatroom</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sendMessageForm = document.getElementById('sendMessageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesContainer = document.getElementById('messagesContainer');

    const sendMessage = async (message) => {
        try {
            const response = await fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `message=${encodeURIComponent(message)}&chatroom_code=<?php echo $chatroom_code; ?>&username=<?php echo $username; ?>`,
            });

            const result = await response.json();
            if (result.success) {
                console.log('Message sent successfully!');
                fetchMessages();
            } else {
                console.error('Error sending message:', result.message);
                alert(result.message);
            }
        } catch (error) {
            console.error('Network error:', error);
            alert('Failed to send the message. Please try again.');
        }
    };

    const fetchMessages = async () => {
        try {
            const response = await fetch('fetch_messages.php?chatroom_code=<?php echo $chatroom_code; ?>');
            const messages = await response.json();

            messagesContainer.innerHTML = '';

            messages.forEach((msg) => {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message');
                messageElement.innerHTML = `<span>${msg.sender}:</span> ${msg.message}<div class="timestamp">${msg.timestamp}</div>`;
                messagesContainer.appendChild(messageElement);
            });

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        } catch (error) {
            console.error('Failed to fetch messages:', error);
        }
    };

    sendMessageForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            sendMessage(message);
            messageInput.value = '';
        } else {
            alert('Message cannot be empty.');
        }
    });

    fetchMessages();
    setInterval(fetchMessages, 5000);
});
</script>
</body>
</html>
