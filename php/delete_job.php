<?php
include 'db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$job_id = $data['id'] ?? null;

if ($job_id) {
    $sql = "DELETE FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $job_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to delete job post']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid job ID']);
}

$conn->close();
?>
