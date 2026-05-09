<?php 
session_start();
require_once 'config.php';
include 'includes/header.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "يرجى إدخال البريد الإلكتروني وكلمة المرور.";
        $messageType = "error";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];
            
            header("Location: index.php");
            exit();
        } else {
            $message = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
            $messageType = "error";
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card reveal">
        <h2>مرحباً بعودتك</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
            </div>
            
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور الخاصة بك" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">تسجيل الدخول</button>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                ليس لديك حساب؟ <a href="register.php" style="color: var(--primary); font-weight: 600;">سجل الآن من هنا</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
