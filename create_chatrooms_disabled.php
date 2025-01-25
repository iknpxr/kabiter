<?php
session_start();
require_once 'db_config.php';

// Ensure chatroom table exists
$query = "CREATE TABLE IF NOT EXISTS chatroom (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chatroom_code CHAR(5) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$mysqli->query($query);

// Generate chatroom codes from 00000 to 99999
for ($i = 0; $i <= 99999; $i++) {
    $chatroom_code = str_pad($i, 5, '0', STR_PAD_LEFT); // Ensure it's always 5 digits

    // Insert chatroom code into the chatroom table
    $stmt = $mysqli->prepare("INSERT IGNORE INTO chatroom (chatroom_code) VALUES (?)");
    $stmt->bind_param('s', $chatroom_code);

    if ($stmt->execute()) {
        echo "Chatroom with code $chatroom_code created successfully!<br>";
    } else {
        echo "Failed to create chatroom with code $chatroom_code.<br>";
    }

    $stmt->close();
}

$mysqli->close();
?>
