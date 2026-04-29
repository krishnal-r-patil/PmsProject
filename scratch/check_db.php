<?php
$db = mysqli_connect('localhost', 'root', '', 'pms_db');
$tables = ['applications', 'birth_death_register', 'service_categories'];
foreach($tables as $t) {
    echo "--- $t ---\n";
    $res = mysqli_query($db, "DESCRIBE $t");
    if($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo "{$row['Field']} ({$row['Type']})\n";
        }
    } else {
        echo "Table $t not found or error: " . mysqli_error($db) . "\n";
    }
}
