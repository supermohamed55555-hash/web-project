<?php 
session_start();
require_once 'config.php';

// PROTECTION: If not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';

// Fetch current user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<div class="container section-padding" dir="rtl">
    <div class="reveal">
        <h2 class="section-title">لوحة التحكم</h2>
        <p class="section-subtitle">أهلاً بك مجدداً، <strong><?= htmlspecialchars($user['full_name']) ?></strong>!</p>
    </div>

    <div class="footer-grid">
        <!-- Profile Card -->
        <div class="auth-card reveal" style="max-width: 100%;">
            <h3><i class="fas fa-user-circle" style="color: var(--primary);"></i> ملفي الشخصي</h3>
            <hr style="margin: 1.5rem 0; opacity: 0.1;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: right;">
                <p><strong>البريد الإلكتروني:</strong><br> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>رقم الهاتف:</strong><br> <?= htmlspecialchars($user['phone']) ?></p>
                <p><strong>فصيلة الدم:</strong><br> <span style="color: var(--primary); font-weight: 800; font-size: 1.2rem;"><?= htmlspecialchars($user['blood_type']) ?></span></p>
                <p><strong>المدينة:</strong><br> <?= htmlspecialchars($user['city']) ?></p>
            </div>
            
            <a href="edit-profile.php" class="btn btn-outline" style="width: 100%; margin-top: 2rem; text-align: center;">تعديل الملف الشخصي</a>
        </div>

        <!-- Action Card -->
        <div class="auth-card reveal" style="max-width: 100%; background: var(--secondary);">
            <h3><i class="fas fa-hand-holding-heart" style="color: var(--primary);"></i> إجراءات سريعة</h3>
            <hr style="margin: 1.5rem 0; opacity: 0.1;">
            
            <p style="margin-bottom: 1.5rem;">هل تحتاج إلى دم بشكل عاجل؟ يمكنك نشر طلب وسيظهر لجميع المتبرعين.</p>
            
            <a href="request-blood.php" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem; text-align: center;">طلب تبرع بالدم</a>
            <a href="search.php" class="btn btn-outline" style="width: 100%; text-align: center; background: white;">البحث عن متبرعين</a>
        </div>
    </div>

    <!-- My Requests Activity -->
    <div class="auth-card reveal" style="max-width: 100%; margin-top: 2rem;">
        <h3><i class="fas fa-history" style="color: var(--primary);"></i> طلباتي السابقة</h3>
        <hr style="margin: 1.5rem 0; opacity: 0.1;">
        
        <?php
        $stmt = $conn->prepare("SELECT * FROM blood_requests WHERE user_id = ? ORDER BY request_date DESC");
        $stmt->execute([$user_id]);
        $requests = $stmt->fetchAll();
        
        if (count($requests) > 0): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: right;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--bg-light);">
                            <th style="padding: 10px;">الفصيلة</th>
                            <th style="padding: 10px;">المستشفى</th>
                            <th style="padding: 10px;">الحالة</th>
                            <th style="padding: 10px;">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                            <tr style="border-bottom: 1px solid var(--bg-light);">
                                <td style="padding: 10px; font-weight: bold; color: var(--primary);"><?= $req['blood_type'] ?></td>
                                <td style="padding: 10px;"><?= htmlspecialchars($req['hospital_name']) ?></td>
                                <td style="padding: 10px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; background: <?= $req['status'] == 'Pending' ? '#fff3cd' : ($req['status'] == 'Accepted' ? '#cce5ff' : '#d4edda') ?>;">
                                        <?= $req['status'] == 'Pending' ? 'قيد الانتظار' : ($req['status'] == 'Accepted' ? 'تم القبول' : 'مكتمل') ?>
                                    </span>
                                </td>
                                <td style="padding: 10px; font-size: 0.9rem; color: var(--text-muted);"><?= date('d/m/Y', strtotime($req['request_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-muted); padding: 2rem;">لم تقم بإرسال أي طلبات بعد.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
