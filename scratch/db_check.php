<?php
$db = mysqli_connect('localhost', 'root', '', 'pms_db');
if (!$db) die('DB Fail');

echo "--- birth_death_register ---\n";
$res = mysqli_query($db, 'SHOW FULL COLUMNS FROM birth_death_register');
while ($row = mysqli_fetch_assoc($res)) print_r($row);

echo "\n--- applications ---\n";
$res = mysqli_query($db, 'SHOW FULL COLUMNS FROM applications');
while ($row = mysqli_fetch_assoc($res)) print_r($row);


echo "--- Repairing types ---\n";
mysqli_query($db, "UPDATE birth_death_register SET type = 'Income' WHERE registration_no LIKE 'INC%' AND (type = '' OR type IS NULL)");
mysqli_query($db, "UPDATE birth_death_register SET type = 'Caste' WHERE registration_no LIKE 'CST%' AND (type = '' OR type IS NULL)");
mysqli_query($db, "UPDATE birth_death_register SET type = 'Domicile' WHERE registration_no LIKE 'DOM%' AND (type = '' OR type IS NULL)");
mysqli_query($db, "UPDATE birth_death_register SET type = 'Birth' WHERE registration_no LIKE 'CRS%' AND registration_no NOT LIKE 'CRS/%/D%' AND (type = '' OR type IS NULL)");
mysqli_query($db, "UPDATE birth_death_register SET type = 'Death' WHERE (registration_no LIKE 'CRS/%/D%' OR registration_no LIKE 'CRS/%-D%') AND (type = '' OR type IS NULL)");

echo "--- updated issued certificates ---\n";
$res = mysqli_query($db, 'SELECT id, linked_user_id, registration_no, type, is_issued FROM birth_death_register WHERE is_issued = 1');
while ($row = mysqli_fetch_assoc($res)) print_r($row);







