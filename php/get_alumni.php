<?php
include 'db_connect.php';
header('Content-Type: application/json');

// Fetch alumni details along with job experience
$sql = "
    SELECT 
        users.id, 
        users.full_name, 
        users.student_id, 
        users.graduation_year, 
        users.profile_image, 
        users.description,
        job_experience.company_name, 
        job_experience.position, 
        job_experience.year_start, 
        job_experience.year_end
    FROM users
    LEFT JOIN job_experience ON users.id = job_experience.user_id
    WHERE users.role = 'alumni'
    ORDER BY users.id
";

$result = $conn->query($sql);

if ($result) {
    $alumni = [];
    while ($row = $result->fetch_assoc()) {
        // Group experiences under the alumni
        if (!isset($alumni[$row['id']])) {
            $alumni[$row['id']] = [
                'id' => $row['id'],
                'full_name' => $row['full_name'],
                'student_id' => $row['student_id'],
                'graduation_year' => $row['graduation_year'],
                'profile_image' => $row['profile_image'],
                'description' => $row['description'],
                'job_experience' => [],
            ];
        }
        if ($row['company_name']) {
            $alumni[$row['id']]['job_experience'][] = [
                'company_name' => $row['company_name'],
                'position' => $row['position'],
                'year_start' => $row['year_start'],
                'year_end' => $row['year_end'],
            ];
        }
    }
    echo json_encode(array_values($alumni)); // Re-index array
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
