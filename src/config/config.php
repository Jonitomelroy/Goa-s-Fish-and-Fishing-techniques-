<?php
// InfinityFree Database Configuration
$host = 'sql313.infinityfree.com';
$db   = 'if0_42908027_goa_fishing';
$user = 'if0_42908027';
$pass = 'HZYxoTuVlLZ5Zn'; // Replace with your vPanel / MySQL password

// Create Connection
$conn = new mysqli($host, $user, $pass, $db);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Set character set to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");
?>