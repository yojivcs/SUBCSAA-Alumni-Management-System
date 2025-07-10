<?php
include 'db_connect.php';
header('Content-Type: application/json');

$sql = "SELECT * FROM jobs ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result) {
    $jobs = [];
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
    echo json_encode($jobs);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
