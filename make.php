<?php
// Database configuration
$host = 'localhost';
$username = 'wildrift';
$password = 'xcix456$$';
$database = 'wildrift_chrm';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully.\n";

// Start and end range for chatroom codes
$start = 831; // Start from 000831
$end = 99999; // End at 99999

// Loop through the range and insert records
for ($i = $start; $i <= $end; $i++) {
    // Format the code as a 5-digit number with leading zeros
    $code = str_pad($i, 5, '0', STR_PAD_LEFT);

    // Prepare the SQL query
    $sql = "INSERT INTO chatroom (code, chatroom_code) VALUES ('$code', '$code')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Inserted: $code\n";
    } else {
        echo "Error inserting $code: " . $conn->error . "\n";
    }
}

// Close the connection
$conn->close();

echo "Script completed.\n";
?>
