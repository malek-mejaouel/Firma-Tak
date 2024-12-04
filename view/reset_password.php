<?php
require_once '../controller/ResetPasswordController.php';
require_once '../helpers/session_helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_email'])) {
    $email = $_POST['email'];

    // Create controller instance and send reset email
    $resetController = new ResetPasswordController();
    $resetController->sendResetEmail($email);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="<?php echo $_SESSION['message_type']; ?>">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit" name="send_email">Send Reset Code</button>
    </form>
</body>
</html>
