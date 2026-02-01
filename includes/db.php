<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'np03cs4s250020');
define('DB_USER', 'np03cs4s250020');
define('DB_PASS', 'vSxa39RIg');



// PDO connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start session
session_start();

// Simple security function
function clean($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Check if admin
function isAdmin() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}
?>
