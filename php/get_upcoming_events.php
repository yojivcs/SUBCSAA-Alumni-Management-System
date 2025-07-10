<?php
include 'db_connect.php';
header('Content-Type: application/json');

// Get the current date
$currentDate = date('Y-m-d');

// Query to fetch only upcoming events
$sql = "SELECT COUNT(*) AS upcoming_events_count FROM events WHERE date >= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentDate);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(['upcoming_events' => $row['upcoming_events_count']]);
} else {
    echo json_encode(['error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>
