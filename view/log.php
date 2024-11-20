
<?php
session_start(); // Ensure the session is started
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_signup'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';
    $user_type = $_POST['user_type'] ?? '';

    // Validate passwords
    if ($password !== $cpassword) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the database connection and insert the user
        $database = new Database();
        $db = $database->getConnection();

        // Prepare the SQL query
        $query = "INSERT INTO user (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)";
        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':user_type', $user_type);

        // Execute the query and check for errors
        if ($stmt->execute()) {
          echo "User registered successfully."; // Debugging line
          if ($user_type == 'admin') {
              echo "Redirecting to admin dashboard..."; // Debugging line
              header('Location: C:/xampp/htdocs/usercrud/view/dashboard.php');
              exit(); // Make sure no further code is executed
          } else {
              echo "Redirecting to user homepage..."; // Debugging line
              header('Location: index.php');
              exit(); // Make sure no further code is executed
          }
      } else {
          $errorInfo = $stmt->errorInfo();
          echo "Error creating user: " . $errorInfo[2];
      }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="log.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Login Page</title>
  </head>
  <body>
    <div class="container" id="container">
      <div class="sign-up">
        <form id="form1" action="log.php" method="POST">
          <h1>nouveau compte</h1>
          <div class="icons">
            <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
          </div>
          <span>utilisez l'email pour se connecter</span>
          <select name="user_type">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
          <input type="text" name="name" id="prenom"  placeholder="prenom" />
          <span id="nomErreur"></span>

          <input type="email" name="email" id="email" placeholder="Email" />
          <span id="emailErreur"></span>

          <input type="password" name="password" id="passe" placeholder="mot de passe" />
          <span id="passErreur"></span>

          <input type="password" name="cpassword" id="password" placeholder="confirmer le mot de passe" />
          <span id="confirmErreur"></span>

          <input type="submit" name="submit_signup" value="s'inscrire" />        </form>
      </div>

      <div class="sign-in">
        <form id="form2" action="dashboard.php" method="POST">
          <h1>se connecter</h1>
          <div class="icons">
            <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
          </div>
          <span>utilisez le mot de passe</span>

          <input type="email" id="mail" placeholder="Email" />
          <span id="mailErreur"></span><br>

          <input type="password" id="password1" placeholder="Password" />
          <span id="motErreur"></span>

          <a href="#">mot de passe oublier</a>
          <input type="submit" id="login-btn"name="login" value="se connecter"  />
        </form>
      </div>

      <div class="toogle-container">
        <div class="toogle">
          <div class="toogle-panel toogle-left">
            <h1>bienvenu firma-tak!</h1>
            <p>si vous avez un compte</p>
            <button class="hidden" id="login" >se connecter</button>
          </div>
          <div class="toogle-panel toogle-right">
            <h1>salut !</h1>
            <p>si vous avez un compte!</p>
            <button class="hidden" id="register" >s'inscrire</button>
          </div>
        </div>
      </div>
    </div>

    <script src="log.js"></script>
  </body>
</html>
