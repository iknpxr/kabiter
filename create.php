<?php
$mysqli = new mysqli("localhost", "wildrift", "xcix456$$", "wildrift_start");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

for ($i = 0; $i <= 99999; $i++) {
    $code = str_pad($i, 5, '0', STR_PAD_LEFT);
    $stmt = $mysqli->prepare("INSERT INTO chatroom (code) VALUES (?)");
    $stmt->bind_param("s", $code);
    $stmt->execute();
}

echo "Chatroom codes from 00000 to 99999 have been inserted successfully.";

$mysqli->close();
?>
