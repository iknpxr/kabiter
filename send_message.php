<?php
session_start();
require 'db_config.php'; // This file should have the correct DB connection settings

// Change the DB connection if needed (in db_config.php), ensure it connects to wildrift_cr
$mysqli = new mysqli("localhost", "wildrift", "xcix456$$", "wildrift_cr");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in and is part of a chatroom
    if (!isset($_SESSION['chatroom_code'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged into a chatroom.']);
        exit();
    }

    // Check if the username is already set; if not, generate one
    if (!isset($_SESSION['username'])) {
        // List of gerunds and animals
        $gerunds = ['Running', 'Jumping', 'Flying', 'Swimming', 'Climbing'];
        $animals = ['Lion', 'Tiger', 'Bear', 'Giraffe', 'Zebra'];

        // Randomly pick a gerund and an animal
        $random_gerund = $gerunds[array_rand($gerunds)];
        $random_animal = $animals[array_rand($animals)];

        // Create the username in the format "Gerund-Animal"
        $_SESSION['username'] = $random_gerund . $random_animal;


    }

   
    // Sanitize and retrieve POST data
    $chatroom_code = $_SESSION['chatroom_code'];
    $username = $_SESSION['username'];
    $message = trim($_POST['message']);

    // Check if the message is not empty and within a reasonable length
    if (empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
        exit();
    }

    if (strlen($message) > 1000) { // Limit message length to 1000 characters
        echo json_encode(['success' => false, 'message' => 'Message is too long.']);
        exit();
    }

    // Prepare SQL query to insert the message into the database
    $query = "INSERT INTO messages (chatroom_code, sender, message, timestamp) VALUES (?, ?, ?, NOW())";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
        exit();
    }

    // Bind parameters and execute the query
    $stmt->bind_param('sss', $chatroom_code, $username, $message);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send message. Error: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
