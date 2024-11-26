
<?php
require_once '../includes/db.php';

$response = ['success' => false];

if (isset($_GET['crop_id'])) {
    $crop_id = intval($_GET['crop_id']);
    
    try {
        // Get common symptoms for this crop based on historical diagnoses
        $query = "SELECT DISTINCT s.id, s.name
                 FROM symptoms s
                 JOIN disease_symptoms ds ON s.id = ds.symptom_id
                 JOIN crop_diseases cd ON ds.disease_id = cd.disease_id
                 WHERE cd.crop_id = ?
                 ORDER BY s.name";
                 
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $crop_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $symptoms = [];
        while ($row = $result->fetch_assoc()) {
            $symptoms[] = intval($row['id']);
        }
        
        $response = [
            'success' => true,
            'data' => [
                'symptoms' => $symptoms
            ]
        ];
    } catch (Exception $e) {
        $response['error'] = 'Failed to fetch crop symptoms';
    }
}

header('Content-Type: application/json');
echo json_encode($response);