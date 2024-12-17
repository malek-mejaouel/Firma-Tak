<?php
require_once '../config/database.php';
require_once '../model/user.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}

class AuthController {
    private $userModel;
    private $db;

    public function __construct($db) {
        $this->userModel = new User($db);
        $this->db = $db; // Store DB connection for queries
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

    public function listUserByLetter($letter)
    {
        // On trie les utilisateurs par la première lettre de leur nom (ordre alphabétique)
        $query = "SELECT * FROM user WHERE name LIKE :letter ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':letter', $letter . '%'); // Le signe % permet de récupérer tous les utilisateurs dont le nom commence par cette lettre
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Delete a user
    public function deleteUser($userId) {
        return $this->userModel->deleteUser($userId);
    }

    // Edit a user
    public function editUser($userId, $name, $email, $password, $userType) {
        // If password is provided, hash it; otherwise, leave it unchanged
        $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;
        return $this->userModel->updateUser($userId, $name, $email, $hashedPassword, $userType);
    }

    // Fetch recently added user(s)
    public function getRecentUser() {
        $recentUser = $this->userModel->getRecentlyAddedUser(); // Call the method from the User model
        if ($recentUser) {
            return $recentUser;  // Return recent user data
        } else {
            return null;  // Return null if no recent users
        }
    }

    // Method to search a user
    public function searchUser($term) {
        return $this->userModel->searchUser($term);
    }

    // Update profile picture
    public function updateProfilePicture($userId, $imagePath) {
        // Update the user's profile_picture column in the database with the new image path
        $query = "UPDATE user SET profile_picture = :profile_picture WHERE id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':profile_picture', $imagePath);
        $stmt->bindParam(':user_id', $userId);

        return $stmt->execute(); // Execute the query and return success/failure
    }
}
?>