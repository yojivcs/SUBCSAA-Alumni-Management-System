<?php
// Include database connection
include 'db_connect.php'; // Make sure this points to your database connection file

header('Content-Type: application/json');

// Query to count total users
$sql = "SELECT COUNT(*) as total_users FROM users"; // Replace `users` with your table name
$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode(['total_users' => $data['total_users']]);
} else {
    echo json_encode(['error' => 'Failed to fetch total users']);
}

// Close the database connection
$conn->close();
?>
