<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'subcsaa_db');

// Application configuration
define('APP_NAME', 'SUBCSAA');
define('BASE_URL', '');  // Leave empty for root directory
define('UPLOAD_DIR', '../uploads/');
define('PASSWORD_MIN_LENGTH', 8);

// Session configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'subcsaa_session');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Dhaka');

// Security
define('CSRF_TOKEN_SECRET', 'your-secret-key-here');
define('HASH_ALGO', 'sha256');
?> 