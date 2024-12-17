<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $code = trim($_POST['code']);
    $password = trim($_POST['password']);

    $database = new Database();
    $db = $database->getConnection();

    // Vérifiez si le code est valide et non expiré
    $query = "SELECT * FROM password_resets WHERE email = :email AND code = :code AND expires_at > NOW()";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':code', $code);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Le code est valide, on met à jour le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE user SET password = :password WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            // Supprimez le code de la base de données après utilisation
            $query = "DELETE FROM password_resets WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Rediriger vers log.php pour permettre à l'utilisateur de se connecter
            header('Location: log.php');
            exit();
        } else {
            echo "<script>alert('Erreur lors de la mise à jour du mot de passe.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Code invalide ou expiré.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="reset-container">
        <h1>Réinitialisation de mot de passe</h1>
        <form action="" method="POST">
            <!-- Champ pour l'email -->
            <label for="email">Email :</label>
            <input type="email" name="email" placeholder="Entrez votre email" required>

            <!-- Champ pour le code de réinitialisation -->
            <label for="code">Code de réinitialisation :</label>
            <input type="text" name="code" placeholder="Entrez le code reçu" required>

            <!-- Champ pour le nouveau mot de passe -->
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" name="password" placeholder="Nouveau mot de passe" required>

            <input type="submit" value="Mettre à jour le mot de passe">
        </form>
    </div>
    <style>  {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-image: url("agr.png");
    background-size: cover;
    background-position: center;
    animation: moveBackground 20s ease infinite;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
    color: #333;
}

/* Smooth animation of background */
@keyframes moveBackground {
    0% {
        background-position: 0 0;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0 0;
    }
}

.reset-container {
    background-color: rgba(255, 255, 255, 0.9); /* Soft white with a slight transparency */
    border-radius: 12px;
    box-shadow: 0 12px 50px rgba(0, 0, 0, 0.15);
    padding: 40px;
    width: 100%;
    max-width: 480px;
    text-align: center;
    backdrop-filter: blur(8px); /* Soft blur effect for the background */
    transition: all 0.3s ease;
}

.reset-container:hover {
    transform: translateY(-5px); /* Hover effect for subtle lift */
}

.reset-container h1 {
    font-size: 32px;
    color: #58a15d; /* Lighter green */
    margin-bottom: 30px;
    font-weight: bold;
    letter-spacing: 1px;
}

/* Form styles */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

form label {
    font-size: 18px;
    color: #58a15d; /* Lighter green */
    font-weight: 600;
    text-align: left;
}

form input {
    padding: 16px;
    border: 2px solid #d1e0d1; /* Soft border color */
    border-radius: 10px;
    font-size: 16px;
    color: #333;
    background-color: #fafafc;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

form input:focus {
    border-color: #58a15d; /* Green border on focus */
    outline: none;
    background-color: #f1f9f1; /* Soft green background on focus */
}

/* Submit button */
input[type="submit"] {
    background-color: #58a15d; /* Light green background */
    color: white;
    border: none;
    padding: 16px;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

input[type="submit"]:hover {
    background-color: #4a9147; /* Slightly darker green on hover */
    transform: translateY(-3px); /* Lift effect */
}

input[type="submit"]:active {
    background-color: #58a15d; /* Reset to the original green */
    transform: translateY(1px); /* Button press effect */
}

/* Mobile responsive styles */
@media (max-width: 768px) {
    .reset-container {
        padding: 30px;
        width: 100%;
    }
}

/* Focus effects */
form input[type="email"]:focus,
form input[type="text"]:focus,
form input[type="password"]:focus {
    background-color: #e8f6e0; /* Lighter background on focus */
    box-shadow: 0 0 8px rgba(88, 161, 93, 0.6); /* Light green shadow on focus */
}

/* Alert message styles */
.alert {
    background-color: #f8d7da;
    color: #721c24;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
    text-align: center;
    font-size: 16px;
}
</style>
</body>
</html>