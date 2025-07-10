<?php
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to logout.html to show a user-friendly logging out message
header('Location: /screens/login.html');
exit;
?>
