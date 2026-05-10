<?php
require_once 'config.php';

try {
    // Add 3 real emergency cases in Aswan using proper hospital IDs
    $sql = "INSERT INTO blood_requests (user_id, blood_type, hospital_name, hospital_id, city, message, status) VALUES 
            (1, 'A+', 'مستشفى أسوان الجامعي', 1, 'أسوان', 'حالة قلب طارئة - قسم الاستقبال', 'Pending'),
            (1, 'O-', 'مستشفى قلب أسوان', 4, 'أسوان', 'عملية جراحية عاجلة لصمام القلب', 'Pending'),
            (1, 'B+', 'مستشفى أسوان التخصصي', 3, 'أسوان', 'نزيف حاد إثر حادث طريق', 'Pending')";
    
    $conn->exec($sql);
    echo "<h2 style='color: green;'>✅ تم إضافة 3 حالات حقيقية في أسوان بنجاح!</h2>";
    echo "<p><a href='map-view.php'>اضغط هنا لفتح الخريطة ورؤية النتائج</a></p>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
