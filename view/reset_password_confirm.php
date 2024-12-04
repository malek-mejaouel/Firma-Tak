<?php
require_once '../controller/ResetPasswordController.php';
require_once '../config/database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $resetCode = $_POST['reset_code'];
    $newPassword = $_POST['new_password'];

    // Call controller to reset password
    $resetController = new ResetPasswordController();
    $reset = $resetController->resetPassword($email, $newPassword, $resetCode);
    if ($reset) {
        echo "Password reset successfully!";
    } else {
        echo "Invalid reset code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="text" name="reset_code" placeholder="Enter the reset code" required>
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</body>
</html>