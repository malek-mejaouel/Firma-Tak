<?php

require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/plants.php');
require_once(__DIR__ . '/../../controller/plantsC.php');

$errorName = $errorDescription = $errorState = ""; // Error messages for each field
$plant = null;

// Create an instance of the PlantC controller
$plantC = new PlantC();

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $plant = $plantC->showPlant($_GET['id']); // Fetch plant details
} else {
    // If no ID is provided, redirect or show an error
    header('Location: plantsindex.php');
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $namep = trim($_POST['namep']);
    $descriptionp = trim($_POST['descriptionp']);
    $statep = trim($_POST['statep']);
    $id = $_POST['id']; // The plant ID for update

    // Validate fields
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

    // If no errors, proceed to update the plant
    if (empty($errorName) && empty($errorDescription) && empty($errorState)) {
        // Create a Plant object
        $plant = new Plant(
            null, // ID is automatically managed
            $namep,
            $descriptionp,
            $statep
        );

        // Update the plant using the provided ID
        $plantC->updatePlant($plant, $id);

        // Redirect to the list of plants
        header('Location: plantsindex.php');
        exit;
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Plant</title>
    <style>
        /* Style the buttons with a smaller size and green background */
        button, input[type="submit"], input[type="reset"] {
            background-color: #6b7908; /* Green color */
            color: white; /* Text color */
            border: none;
            padding: 5px 15px; /* Smaller padding for smaller buttons */
            font-size: 12px; /* Smaller font size */
            cursor: pointer;
            border-radius: 5px; /* Optional: rounded corners */
            transition: background-color 0.3s;
        }

        button:hover, input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #5a6c06; /* Darker green when hovered */
        }
    </style>
</head>
<body>
    <button><a href="plantsindex.php" style="color: white; text-decoration: none;">Back to list</a></button>
    <hr>

    <!-- Only display the form if the plant was found -->
    <?php if ($plant): ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="POST">
            <table>
                <tr>
                    <td><label for="id">Plant ID:</label></td>
                    <td>
                        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($plant['ido']); ?>" readonly />
                    </td>
                </tr>
                <tr>
                    <td><label for="namep">Name:</label></td>
                    <td>
                        <input type="text" id="namep" name="namep" value="<?php echo isset($_POST['namep']) ? htmlspecialchars($_POST['namep']) : htmlspecialchars($plant['namep']); ?>" />
                        <!-- Show error message only for the name field -->
                        <span style="color: red;"><?php echo $errorName; ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="descriptionp">Description:</label></td>
                    <td>
                        <textarea id="descriptionp" name="descriptionp"><?php echo isset($_POST['descriptionp']) ? htmlspecialchars($_POST['descriptionp']) : htmlspecialchars($plant['descriptionp']); ?></textarea>
                        <!-- Show error message only for the description field -->
                        <span style="color: red;"><?php echo $errorDescription; ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="statep">State:</label></td>
                    <td>
                        <select id="statep" name="statep">
                            <option value="">Select State</option>
                            <option value="Tunis" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Tunis') || ($plant['statep'] == 'Tunis') ? 'selected' : ''; ?>>Tunis</option>
                            <option value="Sfax" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Sfax') || ($plant['statep'] == 'Sfax') ? 'selected' : ''; ?>>Sfax</option>
                            <option value="Kairouan" <?php echo (isset($_POST['statep']) && $_POST['statep'] == 'Kairouan') || ($plant['statep'] == 'Kairouan') ? 'selected' : ''; ?>>Kairouan</option>
                            <!-- Add other states here -->
                        </select>
                        <!-- Show error message only for the state field -->
                        <span style="color: red;"><?php echo $errorState; ?></span>
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
    <?php else: ?>
        <p>Plant not found.</p>
    <?php endif; ?>
</body>
</html>
