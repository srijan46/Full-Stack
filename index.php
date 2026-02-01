<?php
require_once 'includes/db.php';

// Get stats
$stmt = $pdo->query("SELECT 
    COUNT(CASE WHEN item_type = 'lost' AND status = 'active' THEN 1 END) as lost,
    COUNT(CASE WHEN item_type = 'found' AND status = 'active' THEN 1 END) as found,
    COUNT(CASE WHEN status != 'active' THEN 1 END) as resolved
    FROM items");
$stats = $stmt->fetch();

// Get recent items
$items = $pdo->query("SELECT * FROM items WHERE status = 'active' ORDER BY created_at DESC LIMIT 6")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a href="index.php" class="logo">🔍 Lost & Found</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="browse.php">Browse</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="report.php">Report Item</a></li>
                <?php if(isAdmin()): ?>
                    <li><a href="admin.php">Admin</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Admin Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="card hero">
            <h1>Lost Something? Found Something?</h1>
            <p>Your campus lost and found system. Help reunite items with their owners.</p>
            <a href="report.php?type=lost" class="btn btn-primary">Report Lost Item</a>
            <a href="report.php?type=found" class="btn btn-secondary">Report Found Item</a>
        </div>

        <div class="stats">
            <div class="stat-box">
                <h2><?= $stats['lost'] ?></h2>
                <p>Lost Items</p>
            </div>
            <div class="stat-box">
                <h2><?= $stats['found'] ?></h2>
                <p>Found Items</p>
            </div>
            <div class="stat-box">
                <h2><?= $stats['resolved'] ?></h2>
                <p>Resolved</p>
            </div>
        </div>

        <h2 class="mb-2">Recent Items</h2>
        <div class="grid">
            <?php foreach($items as $item): ?>
                <div class="item-card">
                    <span class="badge badge-<?= $item['item_type'] ?>">
                        <?= strtoupper($item['item_type']) ?>
                    </span>
                    <h3><?= clean($item['title']) ?></h3>
                    <p><strong>Category:</strong> <?= clean($item['category']) ?></p>
                    <p><strong>Location:</strong> <?= clean($item['location']) ?></p>
                    <p><strong>Date:</strong> <?= date('M d, Y', strtotime($item['date_reported'])) ?></p>
                    <p><?= substr(clean($item['description']), 0, 100) ?>...</p>
                    <a href="view.php?id=<?= $item['id'] ?>" class="btn btn-primary" style="margin-top: 1rem;">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-2">
            <a href="browse.php" class="btn btn-primary">View All Items</a>
        </div>
    </div>

    <footer class="footer">
        <p>@2026 all rights reserved</p>
    </footer>
</body>
</html>
