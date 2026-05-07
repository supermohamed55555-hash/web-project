<?php 
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { header("Location: ../index.php"); exit(); }
include '../includes/header.php';

// Handle Status Update
if (isset($_GET['id']) && isset($_GET['status'])) {
    $stmt = $conn->prepare("UPDATE blood_requests SET status = ? WHERE id = ?");
    $stmt->execute([$_GET['status'], $_GET['id']]);
    header("Location: manage-requests.php");
}

$requests = $conn->query("SELECT r.*, u.full_name as requester FROM blood_requests r JOIN users u ON r.user_id = u.id ORDER BY request_date DESC")->fetchAll();
?>

<div class="container section-padding">
    <h2>Manage Blood Requests</h2>
    <div class="auth-card reveal" style="max-width: 100%; margin-top: 2rem; overflow-x: auto;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--bg-light);">
                    <th style="padding: 10px;">Requester</th>
                    <th style="padding: 10px;">Type</th>
                    <th style="padding: 10px;">Hospital</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $r): ?>
                    <tr style="border-bottom: 1px solid var(--bg-light);">
                        <td style="padding: 10px;"><?= htmlspecialchars($r['requester']) ?></td>
                        <td style="padding: 10px; font-weight: bold; color: var(--primary);"><?= $r['blood_type'] ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($r['hospital_name']) ?></td>
                        <td style="padding: 10px;">
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; background: <?= $r['status'] == 'Pending' ? '#fff3cd' : ($r['status'] == 'Accepted' ? '#cce5ff' : '#d4edda') ?>;">
                                <?= $r['status'] ?>
                            </span>
                        </td>
                        <td style="padding: 10px;">
                            <a href="?id=<?= $r['id'] ?>&status=Accepted" style="color: #2980b9; margin-right: 10px;">Accept</a>
                            <a href="?id=<?= $r['id'] ?>&status=Completed" style="color: #27ae60;">Complete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="dashboard.php" class="btn" style="margin-top: 2rem;">Back to Admin Panel</a>
</div>
<?php include '../includes/footer.php'; ?>
