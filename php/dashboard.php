<?php
session_start();
include '../php/db_connect.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../screens/login.html"); // Redirect if not logged in
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role']; // 'admin' or 'user'

// Fetch data for both admin and user
if ($role == 'admin') {
    // Admin Dashboard: Fetch total users, active users, alumni profiles
    $total_users_sql = "SELECT COUNT(*) as total_users FROM users";
    $active_users_sql = "SELECT COUNT(*) as active_users FROM users WHERE status = 'active'";
    $alumni_profiles_sql = "SELECT COUNT(*) as alumni_profiles FROM alumni";
    
    $total_users_result = $conn->query($total_users_sql);
    $active_users_result = $conn->query($active_users_sql);
    $alumni_profiles_result = $conn->query($alumni_profiles_sql);

    $total_users = $total_users_result->fetch_assoc()['total_users'];
    $active_users = $active_users_result->fetch_assoc()['active_users'];
    $alumni_profiles = $alumni_profiles_result->fetch_assoc()['alumni_profiles'];

    // Fetch the latest user registered
    $latest_user_sql = "SELECT full_name, username, graduation_year, profile_image FROM users ORDER BY created_at DESC LIMIT 1";
    $latest_user_result = $conn->query($latest_user_sql);
    
    if ($latest_user_result) {
        $latest_user = $latest_user_result->fetch_assoc();
        $latest_user_name = $latest_user['full_name'];
        $latest_user_username = $latest_user['username'];
        $latest_user_graduation_year = $latest_user['graduation_year'];
        $latest_user_image = !empty($latest_user['profile_image']) ? $latest_user['profile_image'] : 'default-profile.jpg'; // Placeholder image
    }
    
} else {
    // User Dashboard: Fetch the user's specific data, e.g., profile info
    $user_profile_sql = "SELECT * FROM users WHERE username = '$username'";
    $user_profile_result = $conn->query($user_profile_sql);
    $user_profile = $user_profile_result->fetch_assoc();

    // Recent Activity (User)
    $recent_activity_sql = "SELECT * FROM activities WHERE username = '$username' ORDER BY created_at DESC LIMIT 5";
    $recent_activity_result = $conn->query($recent_activity_sql);
}

// Close the connection
$conn->close();

// Return the data in JSON format to be used in the front-end
$data = [
    'total_users' => $total_users,
    'active_users' => $active_users,
    'alumni_profiles' => $alumni_profiles,
    'latest_user_name' => $latest_user_name ?? 'N/A',
    'latest_user_username' => $latest_user_username ?? 'N/A',
    'latest_user_graduation_year' => $latest_user_graduation_year ?? 'N/A',
    'latest_user_image' => $latest_user_image ?? 'default-profile.jpg',
];

echo json_encode($data);
?>
