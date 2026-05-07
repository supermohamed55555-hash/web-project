<?php 
session_start();
require_once 'config.php';
include 'includes/header.php';

$results = [];
$searched = false;

if (isset($_GET['blood_type']) || isset($_GET['city'])) {
    $searched = true;
    $blood_type = $_GET['blood_type'];
    $city = trim($_GET['city']);

    $query = "SELECT full_name, blood_type, city, phone FROM users WHERE role = 'user'";
    $params = [];

    if (!empty($blood_type)) {
        $query .= " AND blood_type = ?";
        $params[] = $blood_type;
    }

    if (!empty($city)) {
        $query .= " AND city LIKE ?";
        $params[] = "%$city%";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
}
?>

<div class="container section-padding">
    <div class="text-center reveal">
        <h2 class="section-title">Find a Life-Saver</h2>
        <p class="section-subtitle">Search for voluntary donors in your area.</p>
    </div>

    <!-- Search Form -->
    <div class="auth-card reveal" style="max-width: 800px; margin: 0 auto 3rem;">
        <form action="search.php" method="GET" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label>Blood Type</label>
                <select name="blood_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>City</label>
                <input type="text" name="city" class="form-control" placeholder="e.g. New York">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Results -->
    <div class="footer-grid">
        <?php if ($searched): ?>
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $donor): ?>
                    <div class="stat-card reveal" style="text-align: left; padding: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h3 style="font-size: 1.5rem; margin: 0; color: var(--text-dark);"><?= htmlspecialchars($donor['full_name']) ?></h3>
                                <p style="color: var(--text-muted); margin-bottom: 1rem;"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($donor['city']) ?></p>
                            </div>
                            <span style="background: var(--primary); color: white; padding: 5px 15px; border-radius: 50px; font-weight: bold; font-size: 1.2rem;">
                                <?= $donor['blood_type'] ?>
                            </span>
                        </div>
                        <a href="tel:<?= $donor['phone'] ?>" class="btn btn-outline" style="width: 100%; text-align: center; margin-top: 1rem;">
                            <i class="fas fa-phone"></i> Call Donor
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="fas fa-search fa-3x" style="color: #ddd; margin-bottom: 1rem;"></i>
                    <p>No donors found matching your criteria.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-muted);">
                <p>Use the form above to start searching for donors.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
