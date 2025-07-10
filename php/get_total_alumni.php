<?php
include 'db_connect.php'; // Ensure your database connection file is included

header('Content-Type: application/json');

// Query to count total alumni
$sql = "SELECT COUNT(*) AS total_alumni FROM users WHERE role = 'alumni'";
$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode(['total_alumni' => $data['total_alumni']]);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
