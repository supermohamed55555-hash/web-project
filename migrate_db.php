<?php
require_once 'config.php';

try {
    $conn->exec("ALTER TABLE blood_requests ADD COLUMN latitude DECIMAL(10, 8), ADD COLUMN longitude DECIMAL(11, 8)");
    echo "Database updated successfully: Added latitude and longitude columns.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Columns already exist.\n";
    } else {
        echo "Error updating database: " . $e->getMessage() . "\n";
    }
}
?>
