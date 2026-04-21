<?php
// Script to inject rich, informative dummy data into the proceedings table
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "pms_db";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update records with rich, informative content
$updates = [
    [
        'title' => 'Annual Budget Planning 2027',
        'minutes' => 'A comprehensive review of the 2027 fiscal requirements focusing on infrastructure expansion and healthcare accessibility.',
        'attendees' => 'Sarpanch Rajesh Kumar, Secretary Anita Shrivastav, Ward 1-7 Members, Digital Nodal Officer.',
        'agenda' => '1. Road construction in Ward 1&2\n2. Implementation of Smart Street Lights\n3. Approval of Primary Health Center expansion budget.',
        'resolutions' => 'Budget of INR 45 Lakhs approved for road works. Vendor selection for LED street lights finalized. Contract for Health Center building repairs awarded.'
    ],
    [
        'title' => 'Gram Sabha Q2 FY2026 Progress Review',
        'minutes' => 'Quarterly performance audit of ongoing schemes and verification of asset registers.',
        'attendees' => 'Gram Panchayat Council, Village Elders, 120+ Participating Residents.',
        'agenda' => '1. Audit of PM Awas Yojana distributions\n2. Review of village water tank cleaning schedule\n3. Discussion on upcoming monsoon preparedness.',
        'resolutions' => 'Approved the list of 15 new housing beneficiaries. New monthly maintenance schedule for public taps established.'
    ],
    [
        'title' => 'Annual Budget Planning 2026 Memorial',
        'minutes' => 'Foundational session for the 2026 development plan focused on sustainable farming and digitized records.',
        'attendees' => 'Full Panchayat Committee, District Agricultural Officer.',
        'agenda' => '1. Setting up of the Digital Citizen Kiosk\n2. Allocation for Agriculture Hub equipment\n3. Village playground boundary wall construction.',
        'resolutions' => 'Authorized the purchase of 2 Tractor-mounted ploughs. Land for the Digital Kiosk finalized adjacent to the Panchayat Bhawan.'
    ]
];

foreach ($updates as $val) {
    $title = $conn->real_escape_string($val['title']);
    $minutes = $conn->real_escape_string($val['minutes']);
    $attendees = $conn->real_escape_string($val['attendees']);
    $agenda = $conn->real_escape_string($val['agenda']);
    $resolutions = $conn->real_escape_string($val['resolutions']);
    
    // Attempt to match by title substring since the user might have slightly different titles
    $sql = "UPDATE proceedings 
            SET minutes = '$minutes', 
                attendees = '$attendees', 
                agenda = '$agenda', 
                resolutions = '$resolutions' 
            WHERE title LIKE '%" . explode(' ', $val['title'])[2] . "%' OR title = '$title'";
    $conn->query($sql);
}

echo "Rich demo data injected successfully. The archives will now look complete and informative.";
$conn->close();
?>
