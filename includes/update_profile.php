
<?php
session_start();
require_once "db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $userId = $_SESSION['user_id'];

    if (!$email) {
        $response['message'] = 'Invalid email format';
    } else {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $userId);
        
        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Profile updated successfully'
            ];
        } else {
            $response['message'] = 'Error updating profile';
        }
        $stmt->close();
    }
}

echo json_encode($response);
?>