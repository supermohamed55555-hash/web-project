<?php
require_once 'config.php';

try {
    // Add 3 real emergency cases in Aswan
    $sql = "INSERT INTO blood_requests (user_id, blood_type, hospital_name, city, message, latitude, longitude, status) VALUES 
            (1, 'A+', 'مستشفى أسوان الجامعي', 'أسوان', 'حالة قلب طارئة - قسم الاستقبال', 24.0881, 32.8997, 'Pending'),
            (1, 'O-', 'مركز مجدي يعقوب للقلب', 'أسوان', 'عملية جراحية عاجلة لصمام القلب', 24.0883, 32.8990, 'Pending'),
            (1, 'B+', 'مستشفى أسوان التخصصي', 'أسوان', 'نزيف حاد إثر حادث طريق', 24.1166, 32.9015, 'Pending')";
    
    $conn->exec($sql);
    echo "<h2 style='color: green;'>✅ تم إضافة 3 حالات حقيقية في أسوان بنجاح!</h2>";
    echo "<p><a href='map-view.php'>اضغط هنا لفتح الخريطة ورؤية النتائج</a></p>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
