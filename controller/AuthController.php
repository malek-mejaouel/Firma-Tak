<?php
require_once '../config/database.php';
require_once '../model/user.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    // Handle registration
    public function register($data) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $user_type = $data['user_type'];

        if ($this->userModel->create($name, $email, $password, $user_type)) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }

    // Handle login
    public function login($data) {
        $email = $data['email'];
        $password = $data['password'];
    
        // Fetch user details from the database
        $user = $this->userModel->read($email);
    
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user'] = $user;
    
            // Redirect based on user type
            if ($user['user_type'] === 'admin') {
                // Redirect to the admin dashboard if user is an admin
                header('Location: C:/xampp/htdocs/usercrud/view/dashboard.php');
                exit(); // Stop further execution after redirect
            } else {
                // Redirect to the user homepage if user is not an admin
                header('Location: ../view/index.php');
                exit(); // Stop further execution after redirect
            }
        } else {
            // If the credentials are invalid, display an error message
            echo "<script>alert('Invalid email or password');</script>";
        }
    }
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
