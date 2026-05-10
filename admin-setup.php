<?php
require_once 'config.php';

try {
    // 1. The Admin Emails List
    $admin_emails = [
        'superabdo22222@gmail.com',
        'mhmhmhmhmh770@gmail.com'
    ];
    $default_password = password_hash('123456', PASSWORD_DEFAULT);

    foreach ($admin_emails as $email) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() == 0) {
            $insert = $conn->prepare("INSERT INTO users (full_name, email, password, phone, blood_type, city, role) VALUES (?, ?, ?, '01000000000', 'O+', 'Cairo', 'admin')");
            $insert->execute(["Admin User", $email, $default_password]);
        } else {
            $update = $conn->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
            $update->execute([$email]);
        }
    }

    echo "<h2 style='color: green;'>✅ تم تحديث الصلاحيات بنجاح!</h2>";
    echo "<p>الإيميلات التالية أصبحت أدمن الآن (لو كانت مسجلة في الموقع):</p>";
    echo "<ul><li>superabdo22222@gmail.com</li><li>mhmhmhmhmh770@gmail.com</li></ul>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
