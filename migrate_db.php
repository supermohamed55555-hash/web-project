<?php
require_once 'config.php';

try {
    // Add hospital_id and coordinate columns
    $conn->exec("ALTER TABLE blood_requests 
        ADD COLUMN IF NOT EXISTS hospital_id INT DEFAULT NULL AFTER user_id,
        ADD COLUMN IF NOT EXISTS latitude DECIMAL(10, 8) DEFAULT NULL, 
        ADD COLUMN IF NOT EXISTS longitude DECIMAL(11, 8) DEFAULT NULL");
        
    echo "Database updated successfully: Added hospital_id, latitude, and longitude columns.\n";
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage() . "\n";
}
?>
