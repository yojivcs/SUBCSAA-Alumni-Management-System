<?php
session_start();
include 'db_connect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Ensure this is set at login
    $name = $_POST['name'];
    $graduation_year = $_POST['graduation_year'];
    $description = $_POST['description'];

    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['profile_image']['name']);
        $target_path = '../uploads/' . $image_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
            $image_path = 'uploads/' . $image_name;
        } else {
            die('File upload failed');
        }
    } else {
        $image_path = null; // No new image uploaded
    }

    // Update user profile
    $sql = "UPDATE users SET graduation_year = ?, profile_image = IFNULL(?, profile_image), description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $graduation_year, $image_path, $description, $user_id);
    $stmt->execute();

    // Save job experiences
    if (isset($_POST['job_experience'])) {
        foreach ($_POST['job_experience'] as $job) {
            $job_id = $job['id'] ?? null;
            $company = $job['company_name'];
            $position = $job['position'];
            $year_start = $job['year_start'];
            $year_end = $job['year_end'];

            if (!empty($job_id)) {
                // Update existing job experience
                $job_sql = "UPDATE job_experience SET company_name = ?, position = ?, year_start = ?, year_end = ? WHERE id = ?";
                $job_stmt = $conn->prepare($job_sql);
                $job_stmt->bind_param('ssiii', $company, $position, $year_start, $year_end, $job_id);
            } else {
                // Insert new job experience
                $job_sql = "INSERT INTO job_experience (user_id, company_name, position, year_start, year_end) VALUES (?, ?, ?, ?, ?)";
                $job_stmt = $conn->prepare($job_sql);
                $job_stmt->bind_param('issii', $user_id, $company, $position, $year_start, $year_end);
            }

            $job_stmt->execute();

            if ($job_stmt->error) {
                die('Error saving job experience: ' . $job_stmt->error);
            }
        }
    }

    echo "Profile updated successfully!";
}
?>
