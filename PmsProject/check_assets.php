<?php
$db = new mysqli('localhost', 'root', '', 'pms_db');
$res = $db->query('DESCRIBE assets');
while($row = $res->fetch_assoc()) { 
    echo $row['Field'] . " (" . $row['Type'] . ")\n"; 
}
