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
        ['مستشفى أسوان الجامعي', 'Aswan University Hospitals', 'Aswan', 24.0881, 32.8997],
        ['مستشفى أسوان التخصصي (العام سابقاً)', 'Aswan Specialized Hospital', 'Aswan', 24.1166, 32.9015],
        ['مستشفى المسلة التخصصي (الحميات)', 'El-Masala Specialized Hospital', 'Aswan', 24.0845, 32.8988],
        ['مستشفى الجرمانية', 'Evangelical Mission Hospital', 'Aswan', 24.0913, 32.8982],
        ['مركز مجدي يعقوب للقلب', 'Aswan Heart Centre', 'Aswan', 24.0883, 32.8990],
        ['مستشفى الهلال الأحمر', 'Red Crescent Hospital', 'Aswan', 24.0874, 32.9021],
        ['مستشفى رمد أسوان', 'Specialized Hospital of Ophthalmology', 'Aswan', 24.0878, 32.9038],
        ['مركز أورام أسوان', 'Aswan Oncology Center', 'Aswan', 24.0941, 32.8915],
        ['مستشفى الاستقبال والطوارئ', 'Emergency Hospital', 'Aswan', 24.0889, 32.8999],
        ['مستشفى التأمين الصحي بأسوان', 'Aswan Insurance Hospital', 'Aswan', 24.0855, 32.8928]
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
