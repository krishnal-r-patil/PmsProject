<?php
$db = new mysqli('localhost', 'root', '', 'pms_db');
if ($db->connect_error) { die('CONNECT ERROR: ' . $db->connect_error); }

// 1. Update Asset Types and add Coordinates
$db->query("ALTER TABLE `assets` MODIFY COLUMN `asset_type` ENUM('Building','Land','Water Body','Vehicle','Equipment','Borewell','Streetlight','School','Hospital','Health Center','Panchayat Bhavan') NOT NULL");

// Add lat/lng columns if they don't exist
$res = $db->query("SHOW COLUMNS FROM `assets` LIKE 'latitude'");
if ($res->num_rows == 0) {
    $db->query("ALTER TABLE `assets` ADD COLUMN `latitude` DECIMAL(10,8) DEFAULT NULL");
    $db->query("ALTER TABLE `assets` ADD COLUMN `longitude` DECIMAL(11,8) DEFAULT NULL");
    echo "Added lat/lng columns. ";
}

// 2. Seed some GIS coordinates (Centered around a generic MP village coord: 22.9676, 76.0534)
$base_lat = 22.9676;
$base_lng = 76.0534;

// Get all assets
$assets = $db->query("SELECT id FROM assets");
$i = 0;
while($row = $assets->fetch_assoc()) {
    $id = $row['id'];
    // Random offset to show them scattered
    $lat = $base_lat + (rand(-500, 500) / 10000);
    $lng = $base_lng + (rand(-500, 500) / 10000);
    $db->query("UPDATE assets SET latitude = $lat, longitude = $lng WHERE id = $id");
    $i++;
}

// 3. Add some specialized infrastructure assets if they don't exist
$infra = [
    ['Main Borewell #1', 'Borewell', 'High capacity borewell for Ward 1', 'Ward 1 Entrance', 22.9680, 76.0540, 'Functional'],
    ['Panchayat Primary School', 'School', 'Primary education facility', 'Main Road', 22.9670, 76.0520, 'Functional'],
    ['Govt. Health Sub-Center', 'Health Center', 'Basic healthcare facility', 'Village Square', 22.9690, 76.0550, 'Functional'],
    ['Gram Panchayat Bhavan', 'Panchayat Bhavan', 'Administrative headquarters', 'Center of Village', 22.9676, 76.0534, 'Functional']
];

foreach($infra as $item) {
    $check = $db->query("SELECT id FROM assets WHERE asset_name = '".$db->real_escape_string($item[0])."'");
    if($check->num_rows == 0) {
        $sql = "INSERT INTO assets (asset_name, asset_type, description, location, latitude, longitude, current_status) VALUES ('".$db->real_escape_string($item[0])."', '".$item[1]."', '".$db->real_escape_string($item[2])."', '".$db->real_escape_string($item[3])."', ".$item[4].", ".$item[5].", '".$item[6]."')";
        $db->query($sql);
    }
}

echo "GIS mapping data prepared for $i assets + infrastructure! Done.";
