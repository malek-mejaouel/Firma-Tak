<?php
require_once '../config/database.php';
require_once '../model/user.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // Ensure session_start() is called

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    // Handle registration
    public function register($data) {
        $name = trim($data['name']);
        $email = trim($data['email']);
        $password = trim($data['password']);
        $user_type = trim($data['user_type']);

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($this->userModel->create($name, $email, $hashedPassword, $user_type)) {
            echo "<script>alert('Registration successful!'); window.location.href = '../view/login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }

    // Handle login
    public function login($data) {
        $email = trim($data['email']);
        $password = trim($data['password']);
    
        // Fetch user details from the database
        $user = $this->userModel->read($email);
    
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user'] = $user;
    
            // Redirect based on user type
            if ($user['user_type'] === 'admin') {
                // Redirect to the admin dashboard if user is an admin
                header('Location: ../view/dashboard.php');
                exit();
            } else {
                // Redirect to the user homepage if user is not an admin
                header('Location: ../view/index.php');
                exit();
            }
        } else {
            // If the credentials are invalid, display an error message
            echo "<script>alert('Invalid email or password'); window.location.href = '../view/login.php';</script>";
        }
    }

    // List all users
   
    public function listUser() {
        return $this->userModel->listUser();
    }
    public function deleteUser($userId) {
        return $this->userModel->deleteUser($userId);
    }
    public function editUser($userId, $name, $email, $password, $userType) {
        // If password is provided, hash it; otherwise, leave it unchanged
        $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;
    
        return $this->userModel->updateUser($userId, $name, $email, $hashedPassword, $userType);
    }

    // Delete user
   
}
