<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard - Crop Doctor</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <?php include_once "../includes/header.php"; ?>

    <div class="container py-5">
        <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">New Diagnosis</h5>
                        <p class="card-text">Start a new crop disease diagnosis</p>
                        <a href="diagnosis.php" class="btn btn-primary">Start Diagnosis</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <h3>Recent Diagnoses</h3>
                <div class="diagnosis-history">
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
                        echo "<div class='diagnosis-item'>";
                        echo "<h4>{$row['disease_name']}</h4>";
                        echo "<p>Confidence: {$row['confidence']}%</p>";
                        echo "<small>".date('F j, Y', strtotime($row['created_at']))."</small>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "../includes/footer.php"; ?>
</body>
</html>