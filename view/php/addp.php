<?php
// Include necessary files

require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/plants.php');
require_once(__DIR__ . '/../../controller/plantsC.php');

$errorName = $errorDescription = $errorState = ""; // Error messages for each field

// Create an instance of the PlantC controller
$plantC = new PlantC(); // Ensure 'PlantC' is the correct class name

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $namep = trim($_POST['namep']);
    $descriptionp = trim($_POST['descriptionp']);
    $statep = trim($_POST['statep']);

    // Check if required fields are set and not empty
    if (empty($namep)) {
        $errorName = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $namep)) {
        $errorName = "Name can only contain letters and spaces.";
    }

    if (empty($descriptionp)) {
        $errorDescription = "Description is required.";
    }

    if (empty($statep)) {
        $errorState = "State is required.";
    }

    // If no errors, proceed to add the plant
    if (empty($errorName) && empty($errorDescription) && empty($errorState)) {
        // Create a new Plant object with the form data
        $plant = new Plant( // Ensure you're using the correct class name 'Plant'
            null, // Auto-incremented ID, so we pass null
            $namep, // Plant name
            $descriptionp, // Plant description
            $statep // Plant state
        );

        // Add the plant to the database
        $plantC->addPlant($plant);

        // Redirect after adding the plant
        header('Location: plantsindex.php');
        exit; // Always exit after header redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Plant</title>
    <style>
        /* Green button styles for Save, Reset, and Back to List */
        input[type="submit"], input[type="reset"], a {
            background-color: #6b7908; /* Green background */
            color: white; /* White text */
            border: 2px solid #6b7908; /* Green border */
            padding: 6px 12px; /* Smaller padding */
            border-radius: 4px; /* Rounded corners */
            text-decoration: none; /* Remove underline from the link */
            font-size: 14px; /* Smaller font size */
            cursor: pointer; /* Pointer cursor on hover */
            display: inline-block;
        }

        input[type="submit"]:hover, input[type="reset"]:hover, a:hover {
            background-color: white; /* White background on hover */
            color: #6b7908; /* Green text on hover */
            border: 2px solid #6b7908; /* Green border on hover */
        }

        /* Basic styling for the form */
        form {
            margin: 20px;
        }

       
        table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0; /* Remove any space between table cells */
}

th, td {
    border: 1px solid #ddd;
    padding: 1px 1px; /* Reduced padding to make cells tighter */
    text-align: left;
    font-size: 13px; /* Slightly smaller font for compactness */
}
        
        label {
            font-weight: bold;
        }

        /* Show error messages inline */
        span.error {
            color: red;
            font-size: 12px;
            display: block; /* Show error messages below fields */
        }
    </style>
</head>
<body>
    <!-- "Back to List" link -->
    <a href="plantsindex.php">Back to list</a>
    <hr>

    <!-- Form to add a new plant -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <table>
            <tr>
                <td><label for="namep">Name:</label></td>
                <td>
                    <input type="text" id="namep" name="namep" value="<?php echo isset($_POST['namep']) ? htmlspecialchars($_POST['namep']) : ''; ?>" />
                    <!-- Show error message only for the name field -->
                    <span class="error"><?php echo $errorName; ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="descriptionp">Description:</label></td>
                <td>
                    <textarea id="descriptionp" name="descriptionp"><?php echo isset($_POST['descriptionp']) ? htmlspecialchars($_POST['descriptionp']) : ''; ?></textarea>
                    <!-- Show error message only for the description field -->
                    <span class="error"><?php echo $errorDescription; ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="statep">State:</label></td>
                <td>
                    <select id="statep" name="statep">
                        <option value="">Select State</option>
                        <option value="Tunis" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Tunis') ? 'selected' : ''; ?>>Tunis</option>
                        <option value="Sfax" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Sfax') ? 'selected' : ''; ?>>Sfax</option>
                        <option value="Kairouan" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Kairouan') ? 'selected' : ''; ?>>Kairouan</option>
                        <option value="Sousse" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Sousse') ? 'selected' : ''; ?>>Sousse</option>
                        <option value="Monastir" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Monastir') ? 'selected' : ''; ?>>Monastir</option>
                        <option value="Gabès" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Gabès') ? 'selected' : ''; ?>>Gabès</option>
                        <option value="Nabeul" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Nabeul') ? 'selected' : ''; ?>>Nabeul</option>
                        <option value="Kébili" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Kébili') ? 'selected' : ''; ?>>Kébili</option>
                        <option value="Zaghouan" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Zaghouan') ? 'selected' : ''; ?>>Zaghouan</option>
                        <option value="Bizerte" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Bizerte') ? 'selected' : ''; ?>>Bizerte</option>
                        <option value="Jendouba" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Jendouba') ? 'selected' : ''; ?>>Jendouba</option>
                        <option value="Mahares" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Mahares') ? 'selected' : ''; ?>>Mahares</option>
                        <option value="L'Ariana" <?php echo (isset($_POST['statep']) && $_POST['statep'] == "L'Ariana") ? 'selected' : ''; ?>>L'Ariana</option>
                        <option value="Le Kef" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Le Kef') ? 'selected' : ''; ?>>Le Kef</option>
                        <option value="Siliana" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Siliana') ? 'selected' : ''; ?>>Siliana</option>
                        <option value="Beja" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Beja') ? 'selected' : ''; ?>>Beja</option>
                        <option value="Ben Arous" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Ben Arous') ? 'selected' : ''; ?>>Ben Arous</option>
                        <option value="La Manouba" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'La Manouba') ? 'selected' : ''; ?>>La Manouba</option>
                        <option value="Kassérine" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Kassérine') ? 'selected' : ''; ?>>Kassérine</option>
                        <option value="Sidi Bouzid" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Sidi Bouzid') ? 'selected' : ''; ?>>Sidi Bouzid</option>
                        <option value="Tataouine" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Tataouine') ? 'selected' : ''; ?>>Tataouine</option>
                        <option value="Mahdia" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Mahdia') ? 'selected' : ''; ?>>Mahdia</option>
                        <option value="Médenine" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Médenine') ? 'selected' : ''; ?>>Médenine</option>
                        <option value="Gafsa" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Gafsa') ? 'selected' : ''; ?>>Gafsa</option>
                    </select>
                    <!-- Show error message only for the state field -->
                    <span class="error"><?php echo $errorState; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Save">
                </td>
                <td>
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
