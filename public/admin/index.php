<?php
require_once 'config/db.php';

// Fetch all home page key-value pairs
$stmt = $pdo->prepare("SELECT element_key, element_value FROM site_content WHERE page_name = 'home'");
$stmt->execute();
$page = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <!-- Dynamic Hero Section -->
    <section class="hero">
        <h1><?= htmlspecialchars($page['hero_title'] ?? 'Default Welcome Title') ?></h1>
        
        <p><?= nl2br(htmlspecialchars($page['hero_desc'] ?? 'Default description text.')) ?></p>
        
        <a href="<?= htmlspecialchars($page['hero_link'] ?? '#') ?>" class="btn">Click Here</a>
        
        <?php if (!empty($page['hero_image'])): ?>
            <img src="<?= htmlspecialchars($page['hero_image']) ?>" alt="Hero Banner">
        <?php endif; ?>
    </section>
</body>
</html>
