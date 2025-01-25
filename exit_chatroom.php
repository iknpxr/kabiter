<?php
session_start();

// Destroy the session to log the user out of the chatroom
session_unset();
session_destroy();

// Redirect back to the main page
header("Location: index.php");
exit();
?>
