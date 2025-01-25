<?php
$start = 831;
$end = 99999;

// Open a file to write the queries
$file = fopen("insert_queries.sql", "w");

if ($file) {
    for ($i = $start; $i <= $end; $i++) {
        $code = str_pad($i, 5, "0", STR_PAD_LEFT);  // Ensure the code is always 5 digits long
        $query = "INSERT INTO chatroom (code, chatroom_code) VALUES ('$code', '$code');\n";
        fwrite($file, $query);
    }

    fclose($file);
    echo "SQL queries have been written to insert_queries.sql.\n";
} else {
    echo "Unable to open the file for writing.\n";
}
?>
