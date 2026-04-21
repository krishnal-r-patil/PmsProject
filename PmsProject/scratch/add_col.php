<?php
$db = mysqli_connect('localhost', 'root', '', 'pms_db');
$sql = "ALTER TABLE proceedings ADD COLUMN IF NOT EXISTS meeting_id INT DEFAULT NULL";
if(mysqli_query($db, $sql)) echo "Column meeting_id added to proceedings.\n";
else echo "Error: " . mysqli_error($db) . "\n";
