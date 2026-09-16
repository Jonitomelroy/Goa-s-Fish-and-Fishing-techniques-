<?php
require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$email = 'admin@example.com';
$password = 'Password123';
$hashed = password_hash($password, PASSWORD_BCRYPT);
$user_uid = 'ADM-9999';

// Delete existing row if exists
$conn->query("DELETE FROM users WHERE email = '$email'");

// Insert new admin
$stmt = $conn->prepare("INSERT INTO users (user_uid, full_name, email, password, role) VALUES (?, 'System Admin', ?, ?, 'admin')");
$stmt->bind_param("sss", $user_uid, $email, $hashed);

if ($stmt->execute()) {
    echo "<h2 style='color:green;'>Admin created successfully!</h2>";
    echo "<p><strong>Email:</strong> admin@example.com<br><strong>Password:</strong> Password123</p>";
    echo "<a href='login.php'>Go to Login</a>";
} else {
    echo "Error: " . $conn->error;
}
?>