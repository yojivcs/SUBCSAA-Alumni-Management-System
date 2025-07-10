<?php
include 'db_connect.php';
header('Content-Type: application/json');

try {
    // Fetch all users with role 'user'
    $sql = "SELECT id, full_name, student_id, graduation_year, profile_image FROM users WHERE role = 'user'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $users = [];
        while ($row = $result->fetch_assoc()) {
            // Verify profile_image path
            $profile_image = $row['profile_image'];
            if (!$profile_image || !file_exists('../' . $profile_image)) {
                $profile_image = 'assets/images/default-profile.png'; // Ensure the path exists
            }
            

            // Add profile_image to user data
            $row['profile_image'] = $profile_image;
            $users[] = $row;
        }
        echo json_encode($users);
    } else {
        // Return an empty array if no users found
        echo json_encode([]);
    }
} catch (Exception $e) {
    // Catch and log errors
    error_log("Error fetching users: " . $e->getMessage());
    echo json_encode(['error' => 'An error occurred while fetching users.']);
}

// Close the database connection
$conn->close();
?>
