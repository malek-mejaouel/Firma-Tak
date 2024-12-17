<?php
require_once '../config/database.php';
require '../controller/LandRentController.php';

// Instantiate the controller
$controller = new LandRentController($conn);

// Check if an ID is provided in the URL and fetch the land rental details
if (isset($_GET['id'])) {
    $land = $controller->viewLand($_GET['id']);
    if (!$land) {
        // Redirect to the land rentals list if the record is not found
        header('Location: listLands.php');
        exit();
    }
} else {
    // Redirect if no ID is provided
    header('Location: listLands.php');
    exit();
}

// Handle form submission for updating the land rental record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all fields are set and then update the land record
    if (!empty($_POST['land_id']) && !empty($_POST['size_km2']) && !empty($_POST['price_per_year'])) {
        $result = $controller->editLand(
            $_POST['id'], 
            $_POST['land_id'], 
            $_POST['size_km2'], 
            $_POST['price_per_year']
        );
        if ($result) {
            header('Location: listLands.php'); // Redirect to the land list page
            exit();
        } else {
            $errorMessage = "Failed to update the land rental record. Please try again.";
        }
    } else {
        $errorMessage = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Land Rental Record</title>
    <style>
        body {
            margin: auto;
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            overflow: auto;
            background: linear-gradient(315deg, rgba(101,0,94,1) 3%, rgba(60,132,206,1) 38%, rgba(48,238,226,1) 68%, rgba(255,25,25,1) 98%);
            animation: gradient 15s ease infinite;
            background-size: 400% 400%;
            background-attachment: fixed;
        }

        @keyframes gradient {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }

        .wave {
            background: rgb(255 255 255 / 25%);
            border-radius: 1000% 1000% 0 0;
            position: fixed;
            width: 200%;
            height: 12em;
            animation: wave 10s -3s linear infinite;
            transform: translate3d(0, 0, 0);
            opacity: 0.8;
            bottom: 0;
            left: 0;
            z-index: -1;
        }

        .wave:nth-of-type(2) {
            bottom: -1.25em;
            animation: wave 18s linear reverse infinite;
            opacity: 0.8;
        }

        .wave:nth-of-type(3) {
            bottom: -2.5em;
            animation: wave 20s -1s reverse infinite;
            opacity: 0.9;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
            position: relative;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        .input-field {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn-submit {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }

        .btn-back {
            text-align: center;
            color: #007BFF;
            font-size: 16px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .btn-back:hover {
            color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Land Rental Record</h1>
        <?php if (isset($errorMessage)) echo "<p class='error-message'>$errorMessage</p>"; ?>
        <form action="editLand.php?id=<?php echo $land['id']; ?>" method="post" class="form">
            <input type="hidden" name="id" value="<?php echo $land['id']; ?>">

            <div class="form-group">
                <label for="land_id">Land ID:</label>
                <input type="text" name="land_id" id="land_id" value="<?php echo htmlspecialchars($land['land_id']); ?>" required class="input-field">
            </div>

            <div class="form-group">
                <label for="size_km2">Size (Km²):</label>
                <input type="number" step="0.01" name="size_km2" id="size_km2" value="<?php echo htmlspecialchars($land['size_km2']); ?>" required class="input-field">
            </div>

            <div class="form-group">
                <label for="price_per_year">Price per Year:</label>
                <input type="number" step="0.01" name="price_per_year" id="price_per_year" value="<?php echo htmlspecialchars($land['price_per_year']); ?>" required class="input-field">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Update Land Rental</button>
                <a href="listLands.php" class="btn-back">Back to Land Rentals List</a>
            </div>
        </form>
    </div>
</body>
</html>
