<?php
include 'db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? null;

if ($user_id) {
    error_log("User ID received: " . $user_id); // Debug log

    // Validate user ID exists before updating
    $checkUser = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $checkUser->bind_param('i', $user_id);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows === 0) {
        echo json_encode(['error' => 'User ID not found']);
        exit;
    }

    // Proceed to update the role
    $sql = "UPDATE users SET role = 'alumni' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to approve user']);
    }

    $stmt->close();
    $checkUser->close();
} else {
    error_log("Invalid user ID received: " . print_r($data, true)); // Debug log
    echo json_encode(['error' => 'Invalid user ID']);
}

$conn->close();
?>
