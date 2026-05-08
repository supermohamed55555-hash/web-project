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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = $_POST['blood_type'];
    $hospital   = trim($_POST['hospital_name']);
    $city       = trim($_POST['city']);
    $msg        = trim($_POST['message']);
    $lat        = !empty($_POST['lat']) ? $_POST['lat'] : null;
    $lng        = !empty($_POST['lng']) ? $_POST['lng'] : null;
    $user_id    = $_SESSION['user_id'];

    if (empty($blood_type) || empty($hospital) || empty($city)) {
        $message = "Please fill in all required fields.";
        $messageType = "error";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO blood_requests (user_id, blood_type, hospital_name, city, message, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $blood_type, $hospital, $city, $msg, $lat, $lng]);
            
            $message = "Blood request posted successfully! <a href='map-search.php' style='color: white; text-decoration: underline;'>View it on the Map</a>";
            $messageType = "success";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $messageType = "error";
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card reveal">
        <h2>Post Blood Request</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="request-blood.php" method="POST">
            <div class="form-group">
                <label>Required Blood Type</label>
                <select name="blood_type" class="form-control" required>
                    <option value="">Select Blood Type</option>
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
                <label>Hospital Name</label>
                <input type="text" name="hospital_name" class="form-control" placeholder="e.g. City General Hospital" required>
            </div>

            <div class="form-group">
                <label>City / Area</label>
                <input type="text" name="city" class="form-control" placeholder="Where is the hospital located?" required>
            </div>

            <div class="form-group">
                <label>Additional Message (Optional)</label>
                <textarea name="message" class="form-control" rows="3" placeholder="Tell us more (e.g. Surgery date, units needed)"></textarea>
            </div>

            <!-- Hidden Location Fields -->
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Request</button>
            <a href="dashboard.php" class="btn" style="width: 100%; text-align: center; margin-top: 1rem;">Back to Dashboard</a>
        </form>
    </div>
</div>

<script>
    // Get user location when the page loads
    window.onload = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lng').value = position.coords.longitude;
                console.log("Location captured:", position.coords.latitude, position.coords.longitude);
            }, function(error) {
                console.warn("Location access denied or error:", error.message);
            });
        }
    };
</script>

<?php include 'includes/footer.php'; ?>
