<?php
require_once 'includes/db.php';

// Get filters
$type = $_GET['type'] ?? 'all';
$category = $_GET['category'] ?? 'all';
$status = $_GET['status'] ?? 'active';

// Build query
$sql = "SELECT * FROM items WHERE 1=1";
$params = [];

if($type != 'all') {
    $sql .= " AND item_type = ?";
    $params[] = $type;
}
if($category != 'all') {
    $sql .= " AND category = ?";
    $params[] = $category;
}
if($status != 'all') {
    $sql .= " AND status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();

// Get categories
$categories = $pdo->query("SELECT DISTINCT category FROM items ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Items - Lost & Found</title>
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
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Browse All Items</h1>

        <div class="card">
            <form method="GET" class="filters">
                <div>
                    <label>Type</label>
                    <select name="type" onchange="this.form.submit()">
                        <option value="all" <?= $type == 'all' ? 'selected' : '' ?>>All</option>
                        <option value="lost" <?= $type == 'lost' ? 'selected' : '' ?>>Lost</option>
                        <option value="found" <?= $type == 'found' ? 'selected' : '' ?>>Found</option>
                    </select>
                </div>
                <div>
                    <label>Category</label>
                    <select name="category" onchange="this.form.submit()">
                        <option value="all">All Categories</option>
                        <?php foreach($categories as $cat): ?>
                            <option <?= $category == $cat ? 'selected' : '' ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Status</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>All</option>
                        <option value="claimed" <?= $status == 'claimed' ? 'selected' : '' ?>>Claimed</option>
                    </select>
                </div>
                <div>
                    <label>&nbsp;</label>
                    <a href="browse.php" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>

        <p style="margin-bottom: 1rem; color: #718096;">Showing <?= count($items) ?> item(s)</p>

        <div class="grid">
            <?php foreach($items as $item): ?>
                <div class="item-card">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span class="badge badge-<?= $item['item_type'] ?>">
                            <?= strtoupper($item['item_type']) ?>
                        </span>
                        <span class="badge badge-active"><?= $item['status'] ?></span>
                    </div>
                    <h3><?= clean($item['title']) ?></h3>
                    <p><strong>Category:</strong> <?= clean($item['category']) ?></p>
                    <p><strong>Location:</strong> <?= clean($item['location']) ?></p>
                    <p><strong>Date:</strong> <?= date('M d, Y', strtotime($item['date_reported'])) ?></p>
                    <p><?= substr(clean($item['description']), 0, 100) ?>...</p>
                    <a href="view.php?id=<?= $item['id'] ?>" class="btn btn-primary" style="margin-top: 1rem;">View</a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if(empty($items)): ?>
            <div class="card text-center">
                <h3>No items found</h3>
                <p>Try adjusting your filters</p>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Lost & Found System. Made by Students.</p>
    </footer>
</body>
</html>
