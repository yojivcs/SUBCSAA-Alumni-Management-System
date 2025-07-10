<?php
session_start();
include 'db_connect.php'; // Include your database connection file

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Fetch the logged-in user's name
$username = $_SESSION['username'];
$sql = "SELECT full_name FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode(['full_name' => $data['full_name']]);
} else {
    echo json_encode(['error' => 'User not found']);
}

// Close connection
$stmt->close();
$conn->close();
?>
