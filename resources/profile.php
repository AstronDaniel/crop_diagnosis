<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch total diagnoses
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM diagnoses WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

// Fetch average confidence (success rate)
$stmt = $conn->prepare("SELECT AVG(confidence) as avg_confidence FROM diagnoses WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$avg = round($stmt->get_result()->fetch_assoc()['avg_confidence'], 1);
if (is_null($avg)) $avg = 0; // Handle case when there are no diagnoses
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Crop Doctor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/profile.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Use the same sidebar structure from dashboard.php -->
        <div class="sidebar">
            <!-- Copy the entire sidebar content from dashboard.php -->
            <div class="sidebar-logo">
                <i class="bi bi-tree-fill"></i>
                <h2 class="mb-0">Crop Doctor</h2>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
                <a href="diagnosis.php" class="nav-item">
                    <i class="bi bi-clipboard-pulse"></i> Diagnose
                </a>
                <a href="profile.php" class="nav-item active">
                    <i class="bi bi-person-fill"></i> Profile
                </a>
                <a href="logout.php" class="nav-item">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-cover"></div>
                    <div class="profile-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                    <p class="text-muted">Farmer</p>
                </div>

                <div class="profile-content">
                    <div class="profile-section">
                        <h3>Personal Information</h3>
                        <form id="profile-form" class="profile-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="profile-section">
                        <h3>Security</h3>
                        <form id="password-form" class="password-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="profile-section">
                        <h3>Account Statistics</h3>
                        <div class="stats-container">
                            <div class="stat-item">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Total Diagnoses</h4>
                                <p class="stat-value"><?php echo $total; ?></p>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-graph-up"></i>
                                <h4>Success Rate</h4>
                                <p class="stat-value"><?php echo $avg; ?>%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/profile.js"></script>
</body>
</html>
