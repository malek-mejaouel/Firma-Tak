<?php
class User {
    private $conn;
    private $table = 'user';

    public function __construct($db) {
        $this->conn = $db;  // Correct the reference to the database connection
    }
    // Create user
    public function create($name, $email, $password, $user_type) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare SQL query
        $query = "INSERT INTO {$this->table} (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':user_type', $user_type);

        // Execute query and return result
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read user for login (find by email)
    public function read($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function listUser() {
        // Check if $conn is initialized (changed from $db to $conn)
        if ($this->conn === null) {
            die("Database connection is not initialized.");
        }

        $query = "SELECT * FROM user";
        $stmt = $this->conn->prepare($query);  
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteUser($userId) {
        // Prepare SQL query to delete a user by ID
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        // Bind the ID parameter
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
        // Execute the query and return true if successful, false otherwise
        return $stmt->execute();
    }
    public function updateUser($userId, $name, $email, $hashedPassword, $userType) {
        // Base query
        $query = "UPDATE {$this->table} SET name = :name, email = :email, user_type = :user_type";
    
        // Add password update only if a new password is provided
        if ($hashedPassword) {
            $query .= ", password = :password";
        }
    
        $query .= " WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_type', $userType);
        $stmt->bindParam(':id', $userId);
    
        if ($hashedPassword) {
            $stmt->bindParam(':password', $hashedPassword);
        }
    
        // Execute the query
        return $stmt->execute();
    }
    }


    
