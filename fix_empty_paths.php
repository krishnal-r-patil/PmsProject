<?php
$conn = new mysqli('localhost', 'root', '', 'pms_db');

$res = $conn->query('SELECT id, title FROM proceedings WHERE file_path IS NULL OR file_path = ""');
while($row = $res->fetch_assoc()) {
    $title = strtolower($row['title']);
    $path = 'assets/img/assembly_branding.png';
    if(strpos($title, 'budget') !== false) {
        $path = 'assets/img/budget_default.png';
    } elseif(strpos($title, 'infra') !== false || strpos($title, 'road') !== false) {
        $path = 'assets/img/infra_default.png';
    }
    
    $conn->query("UPDATE proceedings SET file_path = '$path' WHERE id = " . $row['id']);
    echo "Updated ID " . $row['id'] . " with path $path\n";
}
?>
