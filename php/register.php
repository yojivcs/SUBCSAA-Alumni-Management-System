<?php
include '../php/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $student_id = $_POST['student_id'];
    $graduation_year = $_POST['graduation_year'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Set default role to 'user'
    $role = 'user';

    // Add the role column to the INSERT query
    $sql = "INSERT INTO users (full_name, username, password, student_id, graduation_year, role) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $full_name, $username, $hashedPassword, $student_id, $graduation_year, $role);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: ../screens/login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
