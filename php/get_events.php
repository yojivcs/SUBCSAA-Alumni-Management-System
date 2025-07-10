<?php
include 'db_connect.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM events ORDER BY date DESC";
$result = $conn->query($sql);

if ($result) {
    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
