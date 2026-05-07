<?php 
session_start();
require_once '../config.php';

// SECURITY: Only allow Admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../includes/header.php';

// Stats
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_requests = $conn->query("SELECT COUNT(*) FROM blood_requests")->fetchColumn();

// Data for Blood Type Chart
$blood_types_query = $conn->query("SELECT blood_type, COUNT(*) as count FROM blood_requests GROUP BY blood_type ORDER BY count DESC");
$blood_data = $blood_types_query->fetchAll();

$blood_labels = [];
$blood_counts = [];
foreach ($blood_data as $row) {
    $blood_labels[] = $row['blood_type'];
    $blood_counts[] = $row['count'];
}

// Data for New Users Chart (Last 7 Days)
$users_query = $conn->query("
    SELECT DATE(created_at) as date, COUNT(*) as count 
    FROM users 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(created_at) 
    ORDER BY date ASC
");
$users_data = $users_query->fetchAll();

$user_labels = [];
$user_counts = [];

// Fill in missing days with 0
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $user_labels[] = date('M d', strtotime($date));
    $found = false;
    foreach ($users_data as $row) {
        if ($row['date'] == $date) {
            $user_counts[] = $row['count'];
            $found = true;
            break;
        }
    }
    if (!$found) $user_counts[] = 0;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container section-padding">
    <div class="reveal">
        <h2 class="section-title">Admin Console</h2>
        <p class="section-subtitle">Manage system users and monitoring activity.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card reveal">
            <h3><?= $total_users ?></h3>
            <p>Total Registered Users</p>
        </div>
        <div class="stat-card reveal">
            <h3><?= $total_requests ?></h3>
            <p>Total Blood Requests</p>
        </div>
    </div>

    <div class="footer-grid" style="margin-top: 3rem;">
        <div class="auth-card reveal" style="max-width: 100%;">
            <h3>User Management</h3>
            <p>View and manage all registered users.</p>
            <a href="manage-users.php" class="btn btn-primary" style="margin-top: 1rem; display: block; text-align: center;">Go to Users</a>
        </div>
        <div class="auth-card reveal" style="max-width: 100%;">
            <h3>Request Management</h3>
            <p>Update status of blood requests.</p>
            <a href="manage-requests.php" class="btn btn-outline" style="margin-top: 1rem; display: block; text-align: center;">Go to Requests</a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section reveal">
        <h2 class="section-title">Reports & Analytics</h2>
        <p class="section-subtitle">Visual overview of system performance.</p>
        
        <div class="charts-grid">
            <!-- Blood Type Chart -->
            <div class="chart-card">
                <h4><i class="fas fa-tint" style="color: var(--primary);"></i> Most Requested Blood Types</h4>
                <div class="chart-container">
                    <canvas id="bloodTypeChart"></canvas>
                </div>
            </div>

            <!-- New Users Chart -->
            <div class="chart-card">
                <h4><i class="fas fa-users" style="color: var(--accent);"></i> New Users (Last 7 Days)</h4>
                <div class="chart-container">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.body.classList.contains('dark-theme');
    const textColor = isDark ? '#e0e0e0' : '#2D3436';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';

    // Blood Type Chart
    const ctxBlood = document.getElementById('bloodTypeChart').getContext('2d');
    new Chart(ctxBlood, {
        type: 'bar',
        data: {
            labels: <?= json_encode($blood_labels) ?>,
            datasets: [{
                label: 'Requests',
                data: <?= json_encode($blood_counts) ?>,
                backgroundColor: 'rgba(211, 47, 47, 0.7)',
                borderColor: '#D32F2F',
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: textColor }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // User Growth Chart
    const ctxUsers = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(ctxUsers, {
        type: 'line',
        data: {
            labels: <?= json_encode($user_labels) ?>,
            datasets: [{
                label: 'New Users',
                data: <?= json_encode($user_counts) ?>,
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                borderColor: '#2ECC71',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#2ECC71'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: textColor, stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: textColor }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>
