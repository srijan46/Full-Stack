<?php
require_once 'includes/db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if(!$item) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= clean($item['title']) ?> - Lost & Found</title>
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
        <div class="card">
            <div class="detail-header">
                <span class="badge badge-<?= $item['item_type'] ?>">
                    <?= strtoupper($item['item_type']) ?> ITEM
                </span>
                <span class="badge badge-active"><?= strtoupper($item['status']) ?></span>
            </div>

            <h1><?= clean($item['title']) ?></h1>

            <div class="detail-grid">
                <div class="detail-item">
                    <label>Category</label>
                    <p><?= clean($item['category']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Location</label>
                    <p><?= clean($item['location']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Date <?= $item['item_type'] == 'lost' ? 'Lost' : 'Found' ?></label>
                    <p><?= date('F d, Y', strtotime($item['date_reported'])) ?></p>
                </div>
                <div class="detail-item">
                    <label>Reported</label>
                    <p><?= date('M d, Y', strtotime($item['created_at'])) ?></p>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 600; color: #6366f1; margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.8rem;">Description</label>
                <p style="line-height: 1.8;"><?= nl2br(clean($item['description'])) ?></p>
            </div>

            <?php if($item['status'] == 'active'): ?>
                <div class="contact-box">
                    <h3>📞 Contact Information</h3>
                    <div class="contact-info">
                        <p><strong>Name:</strong> <?= clean($item['reporter_name']) ?></p>
                        <p><strong>Email:</strong> <a href="mailto:<?= $item['reporter_email'] ?>" style="color: #6366f1;"><?= clean($item['reporter_email']) ?></a></p>
                        <?php if($item['reporter_phone']): ?>
                            <p><strong>Phone:</strong> <a href="tel:<?= $item['reporter_phone'] ?>" style="color: #6366f1;"><?= clean($item['reporter_phone']) ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    This item has been marked as <strong><?= $item['status'] ?></strong>
                </div>
            <?php endif; ?>

            <div style="margin-top: 2rem;">
                <a href="javascript:history.back()" class="btn btn-primary">← Back</a>
                <a href="index.php" class="btn btn-secondary">🏠 Home</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Lost & Found System. Made by Students.</p>
    </footer>
</body>
</html>
