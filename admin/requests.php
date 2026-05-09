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
    <title>Manage Requests | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7fe; font-family: 'Inter', sans-serif; display: flex; }
        .sidebar { width: 280px; height: 100vh; background: #1a1a2e; color: white; padding: 2rem; position: fixed; right: 0; }
        .main-content { margin-right: 280px; width: 100%; padding: 2rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.8rem; color: #a0aec0; text-decoration: none; padding: 1rem; border-radius: 10px; margin-bottom: 0.5rem; transition: 0.3s; }
        .admin-nav-link:hover, .admin-nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .table-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1.2rem; text-align: right; border-bottom: 1px solid #edf2f7; }
        .btn-sm { padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.85rem; margin-left: 5px; }
        .btn-complete { background: #f0fff4; color: #38a169; border: 1px solid #38a169; }
        .btn-delete { background: #fff5f5; color: #e53935; border: 1px solid #e53935; }
        .badge { padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; }
        .badge-pending { background: #fff5f5; color: #e53935; }
        .badge-completed { background: #f0fff4; color: #38a169; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="margin-bottom: 2rem; color: #e53935;">LifeStream Admin</h2>
    <nav>
        <a href="dashboard.php" class="admin-nav-link"><i class="fas fa-home"></i> Dashboard</a>
        <a href="requests.php" class="admin-nav-link active"><i class="fas fa-heartbeat"></i> Blood Requests</a>
        <a href="hospitals.php" class="admin-nav-link"><i class="fas fa-hospital"></i> Hospitals</a>
        <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> Users</a>
        <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 1rem 0;">
        <a href="../index.php" class="admin-nav-link"><i class="fas fa-external-link-alt"></i> View Site</a>
    </nav>
</div>

<div class="main-content">
    <header style="margin-bottom: 2rem;">
        <h1>إدارة طلبات التبرع بالدم</h1>
        <p>التحكم الكامل في جميع الاستغاثات المنشورة</p>
    </header>

    <div class="table-card">
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
                    <td><b style="color: #e53935;"><?= $req['blood_type'] ?></b></td>
                    <td><?= htmlspecialchars($req['hospital_name']) ?></td>
                    <td>
                        <span class="badge <?= $req['status'] == 'Pending' ? 'badge-pending' : 'badge-completed' ?>">
                            <?= $req['status'] ?>
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
