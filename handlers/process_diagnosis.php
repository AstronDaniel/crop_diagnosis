<?php
// Prevent any output before JSON response
ob_clean();

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

// Remove this function since we already have the ID
function getCropId($crop_id) {
    return intval($crop_id);
}

function determineMostLikelyDisease($crop_id, $symptom_ids) {
    global $conn;
    
    $query = "
        SELECT 
            d.id,
            d.name,
            COUNT(DISTINCT ds.symptom_id) as matching_symptoms,
            (
                SELECT COUNT(DISTINCT symptom_id) 
                FROM disease_symptoms 
                WHERE disease_id = d.id
            ) as total_symptoms,
            GROUP_CONCAT(DISTINCT s.name) as matched_symptom_names
        FROM diseases d
        JOIN crop_diseases cd ON d.id = cd.disease_id
        JOIN disease_symptoms ds ON d.id = ds.disease_id
        JOIN symptoms s ON ds.symptom_id = s.id
        WHERE cd.crop_id = ? 
        AND ds.symptom_id IN (" . str_repeat('?,', count($symptom_ids) - 1) . "?)
        GROUP BY d.id, d.name
        HAVING matching_symptoms > 0
        ORDER BY (matching_symptoms / total_symptoms) DESC, matching_symptoms ";
    
    // Debug log
    error_log("Symptom IDs: " . print_r($symptom_ids, true));
    
    $stmt = $conn->prepare($query);
    $params = array_merge([$crop_id], $symptom_ids);
    $stmt->bind_param(str_repeat('i', count($params)), ...$params);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $matches = [];
    
    while ($row = $result->fetch_assoc()) {
        $confidence = round(($row['matching_symptoms'] / $row['total_symptoms']) * 100);
        $matches[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'confidence' => $confidence,
            'matched_symptoms' => explode(',', $row['matched_symptom_names']),
            'matching_count' => $row['matching_symptoms'],
            'total_count' => $row['total_symptoms']
        ];
        // Debug log each match
        error_log("Disease match: " . print_r($row, true));
    }
    
    return $matches;
}

function getSymptomName($symptom_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT name FROM symptoms WHERE id = ?");
    $stmt->bind_param("i", $symptom_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['name'];
    }
    return '';
}

function getRecommendations($disease_id) {
    global $conn;
    
    $query = "SELECT recommendation, type 
              FROM recommendations 
              WHERE disease_id = ?
              ORDER BY priority ASC, type";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $disease_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $recommendations = [
        'Prevention' => [],
        'Treatment' => [],
        'Management' => []
    ];
    
    while ($row = $result->fetch_assoc()) {
        $recommendations[$row['type']][] = $row['recommendation'];
    }
    
    // If no recommendations found, provide defaults
    if (empty($recommendations['Treatment']) && 
        empty($recommendations['Prevention']) && 
        empty($recommendations['Management'])) {
        return [
            "Monitor the affected areas closely",
            "Ensure proper irrigation",
            "Maintain good air circulation",
            "Consult with a local agricultural expert"
        ];
    }
    
    // Flatten and return recommendations in priority order
    return array_merge(
        $recommendations['Prevention'],
        $recommendations['Treatment'],
        $recommendations['Management']
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    // Debug information to log file instead of output
    error_log("POST Data: " . print_r($_POST, true));
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        exit;
    }

    try {
        $user_id = $_SESSION['user_id'];
        $crop_id = intval($_POST['crop_type']);
        $growth_stage = intval($_POST['growth_stage']);
        $symptoms = array_map('intval', $_POST['symptoms']);
        $additional_details = $_POST['additional_details'];
        
        // Basic validation
        if (empty($crop_id) || empty($growth_stage) || empty($symptoms)) {
            throw new Exception('Missing required fields');
        }

        if (!$crop_id) {
            throw new Exception('Invalid crop ID');
        }

        // Determine most likely disease based on symptoms
        $diseases = determineMostLikelyDisease($crop_id, $symptoms);
        
        if (!empty($diseases)) {
            // Get the highest confidence score
            $maxConfidence = max(array_column($diseases, 'confidence'));
            
            // Get all diseases with confidence within 20% of max
            $threshold = $maxConfidence - 20;
            $bestMatches = array_filter($diseases, function($disease) use ($threshold) {
                return $disease['confidence'] >= $threshold;
            });

            // Sort by confidence
            usort($bestMatches, function($a, $b) {
                return $b['confidence'] - $a['confidence'];
            });

            $primaryDisease = reset($bestMatches);
            
            // Debug logging
            error_log("All matches: " . print_r($diseases, true));
            error_log("Best matches: " . print_r($bestMatches, true));
            error_log("Primary Disease: " . print_r($primaryDisease, true));
            
            // Create diagnosis record
            $stmt = $conn->prepare("INSERT INTO diagnoses (user_id, crop_id, disease_id, growth_stage, confidence, additional_details) VALUES (?, ?, ?, ?, ?, ?)");
            $disease_id = $primaryDisease['id']; // Ensure we have the ID
            
            if (!$disease_id) {
                throw new Exception('Invalid disease ID');
            }
            
            $stmt->bind_param("iiisis", $user_id, $crop_id, $disease_id, $growth_stage, $primaryDisease['confidence'], $additional_details);
            
            if (!$stmt->execute()) {
                throw new Exception('Failed to save diagnosis: ' . $stmt->error);
            }

            $diagnosis_id = $stmt->insert_id;

            // Store symptoms
            $stmt = $conn->prepare("INSERT INTO diagnosis_symptoms (diagnosis_id, symptom_id) VALUES (?, ?)");
            foreach ($symptoms as $symptom_id) {
                $stmt->bind_param("ii", $diagnosis_id, $symptom_id);
                if (!$stmt->execute()) {
                    throw new Exception('Failed to save symptoms: ' . $stmt->error);
                }
            }

            echo json_encode([
                'success' => true,
                'diagnosis_id' => $diagnosis_id,
                'disease' => $primaryDisease,  // Changed from diseases array to single disease object
                'confidence' => $primaryDisease['confidence'],
                'matched_symptoms' => $primaryDisease['matched_symptoms'],
                'severity' => calculateSeverity($symptoms),  // Add severity calculation
                'recommendations' => getRecommendations($disease_id)  // Add recommendations
            ]);
        } else {
            // Get the ID of the "Unknown Condition" disease
            $stmt = $conn->prepare("SELECT id FROM diseases WHERE name = 'Unknown Condition' LIMIT 1");
            $stmt->execute();
            $unknown_disease = $stmt->get_result()->fetch_assoc();
            $unknown_disease_id = $unknown_disease['id'];

            // For unknown conditions, create diagnosis with Unknown Disease ID
            $stmt = $conn->prepare("INSERT INTO diagnoses (user_id, crop_id, disease_id, growth_stage, confidence, additional_details) VALUES (?, ?, ?, ?, 0, ?)");
            $stmt->bind_param("iiiss", $user_id, $crop_id, $unknown_disease_id, $growth_stage, $additional_details);
            
            if (!$stmt->execute()) {
                throw new Exception('Failed to save unidentified diagnosis: ' . $stmt->error);
            }

            $diagnosis_id = $stmt->insert_id;

            // Store symptoms
            $stmt = $conn->prepare("INSERT INTO diagnosis_symptoms (diagnosis_id, symptom_id) VALUES (?, ?)");
            foreach ($symptoms as $symptom_id) {
                $stmt->bind_param("ii", $diagnosis_id, $symptom_id);
                if (!$stmt->execute()) {
                    throw new Exception('Failed to save symptoms: ' . $stmt->error);
                }
            }

            echo json_encode([
                'success' => true,
                'diagnosis_id' => $diagnosis_id,
                'disease' => [
                    'id' => $unknown_disease_id,
                    'name' => 'Unknown Condition',
                    'confidence' => 0,
                    'matched_symptoms' => [],
                    'message' => 'Based on the provided symptoms, we cannot make a definitive diagnosis. Please consult with an agricultural expert for a more detailed assessment.'
                ],
                'severity' => 'Unknown',
                'recommendations' => [
                    "Consult with a local agricultural expert for proper diagnosis",
                    "Document any changes in symptoms",
                    "Take clear photos of affected areas",
                    "Monitor the affected plants closely"
                ]
            ]);
        }
        
    } catch (Exception $e) {
        error_log("Diagnosis Error: " . $e->getMessage());
        echo json_encode([
            'success' => false, 
            'error' => $e->getMessage(),
            'debug' => [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ]);
    }
    exit;
}

function calculateSeverity($symptoms) {
    return count($symptoms) > 3 ? 'High' : 'Moderate';
}
?>