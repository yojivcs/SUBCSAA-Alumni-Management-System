<?php
include '../php/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password is hashed or plaintext
        if (password_verify($password, $user['password'])) {
            // Password matches the hashed version
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: ../private/admin/dashboard.html");
            } else {
                header("Location: ../private/users/dashboard.html");
            }
            exit();
        } elseif ($user['password'] === $password) {
            // Password matches the plaintext version (old accounts)
            // Hash the plaintext password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $user['id']);
            $update_stmt->execute();
            $update_stmt->close();

            // Log the user in after rehashing
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: ../private/admin/dashboard.html");
            } else {
                header("Location: ../private/users/dashboard.html");
            }
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
}
$conn->close();
?>
