<?php
$conn = new mysqli('localhost', 'root', '', 'pms_db');
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Sample Alerts
$conn->query("INSERT INTO emergency_alerts (title, message, type, severity, is_active) VALUES 
('Heatwave Warning', 'Extreme temperatures expected (45°C+). Avoid outdoor farming between 12-4 PM.', 'Weather', 'High', 1),
('Vaccination Drive', 'Free Polio vaccination camp at Panchayat Bhawan starting tomorrow 10 AM.', 'Health', 'Medium', 1)");

// Sample Health Directory
$conn->query("INSERT INTO health_directory (category, name, contact_no, address, service_hours, is_verified) VALUES 
('Hospital', 'Keshra Medical College & Hospital', '07325-242200', 'Burhanpur-Indore Hwy', '24/7', 1),
('Ambulance', 'Sankat Mochan Ambulance', '98260-12345', 'Village Square Bus Stand', '24/7', 1),
('Pharmacy', 'LifeCare Pharmacy', '94250-99887', 'Gautam Market, Gram Panchayat', '08:00 AM - 11:00 PM', 1)");

// Sample Blood Donors
$conn->query("INSERT INTO health_directory (category, name, contact_no, blood_group, is_verified) VALUES 
('Blood Donor', 'Rahul Solanki', '99001-22334', 'O+', 1),
('Blood Donor', 'Anjali Thakur', '88776-55443', 'B-', 1)");

echo "Emergency dummy data seeded.";
$conn->close();
