<?php
require_once '../config.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // DYNAMIC SYNC: Join blood_requests with hospitals to get the VERIFIED coordinates
    $stmt = $conn->prepare("
        SELECT 
            br.blood_type, 
            br.message, 
            br.hospital_name,
            u.full_name, 
            h.latitude, 
            h.longitude,
            h.name_ar as official_name
        FROM blood_requests br 
        INNER JOIN hospitals h ON br.hospital_id = h.id
        INNER JOIN users u ON br.user_id = u.id 
        WHERE br.status = 'Pending'
    ");
    
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
