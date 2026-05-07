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

<div class="container section-padding">
    <div class="reveal">
        <h2 class="section-title">User Dashboard</h2>
        <p class="section-subtitle">Welcome back, <strong><?= htmlspecialchars($user['full_name']) ?></strong>!</p>
    </div>

    <div class="footer-grid">
        <!-- Profile Card -->
        <div class="auth-card reveal" style="max-width: 100%;">
            <h3><i class="fas fa-user-circle" style="color: var(--primary);"></i> My Profile</h3>
            <hr style="margin: 1.5rem 0; opacity: 0.1;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <p><strong>Email:</strong><br> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Phone:</strong><br> <?= htmlspecialchars($user['phone']) ?></p>
                <p><strong>Blood Type:</strong><br> <span style="color: var(--primary); font-weight: 800; font-size: 1.2rem;"><?= htmlspecialchars($user['blood_type']) ?></span></p>
                <p><strong>City:</strong><br> <?= htmlspecialchars($user['city']) ?></p>
            </div>
            
            <a href="edit-profile.php" class="btn btn-outline" style="width: 100%; margin-top: 2rem; text-align: center;">Edit Profile</a>
        </div>

        <!-- Action Card -->
        <div class="auth-card reveal" style="max-width: 100%; background: var(--secondary);">
            <h3><i class="fas fa-hand-holding-heart" style="color: var(--primary);"></i> Quick Actions</h3>
            <hr style="margin: 1.5rem 0; opacity: 0.1;">
            
            <p style="margin-bottom: 1.5rem;">Need blood urgently? You can post a request that will be visible to all donors.</p>
            
            <a href="request-blood.php" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem; text-align: center;">Request Blood</a>
            <a href="search.php" class="btn btn-outline" style="width: 100%; text-align: center; background: white;">Find Donors</a>
        </div>
    </div>

    <!-- My Requests Activity -->
    <div class="auth-card reveal" style="max-width: 100%; margin-top: 2rem;">
        <h3><i class="fas fa-history" style="color: var(--primary);"></i> My Blood Requests</h3>
        <hr style="margin: 1.5rem 0; opacity: 0.1;">
        
        <?php
        $stmt = $conn->prepare("SELECT * FROM blood_requests WHERE user_id = ? ORDER BY request_date DESC");
        $stmt->execute([$user_id]);
        $requests = $stmt->fetchAll();
        
        if (count($requests) > 0): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--bg-light);">
                            <th style="padding: 10px;">Type</th>
                            <th style="padding: 10px;">Hospital</th>
                            <th style="padding: 10px;">Status</th>
                            <th style="padding: 10px;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                            <tr style="border-bottom: 1px solid var(--bg-light);">
                                <td style="padding: 10px; font-weight: bold; color: var(--primary);"><?= $req['blood_type'] ?></td>
                                <td style="padding: 10px;"><?= htmlspecialchars($req['hospital_name']) ?></td>
                                <td style="padding: 10px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; background: <?= $req['status'] == 'Pending' ? '#fff3cd' : ($req['status'] == 'Accepted' ? '#cce5ff' : '#d4edda') ?>;">
                                        <?= $req['status'] ?>
                                    </span>
                                </td>
                                <td style="padding: 10px; font-size: 0.9rem; color: var(--text-muted);"><?= date('M d, Y', strtotime($req['request_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-muted); padding: 2rem;">You haven't made any requests yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
