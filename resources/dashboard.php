<?php
session_start();
require_once "../includes/db.php";

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Doctor - Farmer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <a href="dashboard.php" class="text-decoration-none">
                    <i class="bi bi-tree-fill"></i>
                    <h2 class="mb-0">Crop Doctor</h2>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
                <a href="diagnosis.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'diagnosis.php' ? 'active' : ''; ?>">
                    <i class="bi bi-clipboard-pulse"></i> New Diagnosis
                </a>
                <a href="history.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'history.php' ? 'active' : ''; ?>">
                    <i class="bi bi-clock-history"></i> History
                </a>
                <a href="profile.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : ''; ?>">
                    <i class="bi bi-person-fill"></i> Profile
                </a>
                <button class="nav-item logout border-0 w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="dashboard-header">
                <div>
                    <h1 class="mb-2">Dashboard</h1>
                    <p class="text-muted mb-0">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                </div>
                <button class="btn btn-outline-success diag" style="margin:10px">
                    <i class="bi bi-plus-circle me-2"></i> New Diagnosis
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div class="stat-details">
                        <h3>Total Diagnoses</h3>
                        <div class="value">
                            <?php
                            // Your existing database query
                            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM diagnoses WHERE user_id = ?");
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $total = $stmt->get_result()->fetch_assoc()['total'];
                            echo $total;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="stat-details">
                        <h3>Success Rate</h3>
                        <div class="value">
                            <?php
                            $stmt = $conn->prepare("SELECT AVG(confidence) as avg_confidence FROM diagnoses WHERE user_id = ?");
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $avg = round($stmt->get_result()->fetch_assoc()['avg_confidence'], 1);
                            echo $avg . "%";
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Diagnoses -->
            <div class="recent-diagnoses">
                <h2 class="mb-4">Recent Diagnoses</h2>
                <?php
                $stmt = $conn->prepare("SELECT d.*, dis.name as disease_name 
                                        FROM diagnoses d 
                                        JOIN diseases dis ON d.disease_id = dis.id 
                                        WHERE d.user_id = ? 
                                        ORDER BY d.created_at DESC LIMIT 5");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $confidence = $row['confidence'];
                    $confidenceClass = $confidence > 80 ? 'confidence-high' : 
                                       ($confidence > 50 ? 'confidence-medium' : 'confidence-low');
                    
                    echo "<div class='diagnosis-item'>";
                    echo "<div>";
                    echo "<h4 class='mb-2'>{$row['disease_name']}</h4>";
                    echo "<span class='confidence-badge {$confidenceClass}'>Confidence: {$row['confidence']}%</span>";
                    echo "</div>";
                    echo "<small class='text-muted'>".date('F j, Y', strtotime($row['created_at']))."</small>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.diag').addEventListener('click', function() {
            window.location.href = 'diagnosis.php';
        });

        document.querySelector('.logout').addEventListener('click', function() {
            if (confirm('Are you sure you want to logout?')) {
                fetch('../handlers/logout.php', {
                    method: 'POST',
                    credentials: 'same-origin'
                }).then(() => {
                    window.location.href = 'login.php';
                });
            }
        });

        // Add page transition effect
        document.querySelectorAll('.nav-item:not(.logout)').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.body.style.opacity = '0';
                setTimeout(() => {
                    window.location.href = this.href;
                }, 200);
            });
        });
    </script>
</body>
</html>