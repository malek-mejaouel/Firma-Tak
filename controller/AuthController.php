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
    
        // Check if email already exists
        $existingUser = $this->userModel->read($email);
        if ($existingUser) {
            echo "<script>alert('Email already exists! Please choose another one.'); window.location.href = '../view/login.php';</script>";
            return;
        }
    
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
    
        $user = $this->userModel->read($email);
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
    
            // Redirect based on user type
            switch ($user['user_type']) {
                case 'admin':
                    header('Location: ../view/dashboard.php');
                    break;
                case 'fermier':
                    header('Location: ../view/index.php');
                    break;
                case 'vendeur':
                    header('Location: ../view/vendeur.php');
                    break;
                default:
                    header('Location: ../view/index.php');
                    break;
            }
            exit();
        } else {
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
    // Add this in your controller or dashboard script

   
}
