<?php
include 'db_connect.php'; // Ensure your database connection file is included

header('Content-Type: application/json');

$sql = "SELECT COUNT(*) AS total_jobs FROM jobs"; // Replace `jobs` with your job table name
$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode(['total_jobs' => $data['total_jobs']]);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
