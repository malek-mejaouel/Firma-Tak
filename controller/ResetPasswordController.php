<?php
session_start();
include_once '../config/database.php';
include_once '../helpers/session_helper.php';

// Use PHPMailer namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require '../vendor/autoload.php';  // Ensure the path is correct

class ResetPasswordController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Main method to send reset email
    public function sendResetEmail($email) {
        // Check if email exists in the database
        $query = "SELECT email FROM user WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Generate a reset code
            $resetCode = rand(100000, 999999);

            // Store the reset code in the database
            $this->storeResetCode($email, $resetCode);

            // Send the reset code via email
            $this->sendEmail($email, $resetCode);

            $_SESSION['message'] = "Reset code sent to your email.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Email does not exist.";
            $_SESSION['message_type'] = "error";
        }
    }

    // Store reset code in the database
    private function storeResetCode($email, $resetCode) {
        $query = "UPDATE user SET reset_code = :reset_code WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reset_code', $resetCode);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    // Send reset code email
    private function sendEmail($email, $resetCode) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Your Gmail
            $mail->Password = 'your_generated_app_password'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Your Company');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Your password reset code is: <strong>$resetCode</strong>";

            $mail->send();
        } catch (Exception $e) {
            $_SESSION['message'] = "Mailer Error: {$mail->ErrorInfo}";
            $_SESSION['message_type'] = "error";
        }
    }
}
?>