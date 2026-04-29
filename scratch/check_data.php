<?php
$db = mysqli_connect('localhost', 'root', '', 'pms_db');
echo "--- meetings list ---\n";
$res = mysqli_query($db, 'SELECT title, meeting_date, meeting_type, status FROM meetings ORDER BY meeting_date DESC');
while ($row = mysqli_fetch_assoc($res)) {
    echo "{$row['title']} ({$row['meeting_date']}) - {$row['meeting_type']} [{$row['status']}]\n";
}

echo "\n--- proceedings list ---\n";
$res = mysqli_query($db, 'SELECT title, meeting_date FROM proceedings ORDER BY meeting_date DESC');
while ($row = mysqli_fetch_assoc($res)) {
    echo "{$row['title']} ({$row['meeting_date']})\n";
}
