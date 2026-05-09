<?php 
session_start();
require_once 'config.php';
include 'includes/header.php';

$results = [];
$searched = false;

if (isset($_GET['blood_type']) || isset($_GET['city'])) {
    $searched = true;
    $blood_type = $_GET['blood_type'];
    $city = trim($_GET['city']);

    $query = "SELECT full_name, blood_type, city, phone FROM users WHERE role = 'user'";
    $params = [];

    if (!empty($blood_type)) {
        $query .= " AND blood_type = ?";
        $params[] = $blood_type;
    }

    if (!empty($city)) {
        $query .= " AND city LIKE ?";
        $params[] = "%$city%";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
}
?>

<div class="container section-padding" dir="rtl">
    <div class="text-center reveal">
        <h2 class="section-title">ابحث عن منقذ حياة</h2>
        <p class="section-subtitle">ابحث عن المتبرعين المتطوعين في منطقتك.</p>
    </div>

    <!-- Search Form -->
    <div class="auth-card reveal" style="max-width: 800px; margin: 0 auto 3rem;">
        <form action="search.php" method="GET" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end; text-align: right;">
            <div class="form-group" style="margin-bottom: 0;">
                <label>فصيلة الدم</label>
                <select name="blood_type" class="form-control">
                    <option value="">كل الفصائل</option>
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
            <div class="form-group" style="margin-bottom: 0;">
                <label>المدينة</label>
                <input type="text" name="city" class="form-control" placeholder="مثال: أسوان">
            </div>
            <button type="submit" class="btn btn-primary">ابحث الآن</button>
        </form>
    </div>

    <!-- Results -->
    <div class="footer-grid" style="grid-template-columns: 1fr;">
        <?php if ($searched): ?>
            <?php if (count($results) > 0): ?>
                <div class="stat-card reveal" style="text-align: center; padding: 3rem; background: rgba(76, 175, 80, 0.1); border: 2px solid #4CAF50;">
                    <i class="fas fa-check-circle fa-4x" style="color: #4CAF50; margin-bottom: 1.5rem;"></i>
                    <h3 style="font-size: 2rem; color: #2e7d32; margin-bottom: 1rem;">تم العثور على متبرعين متاحين!</h3>
                    <p style="font-size: 1.2rem; color: #444;">لقد وجدنا <strong><?= count($results) ?></strong> متبرع يطابق الفصيلة <strong><?= htmlspecialchars($blood_type ?: 'أي فصيلة') ?></strong> في <strong><?= htmlspecialchars($city ?: 'جميع المناطق') ?></strong>.</p>
                    <p style="margin-top: 2rem; font-style: italic; color: var(--text-muted);">لأسباب تتعلق بالخصوصية، يتم الاحتفاظ بتفاصيل المتبرعين آمنة. يرجى <a href="request-blood.php" style="color: var(--primary); font-weight: bold; text-decoration: underline;">نشر طلب</a> لإخطارهم.</p>
                </div>
            <?php else: ?>
                <div class="stat-card reveal" style="text-align: center; padding: 3rem; background: rgba(244, 67, 54, 0.1); border: 2px solid var(--primary);">
                    <i class="fas fa-times-circle fa-4x" style="color: var(--primary); margin-bottom: 1.5rem;"></i>
                    <h3 style="font-size: 2rem; color: #c62828; margin-bottom: 1rem;">لا يوجد متبرعون متاحون حالياً</h3>
                    <p style="font-size: 1.2rem; color: #444;">لم نتمكن من العثور على أي متبرعين يطابقون معاييرك في الوقت الحالي.</p>
                    <p style="margin-top: 2rem;"><a href="search.php" class="btn btn-outline">جرب بحثاً آخر</a></p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-muted);">
                <p>استخدم النموذج أعلاه لبدء البحث عن متبرعين.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
