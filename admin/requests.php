<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle Actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'delete') {
        $conn->prepare("DELETE FROM blood_requests WHERE id = ?")->execute([$id]);
    } elseif ($_GET['action'] === 'complete') {
        $conn->prepare("UPDATE blood_requests SET status = 'Completed' WHERE id = ?")->execute([$id]);
    }
    header("Location: requests.php");
    exit();
}

$requests = $conn->query("SELECT br.*, u.full_name FROM blood_requests br JOIN users u ON br.user_id = u.id ORDER BY br.created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الطلبات | الإدارة</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #1a1a2e; --accent: #e53935; }
        body { background: #f4f7fe; font-family: 'Cairo', sans-serif; display: flex; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); color: white; padding: 2rem; position: fixed; right: 0; top: 0; }
        .main-content { margin-right: 280px; width: 100%; padding: 2rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.8rem; color: #a0aec0; text-decoration: none; padding: 1rem; border-radius: 10px; margin-bottom: 0.5rem; transition: 0.3s; }
        .admin-nav-link:hover, .admin-nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { background: white; padding: 1.5rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: right; border-bottom: 1px solid #edf2f7; }
        .btn-sm { padding: 0.4rem 0.8rem; border-radius: 8px; text-decoration: none; font-size: 0.85rem; margin-left: 5px; cursor: pointer; }
        .btn-complete { background: #f0fff4; color: #38a169; border: 1px solid #38a169; }
        .btn-delete { background: #fff5f5; color: #e53935; border: 1px solid #e53935; }
        .badge { padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; }
        .badge-pending { background: #fff5f5; color: #e53935; }
        .badge-completed { background: #f0fff4; color: #38a169; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="margin-bottom: 2rem; color: var(--accent);">لايف ستريم - الإدارة</h2>
    <nav>
        <a href="dashboard.php" class="admin-nav-link"><i class="fas fa-home"></i> الإحصائيات</a>
        <a href="requests.php" class="admin-nav-link active"><i class="fas fa-heartbeat"></i> طلبات الدم</a>
        <a href="hospitals.php" class="admin-nav-link"><i class="fas fa-hospital"></i> المستشفيات</a>
        <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> المستخدمين</a>
        <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 1rem 0;">
        <a href="../index.php" class="admin-nav-link"><i class="fas fa-external-link-alt"></i> عرض الموقع</a>
        <a href="../logout.php" class="admin-nav-link" style="color: #fc8181;"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
    </nav>
</div>

<div class="main-content">
    <h1>إدارة طلبات الدم</h1>
    <p>يمكنك حذف الطلبات أو تغيير حالتها لمكتملة لتختفي من الخريطة</p>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>المريض</th>
                    <th>الفصيلة</th>
                    <th>المستشفى</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $req): ?>
                <tr>
                    <td><?= htmlspecialchars($req['full_name']) ?></td>
                    <td><b style="color: var(--accent);"><?= $req['blood_type'] ?></b></td>
                    <td><?= htmlspecialchars($req['hospital_name']) ?></td>
                    <td>
                        <span class="badge <?= $req['status'] == 'Pending' ? 'badge-pending' : 'badge-completed' ?>">
                            <?= $req['status'] == 'Pending' ? 'معلق' : 'مكتمل' ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($req['created_at'])) ?></td>
                    <td>
                        <?php if ($req['status'] == 'Pending'): ?>
                            <a href="?action=complete&id=<?= $req['id'] ?>" class="btn-sm btn-complete" onclick="return confirm('هل اكتملت هذه الحالة؟')">إتمام</a>
                        <?php endif; ?>
                        <a href="?action=delete&id=<?= $req['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
