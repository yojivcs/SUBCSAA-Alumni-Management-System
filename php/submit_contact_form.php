<?php
include 'db_connect.php'; // Include your database connection file

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phoneNumber = trim($_POST['phone_number']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(['success' => false, 'error' => 'All required fields must be filled.']);
        exit;
    }

    // Insert into the database
    $sql = "INSERT INTO contact_form (first_name, last_name, email, phone_number, subject, message) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phoneNumber, $subject, $message);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Form submitted successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to submit the form.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
