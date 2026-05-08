<?php
require_once '../config.php';

header('Content-Type: application/json');

try {
    // Fetch pending requests that have coordinates
    $stmt = $conn->prepare("SELECT br.blood_type, br.hospital_name, br.latitude, br.longitude, br.message, u.full_name 
                            FROM blood_requests br 
                            JOIN users u ON br.user_id = u.id 
                            WHERE br.status = 'Pending' AND br.latitude IS NOT NULL");
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $requests
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
