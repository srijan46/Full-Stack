<?php
require_once 'includes/db.php';

if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle actions
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['action'] == 'update') {
        $stmt = $pdo->prepare("UPDATE items SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['id']]);
        $message = "Status updated!";
    }
    
    if($_POST['action'] == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $message = "Item deleted!";
    }
}

// Get stats
$stats = $pdo->query("SELECT 
    COUNT(*) as total,
    COUNT(CASE WHEN status = 'active' THEN 1 END) as active,
    COUNT(CASE WHEN item_type = 'lost' THEN 1 END) as lost,
    COUNT(CASE WHEN item_type = 'found' THEN 1 END) as found
    FROM items")->fetch();

// Get all items
$items = $pdo->query("SELECT * FROM items ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lost & Found</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a href="index.php" class="logo">🔍 Admin Panel</a>
            <ul class="nav-links">
                <li><a href="index.php">View Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Admin Dashboard</h1>

        <?php if($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-box">
                <h2><?= $stats['total'] ?></h2>
                <p>Total Items</p>
            </div>
            <div class="stat-box">
                <h2><?= $stats['active'] ?></h2>
                <p>Active</p>
            </div>
            <div class="stat-box">
                <h2><?= $stats['lost'] ?></h2>
                <p>Lost</p>
            </div>
            <div class="stat-box">
                <h2><?= $stats['found'] ?></h2>
                <p>Found</p>
            </div>
        </div>

        <div class="card">
            <h2>All Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><span class="badge badge-<?= $item['item_type'] ?>"><?= $item['item_type'] ?></span></td>
                            <td><?= clean($item['title']) ?></td>
                            <td><?= clean($item['category']) ?></td>
                            <td><?= clean($item['location']) ?></td>
                            <td><?= date('M d', strtotime($item['date_reported'])) ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 4px;">
                                        <option <?= $item['status'] == 'active' ? 'selected' : '' ?>>active</option>
                                        <option <?= $item['status'] == 'claimed' ? 'selected' : '' ?>>claimed</option>
                                        <option <?= $item['status'] == 'returned' ? 'selected' : '' ?>>returned</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="view.php?id=<?= $item['id'] ?>" class="btn btn-primary" target="_blank">View</a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this item?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button class="btn btn-secondary">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Lost & Found System. Made by Students.</p>
    </footer>
</body>
</html>
