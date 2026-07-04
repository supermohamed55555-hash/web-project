<?php
function logAction($pdo, $action, $details = null) {
    $userId = $_SESSION['user_id'] ?? null;
    $userEmail = $_SESSION['email'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    $stmt = $pdo->prepare("
        INSERT INTO audit_logs (user_id, user_email, action, details, ip_address)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$userId, $userEmail, $action, $details, $ip]);
}
