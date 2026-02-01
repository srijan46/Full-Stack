<?php
require_once 'includes/db.php';

$message = '';
$type = $_GET['type'] ?? 'lost';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO items (item_type, title, description, category, date_reported, location, reporter_name, reporter_email, reporter_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if($stmt->execute([
        $_POST['type'],
        $_POST['title'],
        $_POST['description'],
        $_POST['category'],
        $_POST['date'],
        $_POST['location'],
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'] ?? ''
    ])) {
        $message = "Item reported successfully!";
    } else {
        $message = "Error reporting item.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Item - Lost & Found</title>
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
            <h1>Report an Item</h1>
            <p style="color: #718096; margin-bottom: 2rem;">Fill in the details below</p>

            <?php if($message): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Item Type <span class="required">*</span></label>
                    <div style="display: flex; gap: 2rem;">
                        <label>
                            <input type="radio" name="type" value="lost" <?= $type == 'lost' ? 'checked' : '' ?> required>
                            Lost Item
                        </label>
                        <label>
                            <input type="radio" name="type" value="found" <?= $type == 'found' ? 'checked' : '' ?>>
                            Found Item
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title" placeholder="e.g., Black iPhone 13" required>
                </div>

                <div class="form-group">
                    <label>Category <span class="required">*</span></label>
                    <select name="category" required>
                        <option value="">Select category</option>
                        <option>Electronics</option>
                        <option>Accessories</option>
                        <option>Bags</option>
                        <option>Clothing</option>
                        <option>Documents</option>
                        <option>Books</option>
                        <option>Keys</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description <span class="required">*</span></label>
                    <textarea name="description" placeholder="Provide detailed description..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Date Lost/Found <span class="required">*</span></label>
                    <input type="date" name="date" max="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label>Location <span class="required">*</span></label>
                    <input type="text" name="location" list="locations" placeholder="e.g., Main Library" required>
                    <datalist id="locations">
                        <option value="Main Library">
                        <option value="Student Union">
                        <option value="Computer Lab">
                        <option value="Cafeteria">
                        <option value="Gym">
                        <option value="Parking Lot">
                    </datalist>
                </div>

                <div class="form-group">
                    <label>Your Name <span class="required">*</span></label>
                    <input type="text" name="name" placeholder="Full name" required>
                </div>

                <div class="form-group">
                    <label>Your Email <span class="required">*</span></label>
                    <input type="email" name="email" placeholder="your@email.com" required>
                </div>

                <div class="form-group">
                    <label>Your Phone</label>
                    <input type="tel" name="phone" placeholder="555-0123">
                </div>

                <button type="submit" class="btn btn-primary">Submit Report</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Lost & Found System. Made by Students.</p>
    </footer>

    <script>
        document.querySelector('input[name="date"]').valueAsDate = new Date();
    </script>
</body>
</html>
