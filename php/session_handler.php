<?php
require_once 'config.php';
require_once 'db_connect.php';

class CustomSessionHandler {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
    }

    public static function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function getCurrentUser() {
        if (!self::isAuthenticated()) {
            return null;
        }

        global $conn;
        $userId = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            self::destroy();
            return null;
        }

        return $result->fetch_assoc();
    }

    public static function login($userId, $role) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $role;
        $_SESSION['last_activity'] = time();
    }

    public static function destroy() {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();
    }

    public static function checkInactivity() {
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
            self::destroy();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }

    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header('Location: /screens/login.php');
            exit();
        }
        return self::checkInactivity();
    }

    public static function requireAdmin() {
        if (!self::isAuthenticated() || $_SESSION['role'] !== 'admin') {
            header('Location: /screens/login.php');
            exit();
        }
        return self::checkInactivity();
    }
}
?> 