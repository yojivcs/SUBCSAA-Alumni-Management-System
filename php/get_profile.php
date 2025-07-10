<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT full_name AS name, student_id AS id, graduation_year, description, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo json_encode(['error' => 'User not found']);
    exit();
}
$stmt->close();

// Fetch job experiences
$job_sql = "SELECT id, company_name, position, year_start, year_end FROM job_experience WHERE user_id = ?";
$job_stmt = $conn->prepare($job_sql);
$job_stmt->bind_param("i", $user_id);
$job_stmt->execute();
$job_result = $job_stmt->get_result();

$job_experiences = [];
while ($row = $job_result->fetch_assoc()) {
    $job_experiences[] = $row;
}
$job_stmt->close();

echo json_encode([
    'user' => $user_data,
    'job_experience' => $job_experiences
]);

$conn->close();
?>
