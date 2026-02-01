<?php
// Database setup script - RUN ONCE then DELETE

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'lostandfound';

try {
    // Connect
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    $pdo->exec("USE $db");
    
    // Create items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        item_type ENUM('lost', 'found') NOT NULL,
        title VARCHAR(200) NOT NULL,
        description TEXT NOT NULL,
        category VARCHAR(100) NOT NULL,
        date_reported DATE NOT NULL,
        location VARCHAR(200) NOT NULL,
        status ENUM('active', 'claimed', 'returned') DEFAULT 'active',
        reporter_name VARCHAR(100) NOT NULL,
        reporter_email VARCHAR(100) NOT NULL,
        reporter_phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert admin user (password: admin123)
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (username, password) VALUES ('admin', '$hash')");
    
    // Insert sample data
    $pdo->exec("INSERT INTO items (item_type, title, description, category, date_reported, location, reporter_name, reporter_email) VALUES
    ('lost', 'Black iPhone 13', 'Lost black iPhone with red case', 'Electronics', '2026-01-20', 'Main Library', 'John Smith', 'john@example.com'),
    ('found', 'Blue Wallet', 'Found wallet with ID cards', 'Accessories', '2026-01-22', 'Student Union', 'Sarah Johnson', 'sarah@example.com'),
    ('lost', 'Silver MacBook Pro', 'MacBook with university stickers', 'Electronics', '2026-01-19', 'Computer Lab', 'Mike Chen', 'mike@example.com'),
    ('found', 'Set of Keys', 'Keys with Toyota keychain', 'Accessories', '2026-01-23', 'Parking Lot', 'Emma Wilson', 'emma@example.com'),
    ('lost', 'Red Backpack', 'Jansport backpack with textbooks', 'Bags', '2026-01-21', 'Engineering Building', 'David Lee', 'david@example.com')");
    
    echo "<h1 style='color: green;'>✅ Setup Complete!</h1>";
    echo "<p>Database created successfully!</p>";
    echo "<p><strong>IMPORTANT: Delete this setup.php file now!</strong></p>";
    echo "<p><a href='index.php' style='background: #6366f1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;'>Go to Homepage</a></p>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
