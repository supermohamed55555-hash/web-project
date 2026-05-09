<?php
require_once 'config.php';

try {
    // Add created_at column to blood_requests if it doesn't exist
    $conn->exec("ALTER TABLE blood_requests ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    
    echo "<h2 style='color: green;'>✅ تم إصلاح قاعدة البيانات!</h2>";
    echo "<p><a href='admin/dashboard.php'>اضغط هنا لفتح لوحة التحكم الآن</a></p>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
