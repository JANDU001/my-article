<?php
class Session {
    
    // Method to authenticate user login
    public static function authenticateUser($userType = null) {
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php");
            exit();
        }

        // Check if user type matches the required user type
        if ($userType !== null && $_SESSION['userType'] !== $userType) {
            header("Location: access_denied.php"); // You can create a custom access denied page
            exit();
        }
    }

    // Method to check if a user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['userId']);
    }
}
?>