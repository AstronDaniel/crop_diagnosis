<?php
require_once '../includes/db.php';

// Remove any previous output or whitespace
ob_clean();

$response = ['success' => false];

try {
    // Check database connection
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Fetch crops with error checking
    $crops = [];
    $cropQuery = "SELECT id, name FROM crops ORDER BY name";
    $cropResult = $conn->query($cropQuery);
    
    if ($cropResult === false) {
        throw new Exception("Error fetching crops: " . $conn->error);
    }
    
    while ($row = $cropResult->fetch_assoc()) {
        $crops[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }

    // Fetch growth stages with error checking
    $growthStages = [];
    $stageQuery = "SELECT id, name FROM growth_stages ORDER BY duration_days";
    $stageResult = $conn->query($stageQuery);
    
    if ($stageResult === false) {
        throw new Exception("Error fetching growth stages: " . $conn->error);
    }
    
    while ($row = $stageResult->fetch_assoc()) {
        $growthStages[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }

    // Fetch symptoms with error checking
    $symptoms = [];
    $symptomQuery = "SELECT id, name FROM symptoms ORDER BY name";
    $symptomResult = $conn->query($symptomQuery);
    
    if ($symptomResult === false) {
        throw new Exception("Error fetching symptoms: " . $conn->error);
    }
    
    while ($row = $symptomResult->fetch_assoc()) {
        $symptoms[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }

    // Check if we got any data (updated to include growth stages)
    if (empty($crops) && empty($symptoms) && empty($growthStages)) {
        throw new Exception("No data found in the database");
    }

    $response = [
        'success' => true,
        'data' => [
            'crops' => $crops,
            'symptoms' => $symptoms,
            'growthStages' => $growthStages
        ]
    ];
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => 'Failed to fetch form data: ' . $e->getMessage(),
        'details' => [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ];
    
    // Log the error (optional)
    error_log("Form data fetch error: " . $e->getMessage());
}

// Ensure no whitespace or other output after JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;