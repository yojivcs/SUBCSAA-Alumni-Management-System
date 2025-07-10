<?php
include 'db_connect.php'; // Database connection
header('Content-Type: application/json');

// Collect input data from the POST request
$title = $_POST['title'] ?? null;
$description = $_POST['description'] ?? null;
$event_date = $_POST['event_date'] ?? null;
$location = $_POST['location'] ?? null;
$status = $_POST['status'] ?? 'upcoming'; // Default to 'upcoming'

// Check if all required fields are present
if ($title && $description && $event_date && $location) {
    // Prepare SQL query to insert the event
    $sql = "INSERT INTO events (title, description, date, location, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $title, $description, $event_date, $location, $status);

    if ($stmt->execute()) {
        // Event added successfully
        echo json_encode(['success' => true]);
    } else {
        // SQL error occurred
        echo json_encode(['error' => 'Failed to add event: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    // Missing required fields
    echo json_encode(['error' => 'All fields are required']);
}

$conn->close(); // Close the database connection
?>
