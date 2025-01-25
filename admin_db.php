<?php
$host = 'localhost'; // Your MySQL server host
$dbname = 'wildrift_cr'; // Corrected database name
$username = 'wildrift'; // Your MySQL username
$password = 'xcix456$$'; // Your MySQL password

// Create a PDO instance
try {
    // Initialize the PDO object
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode for PDO errors
} catch (PDOException $e) {
    // If the connection fails, output the error message
    die("Connection failed: " . $e->getMessage());
}
?>
