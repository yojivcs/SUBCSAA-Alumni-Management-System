<?php
include 'db_connect.php';

header('Content-Type: application/json');

// Get the last registered user
$sql = "SELECT full_name, username, graduation_year, profile_image FROM users ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Fallback to default profile image if none is provided
    $user['profile_image'] = !empty($user['profile_image']) ? $user['profile_image'] : 'default-profile.png';
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'No users found']);
}
$conn->close();
?>
