<?php
require_once 'config.php';

try {
    // 1. Add role column if not exists
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(20) DEFAULT 'user' AFTER password");
    
    // 2. Make YOUR specific email the Admin
    $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
    $stmt->execute(['superabdo22222@gmail.com']);

    if ($stmt->rowCount() > 0) {
        echo "<h2 style='color: green;'>✅ مبروك! الحساب (superabdo22222@gmail.com) أصبح الآن هو الأدمن.</h2>";
    } else {
        echo "<h2 style='color: orange;'>⚠️ الإيميل ده مش موجود في الداتابيز.. تأكد إنك مسجل حساب بالإيميل ده الأول.</h2>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
