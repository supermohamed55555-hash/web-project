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
        $message = "Please enter both email and password.";
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
            $message = "Invalid email or password.";
            $messageType = "error";
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card reveal">
        <h2>Welcome Back</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                Don't have an account? <a href="register.php" style="color: var(--primary); font-weight: 600;">Register here</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
