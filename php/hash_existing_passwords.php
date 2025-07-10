<?php
include 'db_connect.php';

// Fetch all users
$sql = "SELECT id, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);

        // Update the password in the database
        $update_sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $hashed_password, $row['id']);
        $stmt->execute();
    }
}

echo "Passwords have been hashed!";
$conn->close();
?>
