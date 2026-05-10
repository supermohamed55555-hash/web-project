<?php
require_once 'config.php';

try {
    // 1. The Admin Emails List
    $admin_emails = [
        'superabdo22222@gmail.com',
        'mhmhmhmhmh770@gmail.com'
    ];

    $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
    
    foreach ($admin_emails as $email) {
        $stmt->execute([$email]);
    }

    echo "<h2 style='color: green;'>✅ تم تحديث الصلاحيات بنجاح!</h2>";
    echo "<p>الإيميلات التالية أصبحت أدمن الآن (لو كانت مسجلة في الموقع):</p>";
    echo "<ul><li>superabdo22222@gmail.com</li><li>mhmhmhmhmh770@gmail.com</li></ul>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
