<?php 
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';

$message = "";
$messageType = "";

// The "Fixed" Hospital List for Aswan
$hospitals = [
    ['name' => 'مستشفى حميات أسوان (المسلة)', 'lat' => 24.0845, 'lng' => 32.8988],
    ['name' => 'مستشفى أسوان الجامعي', 'lat' => 24.0881, 'lng' => 32.8997],
    ['name' => 'مركز مجدي يعقوب للقلب', 'lat' => 24.0883, 'lng' => 32.8990],
    ['name' => 'مستشفى أسوان التخصصي', 'lat' => 24.1166, 'lng' => 32.9015],
    ['name' => 'مستشفى الهلال الأحمر', 'lat' => 24.0874, 'lng' => 32.9021]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = $_POST['blood_type'];
    $hospital_index = $_POST['hospital_index'];
    $msg        = trim($_POST['message']);
    $user_id    = $_SESSION['user_id'];

    if (isset($hospitals[$hospital_index])) {
        $h_info = $hospitals[$hospital_index];
        $hospital_name = $h_info['name'];
        $latitude = $h_info['lat'];
        $longitude = $h_info['lng'];
        $city = "Aswan";

        try {
            $stmt = $conn->prepare("INSERT INTO blood_requests (user_id, blood_type, hospital_name, city, message, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $blood_type, $hospital_name, $city, $msg, $latitude, $longitude])) {
                $message = "تم نشر الطلب بنجاح في مكان المستشفى المختار! <a href='map-view.php'>شاهده على الخريطة</a>";
                $messageType = "success";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $messageType = "error";
        }
    }
}
?>

<div class="section-padding" dir="rtl">
    <div class="container" style="max-width: 600px;">
        <div class="auth-card reveal" style="background: var(--white); padding: 2.5rem; border-radius: 15px; box-shadow: var(--shadow); text-align: right;">
            <h2 class="text-center" style="color: var(--primary); margin-bottom: 2rem;">نشر طلب تبرع عاجل</h2>
            
            <?php if ($message): ?>
                <div class="alert" style="padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; background: <?= $messageType == 'success' ? '#d4edda' : '#f8d7da' ?>; color: <?= $messageType == 'success' ? '#155724' : '#721c24' ?>; text-align: center;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; margin-bottom: 0.5rem; display: block;">فصيلة الدم المطلوبة</label>
                    <select name="blood_type" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ddd;">
                        <option value="">اختر الفصيلة</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; margin-bottom: 0.5rem; display: block;">اختر المستشفى (مكان الحالة)</label>
                    <select name="hospital_index" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ddd;">
                        <option value="">-- اختر المستشفى --</option>
                        <?php foreach ($hospitals as $index => $h): ?>
                            <option value="<?= $index ?>"><?= $h['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; margin-bottom: 0.5rem; display: block;">رسالة إضافية</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="مثال: محتاجين 3 أكياس دم فورا.." style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #ddd;"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem;">نشر الطلب الآن</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
