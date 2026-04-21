<?php
// Script to enhance proceedings table for more informative records
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "pms_db";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add columns for more detailed proceedings
$sql = "ALTER TABLE proceedings 
        ADD COLUMN attendees TEXT AFTER minutes,
        ADD COLUMN agenda TEXT AFTER attendees,
        ADD COLUMN resolutions TEXT AFTER agenda";

if ($conn->query($sql) === TRUE) {
    echo "Proceedings table enhanced successfully with attendees, agenda, and resolutions columns.";
} else {
    echo "Error updating table: " . $conn->error;
}

$conn->close();
?>
