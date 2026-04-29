<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::bootWeb($paths);

$db = \Config\Database::connect();
$projects = $db->table('projects')->select('id, title')->get()->getResultArray();
echo json_encode($projects);
