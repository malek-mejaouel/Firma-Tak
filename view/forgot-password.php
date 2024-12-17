<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Charger PHPMailer via Composer
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $code = rand(100000, 999999); // Générer un code aléatoire
    $expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    $database = new Database();
    $db = $database->getConnection();

    // Vérifiez si l'email existe dans la base de données
    $query = "SELECT * FROM user WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Ajoutez le code à la base de données
        $query = "INSERT INTO password_resets (email, code, expires_at) VALUES (:email, :code, :expires_at)
                  ON DUPLICATE KEY UPDATE code = :code, expires_at = :expires_at";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':expires_at', $expires);
        $stmt->execute();

        // Envoyer l'email avec PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hathamiharabi67@gmail.com'; // Votre email
            $mail->Password = 'ddxv orej cqnh wilu';   // Votre mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Contenu de l'email
            $mail->setFrom('hathamiharabi67@gmail.com', 'FIRMATAK');
            $mail->addAddress($email);
            $mail->Subject = 'Réinitialisation de mot de passe';
            $mail->Body = "Votre code de réinitialisation est : $code. Ce code expire dans 10 minutes.";

            $mail->send();
            echo "<script>alert('Un code a été envoyé à votre email.'); window.location.href = 'reset-password.php';</script>";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Cet email n'existe pas.'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mot de passe oublié</title>
</head>
<body>
    <form action="" method="POST">
        <h1>Mot de passe oublié</h1>
        <input type="email" name="email" placeholder="Entrez votre email 👨‍🌾" required>
        <input type="submit" value="Envoyer 🛖🍃🌿🌼🌱">
    </form>
    <style> {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-image: url("images/banner.jpg");
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

form h1 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #4CAF50;
}

form input[type="email"],
form input[type="submit"] {
    width: 100%;
    padding: 15px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

form input[type="email"] {
    border: 2px solid #e0f1e0;
    background-color: #f8f8f8;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

form input[type="email"]:focus {
    background-color: #f0fcf0;
    border-color: #4CAF50;
    outline: none;
}

form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

form input[type="submit"]:hover {
    background-color: #43a047;
    transform: translateY(-2px);
}

form input[type="submit"]:active {
    background-color: #4CAF50;
    transform: translateY(1px);
}

/* Animation for subtle decoration */
form::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at center, rgba(76, 175, 80, 0.2), transparent);
    z-index: -1;
    animation: rotateBG 10s linear infinite;
}

@keyframes rotateBG {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* Responsive design */
@media (max-width: 768px) {
    form {
        padding: 20px;
    }

    form h1 {
        font-size: 20px;
    }

    form input[type="email"],
    form input[type="submit"] {
        font-size: 14px;
    }
}
</style>
</body>
</html>