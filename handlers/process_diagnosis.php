<?php
session_start();
require_once '../includes/db.php';

function getSymptomId($symptom_name) {
    global $conn;
    
    // First try to find existing symptom
    $stmt = $conn->prepare("SELECT id FROM symptoms WHERE name = ?");
    $stmt->bind_param("s", $symptom_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    }
    
    // If not found, create new symptom
    $stmt = $conn->prepare("INSERT INTO symptoms (name) VALUES (?)");
    $stmt->bind_param("s", $symptom_name);
    $stmt->execute();
    
    return $stmt->insert_id;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $crop_type = $_POST['crop_type'];
    $growth_stage = $_POST['growth_stage'];
    $symptoms = implode(',', $_POST['symptoms']);
    $additional_details = $_POST['additional_details'];
    
    // Insert diagnosis into database
    $stmt = $conn->prepare("INSERT INTO diagnoses (user_id, disease_id, crop_type, growth_stage, confidence, additional_details) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissis", $user_id, $disease_id, $crop_type, $growth_stage, $confidence, $additional_details);
    
    // For demo, set default values
    $disease_id = 1; // This would normally be determined by analysis
    $confidence = 85;
    
    if ($stmt->execute()) {
        $diagnosis_id = $stmt->insert_id;
        
        // Store symptoms
        $stmt = $conn->prepare("INSERT INTO diagnosis_symptoms (diagnosis_id, symptom_id) VALUES (?, ?)");
        foreach ($_POST['symptoms'] as $symptom) {
            $symptom_id = getSymptomId($symptom); 
            $stmt->bind_param("ii", $diagnosis_id, $symptom_id);
            $stmt->execute();
        }
        
        echo json_encode(['success' => true, 'diagnosis_id' => $diagnosis_id]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
}
?>