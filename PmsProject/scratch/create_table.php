<?php
$db = mysqli_connect('localhost', 'root', '', 'pms_db');
$sql = "CREATE TABLE IF NOT EXISTS service_categories (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(255) NOT NULL, 
    prefix VARCHAR(50), 
    description TEXT, 
    processing_days INT DEFAULT 7, 
    fees DECIMAL(10,2) DEFAULT 0, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if(mysqli_query($db, $sql)) echo "Table service_categories created.\n";
else echo "Error: " . mysqli_error($db) . "\n";
