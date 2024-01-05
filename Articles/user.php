<?php
require_once 'db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new DB();  
    }
    public function getUserById($userId) {
        $conn = $this->db->getConnection();}
    // Method to update user profile
    public function updateProfile($userId, $fullName, $email, $phoneNumber, $address, $profileImage) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE users SET Full_Name = ?, email = ?, phone_Number = ?, Address = ?, profile_Image = ? WHERE userId = ?");
        $stmt->bind_param("sssssi", $fullName, $email, $phoneNumber, $address, $profileImage, $userId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Method to change user password
    public function changePassword($userId, $newPassword) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE users SET Password = ? WHERE userId = ?");
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bind_param("si", $hashedPassword, $userId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Method to retrieve user details by userId
    public function getUserDetails($userId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
       // Method to register a new user
    public function register($fullName, $email, $username, $password, $userType) {
        $conn = $this->db->getConnection();

        // Validate input data (add your validation logic)
        if (empty($fullName) || empty($email) || empty($username) || empty($password) || empty($userType)) {
            return false; // Validation failed
        }

        // Check if the username is unique (you may need to modify this based on your requirements)
        $stmt = $conn->prepare("SELECT userId FROM users WHERE User_Name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return false; // Username already exists
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user
        $stmt = $conn->prepare("INSERT INTO users (Full_Name, email, User_Name, Password, UserType) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullName, $email, $username, $hashedPassword, $userType);

        return $stmt->execute();
    }

    // the login method
public function login($username, $password, $userType) {
    $conn = $this->db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE User_Name = ? AND UserType = ?");
    $stmt->bind_param("ss", $username, $userType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, verify the password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            // Password is correct
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['userType'] = $user['UserType'];
            return true;
        }
    }

    // Invalid login
    return false;
}
// Method to update the Author's profile
public function updateAuthorProfile($userId, $fullName, $email, $password) {
    $conn = $this->db->getConnection();

    // Validate input data (add your validation logic)
    if (empty($fullName) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false; // Validation failed
    }

    // If the password is provided and not empty, update it
    $passwordUpdate = !empty($password) ? ', Password = ?' : '';
    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : '';

    // Update the Author's profile details
    $stmt = $conn->prepare("UPDATE users SET Full_Name = ?, email = ? {$passwordUpdate} WHERE userId = ?");
    $stmt->bind_param("sss", $fullName, $email, $hashedPassword, $userId);

    return $stmt->execute();
}
public function getCurrentUserDetails() {
    Session::start();

    // Check if the user is logged in
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        return $this->getUserById($userId);
    }

    return null;
}
}
?>
