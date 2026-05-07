<?php 
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { header("Location: ../index.php"); exit(); }
include '../includes/header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage-users.php?msg=deleted");
}

$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<div class="container section-padding">
    <h2>Manage Users</h2>
    <div class="auth-card reveal" style="max-width: 100%; margin-top: 2rem; overflow-x: auto;">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--bg-light);">
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Email</th>
                    <th style="padding: 10px;">Blood Type</th>
                    <th style="padding: 10px;">Role</th>
                    <th style="padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr style="border-bottom: 1px solid var(--bg-light);">
                        <td style="padding: 10px;"><?= htmlspecialchars($u['full_name']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($u['email']) ?></td>
                        <td style="padding: 10px; font-weight: bold; color: var(--primary);"><?= $u['blood_type'] ?></td>
                        <td style="padding: 10px;"><?= $u['role'] ?></td>
                        <td style="padding: 10px;">
                            <?php if ($u['role'] != 'admin'): ?>
                                <a href="?delete=<?= $u['id'] ?>" style="color: var(--primary);" onclick="return confirm('Delete user?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="dashboard.php" class="btn" style="margin-top: 2rem;">Back to Admin Panel</a>
</div>
<?php include '../includes/footer.php'; ?>
