<?php
$db = new mysqli('localhost', 'root', '', 'pms_db');
if ($db->connect_error) { die('CONNECT ERROR: ' . $db->connect_error); }

$sql = "CREATE TABLE IF NOT EXISTS `elearning` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `title`        VARCHAR(255) NOT NULL,
  `category`     ENUM('Scholarship', 'Online Course', 'Vocational Training', 'PMKVY') NOT NULL,
  `description`  TEXT NOT NULL,
  `provider`     VARCHAR(150) NOT NULL,
  `link`         VARCHAR(255) DEFAULT NULL,
  `image_url`    VARCHAR(255) DEFAULT NULL,
  `deadline`     DATE DEFAULT NULL,
  `status`       ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($db->query($sql)) {
    echo "Table elearning created/verified OK. ";
    
    // Seed some REAL-Looking Data
    $check = $db->query("SELECT id FROM elearning LIMIT 1");
    if ($check->num_rows == 0) {
        $db->query("INSERT INTO `elearning` (`title`, `category`, `description`, `provider`, `link`, `deadline`) VALUES 
        ('Post-Matric Scholarship for SC Students', 'Scholarship', 'Financial assistance to SC students for pursuing post-matriculation courses.', 'Govt of India', 'https://scholarships.gov.in/', '2026-10-31'),
        ('PMKVY 4.0 Skill Training', 'PMKVY', 'Pradhan Mantri Kaushal Vikas Yojana training for youth in various sectors.', 'NSDC India', 'https://www.pmkvyofficial.org/', NULL),
        ('Python for Data Science (Free Course)', 'Online Course', 'Learn Python programming language with experts. Certification included.', 'SWAYAM / NPTEL', 'https://swayam.gov.in/', '2026-12-15'),
        ('Electrician Vocational Training', 'Vocational Training', 'Local training for youth to become certified electricians.', 'Panchayat Skill Hub', '#', NULL)");
        echo "Sample data seeded!";
    }
} else {
    echo 'ERROR: ' . $db->error;
}
