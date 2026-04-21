<?php
$db = new mysqli('localhost', 'root', '', 'pms_db');
if ($db->connect_error) { die('CONNECT ERROR: ' . $db->connect_error); }

// 1. Final Expansion of Categories for micro-POIs
$db->query("ALTER TABLE `assets` MODIFY COLUMN `asset_type` ENUM('Building','Land','Water Body','Vehicle','Equipment','Borewell','Streetlight','School','Hospital','Health Center','Panchayat Bhavan','Public Toilet','Solar Plant','Library','Religious Place','Playground','Market','Garden','Monument','Historical Landmark','Transportation Hub','Hotel','Mall','Restaurant','Medical Shop','Bank','ATM','Petrol Pump','Police Station','Post Office','Chowk','Clinic','Jewelry Shop','Textile Hub','Cinema','Workshop','Dargah') NOT NULL");

// 2. Micro-Mapping of Symbols observed in Burhanpur
$micro_pois = [
    // Clinical/Medicals (+)
    ['Shifa Medical & Clinic', 'Clinic', 'Local health clinic marked with a cross (+) providing primary care.', 'Near Jama Masjid', 21.3128, 76.2365, 'Functional'],
    ['Life Care Medical Store', 'Medical Shop', '24/7 Pharmacy with the medical cross symbol visibility.', 'Shanwara Road', 21.3142, 76.2165, 'Functional'],
    
    // Historical/Religious Specifics
    ['Dargah-e-Hakimi', 'Dargah', 'A world-famous pilgrimage site for the Dawoodi Bohra community.', 'Lodhipura', 21.2980, 76.2185, 'Functional'],
    ['Renuka Mata Mandir', 'Religious Place', 'Historical temple marked with religious symbols on the hills.', 'Biroda Road', 21.2850, 76.2450, 'Functional'],
    
    // Commercial Symbols
    ['Sagar Jewels', 'Jewelry Shop', 'Premium jewelry store marked with the diamond icon.', 'Main Bazar', 21.3132, 76.2305, 'Functional'],
    ['Rana Textile Hub', 'Textile Hub', 'Wholesale textile shop marked with shopping bag symbols.', 'Cloth Market', 21.3118, 76.2322, 'Functional'],
    ['Chitra Talkies', 'Cinema', 'One of the oldest cinema houses in Burhanpur marked with a film reel.', 'MG Road', 21.3098, 76.2155, 'Functional'],
    
    // Industrial/Workshop
    ['Burhanpur Powerloom Cluster', 'Workshop', 'Industrial zone for the city\'s famous textile manufacturing.', 'Powerloom Area', 21.3180, 76.2400, 'Functional'],
    
    // Additional Micro-POIs
    ['National Bank ATM', 'ATM', 'Automated Teller Machine located near the commercial center.', 'Gandhi Chowk', 21.3112, 76.2308, 'Functional'],
    ['Burhanpur Central Post Office', 'Post Office', 'Primary mail hub with the official postal symbol.', 'Civil Lines', 21.3082, 76.2202, 'Functional'],
    ['Anand Garden & Marriage Hall', 'Garden', 'Event space and public park area.', 'Rastipura', 21.3110, 76.2215, 'Functional']
];

foreach($micro_pois as $item) {
    $check = $db->query("SELECT id FROM assets WHERE asset_name = '".$db->real_escape_string($item[0])."'");
    if($check->num_rows == 0) {
        $sql = "INSERT INTO assets (asset_name, asset_type, description, location, latitude, longitude, current_status) VALUES ('".$db->real_escape_string($item[0])."', '".$item[1]."', '".$db->real_escape_string($item[2])."', '".$db->real_escape_string($item[3])."', ".$item[4].", ".$item[5].", '".$item[6]."')";
        $db->query($sql);
    }
}

echo "Micro-POI Symbol synchronized successfully! '+' (Clinics), Jewelry, Textiles, and Cinemas covered. Done.";
