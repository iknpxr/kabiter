<?php
// logout.php - Logout page for admin

// Start the session to manage user login
session_start();

// Destroy the session to log out the user
session_destroy();

// Redirect to the login page
header('Location: login.php');
exit;
?>
