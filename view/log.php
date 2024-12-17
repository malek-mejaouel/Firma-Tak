<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_signup'])) {
        // Registration logic
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $cpassword = trim($_POST['cpassword'] ?? '');
        $user_type = trim($_POST['user_type'] ?? '');

        if ($password !== $cpassword) {
            echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
            exit();
        }

        // Check if the email already exists
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Email already exists
            echo "<script>alert('Email is already registered! Please choose another email.'); window.history.back();</script>";
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $query = "INSERT INTO user (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':user_type', $user_type);

        if ($stmt->execute()) {
            // Store session data after successful registration
            $_SESSION['user'] = [
                'name' => $name,
                'email' => $email,
                'user_type' => $user_type
            ];

            // Redirect based on user type
            if ($user_type === 'admin') {
                header('Location: ../view/dashboard.php');
            } elseif ($user_type === 'fermier') {
                header('Location: ../view/index.php');
            } elseif ($user_type === 'vendeur') {
                header('Location: ../view/vendeur.php');
            }
            exit();
        } else {
            echo "<script>alert('Error during registration. Please try again.'); window.history.back();</script>";
        }
    }

    if (isset($_POST['submit_login'])) {
        // Login logic
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Fetch user by email
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store session data after successful login
                $_SESSION['user'] = $user;

                // Redirect based on user type
                if ($user['user_type'] === 'admin') {
                    header('Location: ../view/dashboard.php');
                } elseif ($user['user_type'] === 'fermier') {
                    header('Location: ../view/index.php');
                } elseif ($user['user_type'] === 'vendeur') {
                    header('Location: ../view/vendeur.php');
                }
                exit();
            } else {
                echo "<script>alert('Invalid password!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('User not found!'); window.history.back();</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="log.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <title>Login & Registration</title>
</head>
<body>
<div class="container" id="container">
    <div class="sign-up">
        <form action="log.php" method="POST">
            <h1>Create Account</h1>
            <div class="icons">
                <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
            </div>
            <select name="user_type" required>
            <option value="" disabled selected>Select your type</option>
            <option value="fermier">Fermier</option>
            <option value="vendeur">Vendeur</option>

           <!-- Option added for admin -->
        </select>
            <span>Use your email to register</span>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="cpassword" placeholder="Confirm Password" required>
            <input type="submit" name="submit_signup" value="Sign Up">
        </form>
    </div>

    <div class="sign-in">
        <form action="log.php" method="POST">
            <h1>Sign In</h1>
            <div class="icons">
                <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
            </div>
            <span>Use your email to login</span>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="forgot-password">
            <a href="forgot-password.php">Forgot Password?</a></div>

            <input type="submit" name="submit_login" value="Sign In">
        </form>
    </div>
    <div class="toogle-container">
        <div class="toogle">
            <div class="toogle-panel toogle-left">
                <h1>bienvenu firma-tak!</h1>
                <p>si vous avez un compte</p>
                <button class="hidden" id="login">se connecter</button>
            </div>
            <div class="toogle-panel toogle-right">
                <h1>salut !</h1>
                <p>si vous avez un compte!</p>
                <button class="hidden" id="register">s'inscrire</button>
            </div>
        </div>
    </div>
</div>
<script src="log.js"></script>

</body>
</html>