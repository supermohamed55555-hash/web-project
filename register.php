<?php 
require_once 'config.php';
include 'includes/header.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $phone     = trim($_POST['phone']);
    $blood_type= $_POST['blood_type'];
    $city      = trim($_POST['city']);

    // Simple Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $message = "يرجى ملء جميع الحقول المطلوبة.";
        $messageType = "error";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $message = "هذا البريد الإلكتروني مسجل بالفعل.";
            $messageType = "error";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $sql = "INSERT INTO users (full_name, email, password, phone, blood_type, city) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$full_name, $email, $hashed_password, $phone, $blood_type, $city]);
                
                $message = "تم التسجيل بنجاح! يمكنك الآن تسجيل الدخول.";
                $messageType = "success";
            } catch (PDOException $e) {
                $message = "خطأ: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card reveal">
        <h2>انضم إلى لايف ستريم</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label>الاسم الكامل</label>
                <input type="text" name="full_name" class="form-control" placeholder="أدخل اسمك بالكامل" required>
            </div>
            
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
            </div>
            
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="6 أحرف على الأقل" required>
            </div>

            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" placeholder="مثال: 01012345678" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>فصيلة الدم</label>
                    <select name="blood_type" class="form-control" required>
                        <option value="">اختر</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>المدينة</label>
                    <input type="text" name="city" class="form-control" placeholder="مدينتك" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">إنشاء حساب</button>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                لديك حساب بالفعل؟ <a href="login.php" style="color: var(--primary); font-weight: 600;">سجل دخول من هنا</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
