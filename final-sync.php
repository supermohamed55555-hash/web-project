<?php
require_once 'config.php';
require_once 'includes/hospitals.php';

header('Content-Type: text/html; charset=utf-8');

try {
    // 1. Update Schema: Ensure blood_requests has hospital_id column (Already done via index.php)
    // 2. Clear and Refill Hospitals Table (Source of Truth)
    $conn->exec("DROP TABLE IF EXISTS hospitals");
    $conn->exec("CREATE TABLE hospitals (
        id INT PRIMARY KEY, 
        name_ar VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, 
        name_en VARCHAR(255), 
        city VARCHAR(100), 
        latitude DECIMAL(10, 8), 
        longitude DECIMAL(11, 8),
        address_ar TEXT
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    $hospitals = get_all_hospitals();
    $stmt = $conn->prepare("INSERT INTO hospitals (id, name_ar, name_en, city, latitude, longitude, address_ar) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($hospitals as $h) {
        $stmt->execute([$h['id'], $h['name_ar'], $h['name_en'], $h['city'], $h['lat'], $h['lng'], $h['address_ar']]);
    }

    // 3. WIPE OLD REQUESTS (To ensure only verified dynamic data exists)
    $conn->exec("TRUNCATE TABLE blood_requests");

    echo "<h2 style='color: green; font-family: sans-serif;'>✅ تمت المزامنة النهائية بنجاح!</h2>";
    echo "<ul style='font-family: sans-serif;'>
            <li>تم تحديث جدول المستشفيات بالبيانات الموثقة (Google Verified).</li>
            <li>تم مسح كل الطلبات القديمة لضمان الدقة (No Cached Data).</li>
            <li>السيستم الآن يعتمد كلياً على الـ ID الخاص بالمستشفى.</li>
          </ul>";
    echo "<p><a href='request-blood.php'>اضغط هنا لعمل أول طلب دم موثق</a></p>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
