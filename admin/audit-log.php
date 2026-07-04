<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$audit_logs = $conn->query("SELECT * FROM audit_logs ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سجل العمليات | الإدارة</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7fe; font-family: 'Cairo', sans-serif; display: flex; }
        .sidebar { width: 280px; height: 100vh; background: #1a1a2e; color: white; padding: 2rem; position: fixed; right: 0; }
        .main-content { margin-right: 280px; width: 100%; padding: 2rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.8rem; color: #a0aec0; text-decoration: none; padding: 1rem; border-radius: 10px; margin-bottom: 0.5rem; transition: 0.3s; }
        .admin-nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: right; border-bottom: 1px solid #edf2f7; }
        .action-badge { padding: 0.3rem 0.7rem; border-radius: 15px; font-size: 0.8rem; font-weight: bold; }
        .badge-login { background: #e0f2fe; color: #0369a1; }
        .badge-login-failed { background: #fee2e2; color: #b91c1c; }
        .badge-register { background: #dcfce7; color: #15803d; }
        .badge-blood-request { background: #fef3c7; color: #b45309; }
        .badge-logout { background: #f3f4f6; color: #4b5563; }
        .badge-default { background: #f3f4f6; color: #1f2937; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="margin-bottom: 2rem; color: #e53935;">لايف ستريم - الإدارة</h2>
    <nav>
        <a href="dashboard.php" class="admin-nav-link"><i class="fas fa-home"></i> الإحصائيات</a>
        <a href="requests.php" class="admin-nav-link"><i class="fas fa-heartbeat"></i> طلبات الدم</a>
        <a href="hospitals.php" class="admin-nav-link"><i class="fas fa-hospital"></i> المستشفيات</a>
        <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> المستخدمين</a>
        <a href="audit-log.php" class="admin-nav-link active"><i class="fas fa-history"></i> سجل العمليات</a>
        <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 1rem 0;">
        <a href="../index.php" class="admin-nav-link"><i class="fas fa-external-link-alt"></i> عرض الموقع</a>
    </nav>
</div>

<div class="main-content">
    <h1>سجل العمليات (Audit Log)</h1>
    <p>مراقبة وتتبع العمليات الهامة التي تمت في النظام</p>

    <div class="card" style="margin-top: 2rem; overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>التاريخ والوقت</th>
                    <th>البريد الإلكتروني</th>
                    <th>العملية</th>
                    <th>التفاصيل</th>
                    <th>عنوان IP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($audit_logs as $log): 
                    $badgeClass = 'badge-default';
                    switch ($log['action']) {
                        case 'LOGIN':
                            $badgeClass = 'badge-login';
                            break;
                        case 'LOGIN_FAILED':
                            $badgeClass = 'badge-login-failed';
                            break;
                        case 'REGISTER':
                            $badgeClass = 'badge-register';
                            break;
                        case 'BLOOD_REQUEST':
                            $badgeClass = 'badge-blood-request';
                            break;
                        case 'LOGOUT':
                            $badgeClass = 'badge-logout';
                            break;
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($log['created_at']) ?></td>
                    <td><?= htmlspecialchars($log['user_email'] ?? 'غير مسجل') ?></td>
                    <td><span class="action-badge <?= $badgeClass ?>"><?= htmlspecialchars($log['action']) ?></span></td>
                    <td><?= htmlspecialchars($log['details']) ?></td>
                    <td><?= htmlspecialchars($log['ip_address'] ?? 'N/A') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
