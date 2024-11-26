
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
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $userId = $_SESSION['user_id'];

    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (password_verify($current_password, $result['password'])) {
        // Update with new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $userId);
        
        if ($update_stmt->execute()) {
            $response = ['success' => true, 'message' => 'Password updated successfully'];
        } else {
            $response['message'] = 'Error updating password';
        }
        $update_stmt->close();
    } else {
        $response['message'] = 'Current password is incorrect';
    }
    $stmt->close();
}

echo json_encode($response);
?>