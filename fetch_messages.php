<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli('localhost', 'wildrift', 'xcix456$$', 'wildrift_cr');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the response is in JSON format
header('Content-Type: application/json');

// Check if user is in a chatroom
if (isset($_SESSION['chatroom_code'])) {
    $chatroom_code = $_SESSION['chatroom_code'];

    // Retrieve messages for the chatroom
    $stmt = $conn->prepare("SELECT messages.message, messages.timestamp, messages.sender FROM messages
                            WHERE messages.chatroom_code = ? ORDER BY messages.timestamp ASC");
    $stmt->bind_param("s", $chatroom_code);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'message' => $row['message'],
            'sender' => $row['sender'],
            'timestamp' => $row['timestamp']
        ];
    }

    // Return messages in JSON format
    echo json_encode($messages);

    $stmt->close();
} else {
    // Return error if the user is not in a chatroom
    echo json_encode(['error' => 'User is not in a chatroom.']);
}

$conn->close();
?>
