<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_ar = $_POST['name_ar'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $city = $_POST['city'];

    $stmt = $conn->prepare("INSERT INTO hospitals (name_ar, city, latitude, longitude) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name_ar, $city, $lat, $lng])) {
        $message = "تم إضافة المستشفى بنجاح!";
    }
}

$hospitals = $conn->query("SELECT * FROM hospitals ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المستشفيات | الإدارة</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7fe; font-family: 'Cairo', sans-serif; display: flex; }
        .sidebar { width: 280px; height: 100vh; background: #1a1a2e; color: white; padding: 2rem; position: fixed; right: 0; }
        .main-content { margin-right: 280px; width: 100%; padding: 2rem; }
        .admin-nav-link { display: flex; align-items: center; gap: 0.8rem; color: #a0aec0; text-decoration: none; padding: 1rem; border-radius: 10px; margin-bottom: 0.5rem; transition: 0.3s; }
        .admin-nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: right; border-bottom: 1px solid #edf2f7; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 style="margin-bottom: 2rem; color: #e53935;">لايف ستريم - الإدارة</h2>
    <nav>
        <a href="dashboard.php" class="admin-nav-link"><i class="fas fa-home"></i> الإحصائيات</a>
        <a href="requests.php" class="admin-nav-link"><i class="fas fa-heartbeat"></i> طلبات الدم</a>
        <a href="hospitals.php" class="admin-nav-link active"><i class="fas fa-hospital"></i> المستشفيات</a>
        <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> المستخدمين</a>
        <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 1rem 0;">
        <a href="../index.php" class="admin-nav-link"><i class="fas fa-external-link-alt"></i> عرض الموقع</a>
    </nav>
</div>

<div class="main-content">
    <h1>إدارة المستشفيات</h1>
    
    <div class="card">
        <h3>إضافة مستشفى جديد</h3>
        <?php if ($message): ?> <p style="color: green;"><?= $message ?></p> <?php endif; ?>
        <form method="POST" class="form-grid">
            <input type="text" name="name_ar" placeholder="اسم المستشفى بالعربي" required class="form-control">
            <input type="text" name="city" placeholder="المدينة" required class="form-control">
            <input type="text" name="lat" placeholder="خط العرض (Latitude)" required class="form-control">
            <input type="text" name="lng" placeholder="خط الطول (Longitude)" required class="form-control">
            <button type="submit" class="btn btn-primary" style="grid-column: span 2;">إضافة المستشفى</button>
        </form>
    </div>

    <div class="card">
        <h3>المستشفيات المسجلة</h3>
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>المدينة</th>
                    <th>الإحداثيات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hospitals as $h): ?>
                <tr>
                    <td><?= htmlspecialchars($h['name_ar']) ?></td>
                    <td><?= htmlspecialchars($h['city']) ?></td>
                    <td><?= $h['latitude'] ?>, <?= $h['longitude'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
