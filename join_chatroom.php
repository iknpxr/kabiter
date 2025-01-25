<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chatroom_code = $_POST['chatroom_code'];

    $stmt = $mysqli->prepare("SELECT id FROM chatroom WHERE code = ?");
    $stmt->bind_param("s", $chatroom_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Chatroom exists
        $row = $result->fetch_assoc();
        $_SESSION['chatroom_id'] = $row['id'];
        $_SESSION['chatroom_code'] = $chatroom_code;

        // Generate random animal username
        $animals = ['Lion', 'Tiger', 'Bear', 'Giraffe', 'Zebra'];
        $random_username = $animals[array_rand($animals)];
        $_SESSION['username'] = $random_username;

        header("Location: chatroom.php");
        exit();
    } else {
        // Invalid chatroom code
        header("Location: index.php?error=invalid_code");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
