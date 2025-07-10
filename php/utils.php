<?php
class Utils {
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }

    public static function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function validateStudentId($studentId) {
        return preg_match('/^\d{3}-\d{2}-\d{2}$/', $studentId);
    }

    public static function validateGraduationYear($year) {
        $currentYear = date('Y');
        return is_numeric($year) && $year >= 2000 && $year <= ($currentYear + 6);
    }

    public static function validatePassword($password) {
        return strlen($password) >= PASSWORD_MIN_LENGTH;
    }

    public static function generateRandomString($length = 10) {
        return bin2hex(random_bytes($length));
    }

    public static function redirectWithError($location, $error) {
        header("Location: $location?error=" . urlencode($error));
        exit();
    }

    public static function redirectWithSuccess($location, $message) {
        header("Location: $location?success=" . urlencode($message));
        exit();
    }
}
?> 