<?php
require_once 'config.php';

$term = $_GET['term'] ?? '';

try {
    $stmt = $conn->prepare("SELECT name, city, latitude, longitude FROM hospitals WHERE name LIKE ? OR city LIKE ? LIMIT 10");
    $stmt->execute(["%$term%", "%$term%"]);
    $results = $stmt->fetchAll();
    
    header('Content-Type: application/json');
    echo json_encode($results);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
