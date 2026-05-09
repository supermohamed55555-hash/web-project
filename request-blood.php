<?php 
session_start();
require_once 'config.php';
require_once 'includes/hospitals.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';

// Fetch verified hospitals from our source of truth
$hospitals = get_all_hospitals();

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type  = $_POST['blood_type'];
    $hospital_id = (int)$_POST['hospital_id'];
    $msg         = trim($_POST['message']);
    $user_id     = $_SESSION['user_id'];

    // Verify hospital exists and get its info
    $h_info = get_hospital_by_id($hospital_id);

    if ($h_info && !empty($blood_type)) {
        $hospital_name = $h_info['name_ar'];
        $city = $h_info['city'];
        
        try {
            // Save hospital_id to link with coordinates dynamically
            $stmt = $conn->prepare("INSERT INTO blood_requests (user_id, hospital_id, blood_type, hospital_name, city, message, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
            if ($stmt->execute([$user_id, $hospital_id, $blood_type, $hospital_name, $city, $msg])) {
                $message = "تم نشر طلب التبرع بنجاح! <a href='map-view.php'>شاهده على الخريطة</a>";
                $messageType = "success";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $messageType = "error";
        }
    } else {
        $message = "يرجى اختيار فصيلة الدم والمستشفى.";
        $messageType = "error";
    }
}
?>

<div class="section-padding" dir="rtl">
    <div class="container" style="max-width: 600px;">
        <div class="auth-card reveal" style="background: var(--white); padding: 2.5rem; border-radius: 15px; box-shadow: var(--shadow); text-align: right;">
            <h2 class="text-center" style="color: var(--primary); margin-bottom: 2rem;">نشر طلب تبرع دم موثق</h2>
            
            <?php if ($message): ?>
                <div class="alert" style="padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; background: <?= $messageType == 'success' ? '#d4edda' : '#f8d7da' ?>; color: <?= $messageType == 'success' ? '#155724' : '#721c24' ?>; text-align: center;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">فصيلة الدم المطلوبة</label>
                    <select name="blood_type" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ddd;">
                        <option value="">اختر الفصيلة</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">اختر المستشفى (إحداثيات موثقة)</label>
                    <select name="hospital_id" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ddd;">
                        <option value="">-- اختر المستشفى من القائمة --</option>
                        <?php foreach ($hospitals as $h): ?>
                            <option value="<?= $h['id'] ?>"><?= htmlspecialchars($h['name_ar']) ?> (<?= $h['city'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">رسالة إضافية</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="تفاصيل الحالة أو رقم التواصل..." style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ddd;"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">نشر الطلب الآن</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
