<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header('Location: view/dashboard.php');
    } else {
        header('Location: view/user_home.php');
    }
} else {
    header('Location: view/login.php');
}
exit();
?>