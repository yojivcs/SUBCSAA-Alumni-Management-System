<?php
include 'db_connect.php';
header('Content-Type: application/json');

$event_id = $_POST['event_id'] ?? null;

if ($event_id) {
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to delete event']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid event ID']);
}
$conn->close();
?>
