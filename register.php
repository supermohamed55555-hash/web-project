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
        $message = "Please fill in all required fields.";
        $messageType = "error";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $message = "This email is already registered.";
            $messageType = "error";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $sql = "INSERT INTO users (full_name, email, password, phone, blood_type, city) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$full_name, $email, $hashed_password, $phone, $blood_type, $city]);
                
                $message = "Registration successful! You can now login.";
                $messageType = "success";
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card reveal">
        <h2>Join LifeStream</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="e.g. 01012345678" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Blood Type</label>
                    <select name="blood_type" class="form-control" required>
                        <option value="">Select</option>
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
                    <label>City</label>
                    <input type="text" name="city" class="form-control" placeholder="Your City" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Create Account</button>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
                Already have an account? <a href="login.php" style="color: var(--primary); font-weight: 600;">Login here</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
