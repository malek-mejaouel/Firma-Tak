<?php
// Start the session if it isn't already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to log a user in by setting session variables
function login($userId, $username) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
}

// Function to log the user out
function logout() {
    session_unset();  // Clear all session variables
    session_destroy();  // Destroy the session
}

// Function to get the logged-in user's ID
function getUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Function to get the logged-in user's username
function getUsername() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

// Function to redirect the user to a different page if not logged in
function redirectIfNotLoggedIn($redirectUrl = 'log.php') {
    if (!isLoggedIn()) {
        header('Location: ' . $redirectUrl);
        exit();
    }
}
?>