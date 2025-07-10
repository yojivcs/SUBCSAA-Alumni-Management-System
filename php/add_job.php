<?php
include 'db_connect.php';
header('Content-Type: application/json');

// Get data from request
$data = json_decode(file_get_contents('php://input'), true);

$job_title = $data['job_title'] ?? null;
$position = $data['position'] ?? null;
$deadline = $data['deadline'] ?? null;
$reference = $data['reference'] ?? null;
$phone = $data['phone'] ?? null;
$pay_scale = $data['pay_scale'] ?? null;
$description = $data['description'] ?? null;

if ($job_title && $position && $deadline && $reference && $phone) {
    $sql = "INSERT INTO jobs (job_title, position, deadline, reference, phone, pay_scale, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $job_title, $position, $deadline, $reference, $phone, $pay_scale, $description);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to add job post']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'All fields are required']);
}

$conn->close();
?>
