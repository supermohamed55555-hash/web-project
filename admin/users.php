<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$users = $conn->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المستخدمين | الإدارة</title>
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
        .role-badge { padding: 0.3rem 0.7rem; border-radius: 15px; font-size: 0.8rem; background: #eef2ff; color: #4f46e5; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="margin-bottom: 2rem; color: #e53935;">لايف ستريم - الإدارة</h2>
    <nav>
        <a href="dashboard.php" class="admin-nav-link"><i class="fas fa-home"></i> الإحصائيات</a>
        <a href="requests.php" class="admin-nav-link"><i class="fas fa-heartbeat"></i> طلبات الدم</a>
        <a href="hospitals.php" class="admin-nav-link"><i class="fas fa-hospital"></i> المستشفيات</a>
        <a href="users.php" class="admin-nav-link active"><i class="fas fa-users"></i> المستخدمين</a>
        <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 1rem 0;">
        <a href="../index.php" class="admin-nav-link"><i class="fas fa-external-link-alt"></i> عرض الموقع</a>
    </nav>
</div>

<div class="main-content">
    <h1>إدارة المستخدمين</h1>
    <p>عرض جميع المسجلين في المنصة</p>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>الاسم الكامل</th>
                    <th>البريد الإلكتروني</th>
                    <th>فصيلة الدم</th>
                    <th>المدينة</th>
                    <th>الصلاحية</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['full_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><b style="color: #e53935;"><?= $u['blood_type'] ?></b></td>
                    <td><?= htmlspecialchars($u['city']) ?></td>
                    <td><span class="role-badge"><?= $u['role'] ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
