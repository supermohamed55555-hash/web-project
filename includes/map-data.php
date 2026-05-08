<?php
require_once '../config.php';

header('Content-Type: application/json');

try {
try {
    // 1. Fetch Blood Requests (Public Data)
    $stmt1 = $conn->prepare("SELECT br.*, u.full_name as patient_name, 'request' as type 
                            FROM blood_requests br 
                            JOIN users u ON br.user_id = u.id 
                            WHERE br.status = 'Pending'");
    $stmt1->execute();
    $requests = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Note: Donors are NOT returned here to protect privacy.
    // Matching is done internally on the search page.

    echo json_encode([
        'status' => 'success',
        'requests' => $requests
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
