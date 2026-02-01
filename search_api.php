<?php
require_once 'includes/db.php';

$q = $_POST['q'] ?? '';
$type = $_POST['type'] ?? '';
$category = $_POST['category'] ?? '';
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';

$sql = "SELECT * FROM items WHERE status = 'active'";
$params = [];

if($q) {
    $sql .= " AND (title LIKE ? OR description LIKE ? OR location LIKE ?)";
    $params[] = "%$q%";
    $params[] = "%$q%";
    $params[] = "%$q%";
}

if($type) {
    $sql .= " AND item_type = ?";
    $params[] = $type;
}

if($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

if($from) {
    $sql .= " AND date_reported >= ?";
    $params[] = $from;
}

if($to) {
    $sql .= " AND date_reported <= ?";
    $params[] = $to;
}

$sql .= " ORDER BY created_at DESC LIMIT 50";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($items);
?>
