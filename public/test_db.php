<?php
require_once __DIR__ . '/../src/config/config.php';

if ($conn) {
    echo "<h1>Database Connected Successfully!</h1>";
    
    // Test query on fish species
    $result = $conn->query("SELECT COUNT(*) AS total FROM fish_species");
    $data = $result->fetch_assoc();
    echo "<p>Total fish species found in database: <strong>" . $data['total'] . "</strong></p>";
}
?>