<?php
require_once 'config.php';
header('Content-Type: text/html; charset=utf-8');

try {
    $conn->exec("DROP TABLE IF EXISTS hospitals");
    $conn->exec("CREATE TABLE hospitals (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        name_ar VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, 
        name_en VARCHAR(255), 
        city VARCHAR(100) DEFAULT 'Aswan',
        latitude DECIMAL(10, 8), 
        longitude DECIMAL(11, 8)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // Corrected Precision Coordinates for Aswan Hospitals
    $hospitals = [
        ['مستشفى أسوان الجامعي', 'Aswan University Hospitals', 'Aswan', 24.0874, 32.8974],
        ['مركز مجدي يعقوب للقلب', 'Aswan Heart Centre', 'Aswan', 24.0838, 32.8864],
        ['مستشفى أسوان التخصصي', 'Aswan Specialized Hospital', 'Aswan', 24.1183, 32.9022],
        ['مستشفى المسلة التخصصي', 'El-Masala Specialized Hospital', 'Aswan', 24.0848, 32.8965],
        ['مستشفى الهلال الأحمر', 'Red Crescent Hospital', 'Aswan', 24.0905, 32.8998]
    ];

    $stmt = $conn->prepare("INSERT INTO hospitals (name_ar, name_en, city, latitude, longitude) VALUES (?, ?, ?, ?, ?)");
    foreach ($hospitals as $h) {
        $stmt->execute($h);
    }

    echo "<h2 style='color: green;'>✅ تم تصحيح الإحداثيات بدقة! جرب الآن.</h2>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
