<?php
$db = new mysqli('localhost', 'root', '', 'pms_db');
if ($db->connect_error) { die('CONNECT ERROR: ' . $db->connect_error); }

$sql = "CREATE TABLE IF NOT EXISTS `staff` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `name`         VARCHAR(150) NOT NULL,
  `designation`  VARCHAR(150) NOT NULL,
  `department`   VARCHAR(100) NOT NULL DEFAULT 'Administration',
  `phone`        VARCHAR(20)  NOT NULL,
  `email`        VARCHAR(150) DEFAULT NULL,
  `ward_no`      VARCHAR(20)  DEFAULT NULL,
  `joining_date` DATE         NOT NULL,
  `salary`       DECIMAL(10,2) DEFAULT NULL,
  `status`       ENUM('Active','On Leave','Retired') NOT NULL DEFAULT 'Active',
  `address`      TEXT         DEFAULT NULL,
  `created_at`   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($db->query($sql)) {
    echo "Table created/verified OK. ";

    // Ensure new columns exist if table already had old structure
    $newCols = [
        'department' => "VARCHAR(100) NOT NULL DEFAULT 'Administration'",
        'email'      => "VARCHAR(150) DEFAULT NULL",
        'ward_no'    => "VARCHAR(20) DEFAULT NULL",
        'salary'     => "DECIMAL(10,2) DEFAULT NULL",
        'address'    => "TEXT DEFAULT NULL",
    ];
    foreach ($newCols as $colName => $colDef) {
        $res = $db->query("SHOW COLUMNS FROM `staff` LIKE '$colName'");
        if ($res->num_rows == 0) {
            $db->query("ALTER TABLE `staff` ADD COLUMN `$colName` $colDef");
            echo "Added column: $colName. ";
        }
    }
    echo "All columns verified! Done.";
} else {
    echo 'ERROR: ' . $db->error;
}
