<?php
$servername = "localhost";  // Replace with your database server
$username = "username";     // Your MySQL username
$password = "password";     // Your MySQL password
$dbname = "chatroom";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read the SQL file
$sqlFile = "insert_queries.sql";  // Path to the generated SQL file
$sqlQueries = file_get_contents($sqlFile);

if ($sqlQueries) {
    if ($conn->multi_query($sqlQueries)) {
        echo "SQL queries executed successfully.\n";
    } else {
        echo "Error executing queries: " . $conn->error . "\n";
    }
} else {
    echo "Error reading the SQL file.\n";
}

$conn->close();
?>
