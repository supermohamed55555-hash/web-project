<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$total_requests = $conn->query("SELECT COUNT(*) FROM blood_requests")->fetchColumn();
$pending_requests = $conn->query("SELECT COUNT(*) FROM blood_requests WHERE status = 'Pending'")->fetchColumn();
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_hospitals = $conn->query("SELECT COUNT(*) FROM hospitals")->fetchColumn();

$recent_stmt = $conn->query("SELECT br.*, u.full_name FROM blood_requests br JOIN users u ON br.user_id = u.id ORDER BY br.created_at DESC LIMIT 5");
$recent_requests = $recent_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم | لايف ستريم</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #1a1a2e; --accent: #e53935; }
        body { background: #f4f7fe; font-family: 'Inter', 'Cairo', sans-serif; display: flex; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); color: white; padding: 2rem; position: fixed; right: 0; top: 0; }
        .main-content { margin-right: 280px; width: 100%; padding: 2rem; }
        .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.8rem; color: #a0aec0; text-decoration: none; padding: 1rem; border-radius: 10px; margin-bottom: 0.5rem; transition: 0.3s; }
        .admin-nav-link:hover, .admin-nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .table-card { background: white; padding: 1.5rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: right; border-bottom: 1px solid #edf2f7; }
        .badge { padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; }
        .badge-pending { background: #fff5f5; color: #e53935; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="margin-bottom: 2rem; color: var(--accent);">لايف ستريم - الإدارة</h2>
    <nav>
        <a href="dashboard.php" class="admin-nav-link active"><i class="fas fa-home"></i> الإحصائيات</a>
        <a href="requests.php" class="admin-nav-link"><i class="fas fa-heartbeat"></i> طلبات الدم</a>
        <a href="hospitals.php" class="admin-nav-link"><i class="fas fa-hospital"></i> المستشفيات</a>
        <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> المستخدمين</a>
        <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 1rem 0;">
        <a href="../index.php" class="admin-nav-link"><i class="fas fa-external-link-alt"></i> عرض الموقع</a>
        <a href="../logout.php" class="admin-nav-link" style="color: #fc8181;"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
    </nav>
</div>

<div class="main-content">
    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>لوحة التحكم الأساسية</h1>
        <div style="background: white; padding: 0.5rem 1rem; border-radius: 10px;">أهلاً بك، <b>الأدمن</b></div>
    </header>

    <div class="grid-stats">
        <div class="stat-card">
            <div style="background: #eef2ff; color: #4f46e5; padding: 1rem; border-radius: 10px;"><i class="fas fa-users"></i></div>
            <div><p style="color: #718096; margin: 0;">إجمالي المستخدمين</p><h3><?= $total_users ?></h3></div>
        </div>
        <div class="stat-card">
            <div style="background: #fff5f5; color: #e53935; padding: 1rem; border-radius: 10px;"><i class="fas fa-tint"></i></div>
            <div><p style="color: #718096; margin: 0;">طلبات الدم</p><h3><?= $total_requests ?></h3></div>
        </div>
        <div class="stat-card">
            <div style="background: #fffaf0; color: #d69e2e; padding: 1rem; border-radius: 10px;"><i class="fas fa-clock"></i></div>
            <div><p style="color: #718096; margin: 0;">طلبات معلقة</p><h3><?= $pending_requests ?></h3></div>
        </div>
        <div class="stat-card">
            <div style="background: #f0fff4; color: #38a169; padding: 1rem; border-radius: 10px;"><i class="fas fa-hospital"></i></div>
            <div><p style="color: #718096; margin: 0;">المستشفيات</p><h3><?= $total_hospitals ?></h3></div>
        </div>
    </div>

    <div class="table-card">
        <h3>أحدث طلبات الدم</h3>
        <table>
            <thead>
                <tr>
                    <th>المريض</th>
                    <th>الفصيلة</th>
                    <th>المستشفى</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_requests as $req): ?>
                <tr>
                    <td><?= htmlspecialchars($req['full_name']) ?></td>
                    <td><b style="color: var(--accent);"><?= $req['blood_type'] ?></b></td>
                    <td><?= htmlspecialchars($req['hospital_name']) ?></td>
                    <td><?= date('Y-m-d', strtotime($req['created_at'])) ?></td>
                    <td><span class="badge badge-pending"><?= $req['status'] ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
