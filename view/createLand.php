<?php
require_once '../config/database.php';
require '../controller/LandRentController.php';

// Initialize database connection
$database = new Database();
$conn = $database->getConnection(); // Ensures $conn is properly instantiated

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new LandRentController($conn);
    $result = $controller->createLand(
        $_POST['land_id'],
        $_POST['owner'],
        $_POST['contact_number'],
        $_POST['size_km2'],
        $_POST['price_per_year']
    );

    // Redirect with a success message or display an error
    if ($result) {
        header('Location: showcaseLands.php');
        exit();
    } else {
        echo "<div class='error-message'>Failed to create the land rental record.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Land Rental Record</title>
    <link rel="stylesheet" href="../style.css">
    <script>
        // Client-side validation for land_id (numbers only)
        function validateLandIdInput(event) {
            const key = event.key;
            if (!/^\d$/.test(key)) {
                event.preventDefault();
            }
        }

        // Client-side validation for contact_number (numbers only)
        function validateContactNumberInput(event) {
            const key = event.key;
            if (!/^\d$/.test(key)) {
                event.preventDefault();
            }
        }

        // Client-side validation for owner (letters only)
        function validateOwnerInput(event) {
            const key = event.key;
            const regex = /^[a-zA-Z\s]*$/; // Allows letters and spaces
            if (!regex.test(key)) {
                event.preventDefault(); // Prevents invalid characters
            }
        }
    </script>
</head>
<body>
    <style>/* General styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f7;
    margin: 0;
    padding: 0;
}

.container {
    width: 60%;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    color: #6b7908; /* Set title color */
    font-size: 28px;
    margin-bottom: 20px;
}

.form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-group {
    width: 100%;
    margin-bottom: 15px;
    text-align: left;
}

label {
    font-weight: bold;
    color: #6b7908; /* Set label color */
    font-size: 16px;
    display: block;
    margin-bottom: 8px;
}

.input-field {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ddd;
    box-sizing: border-box;
}

.input-field:focus {
    outline: none;
    border-color: #6b7908; /* Set focus border color */
}

.btn-submit {
    background-color: #6b7908; /* Set button background color */
    color: white;
    padding: 12px 25px;
    border-radius: 5px;
    font-size: 16px;
    text-decoration: none;
    text-align: center;
    border: none;
    cursor: pointer;
    width: 100%;
}

.btn-submit:hover {
    background-color: #5a6a07; /* Slightly darker shade on hover */
}

.btn-back {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 25px;
    background-color: #eee;
    color: #333;
    font-size: 16px;
    text-decoration: none;
    border-radius: 5px;
}

.btn-back:hover {
    background-color: #ddd;
}

.error-message {
    color: red;
    font-size: 16px;
    margin-top: 20px;
}

.form-actions {
    width: 100%;
}
</style>
    <div class="container">
        <h1>Create New Land Rental Record</h1>
        <form action="createLand.php" method="post" class="form">
            <div class="form-group">
                <label for="land_id">Land ID:</label>
                <input type="text" name="land_id" id="land_id" required onkeypress="validateLandIdInput(event)" class="input-field">
            </div>

            <div class="form-group">
                <label for="owner">Owner:</label>
                <input type="text" name="owner" id="owner" required class="input-field" onkeypress="validateOwnerInput(event)">
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" name="contact_number" id="contact_number" required onkeypress="validateContactNumberInput(event)" class="input-field">
            </div>

            <div class="form-group">
                <label for="size_km2">Size (Km²):</label>
                <input type="number" step="0.01" name="size_km2" required class="input-field">
            </div>

            <div class="form-group">
                <label for="price_per_year">Price per Year:</label>
                <input type="number" step="0.01" name="price_per_year" required class="input-field">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Add Land Rental</button>
                <a href="listLands.php" class="btn-back">Back to Land Rentals List</a>
            </div>
        </form>
    </div>
</body>
<style>
/* Styling here... */
</style>
</html>
