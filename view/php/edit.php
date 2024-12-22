<?php


require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/animals.php');
require_once(__DIR__ . '/../../controller/animalsC.php');

$error = "";

// Create an instance of the controller
$animalC = new AnimalC();

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $animal = $animalC->showAnimal($_GET['id']); // Fetch animal details
} else {
    // If no ID is provided, redirect or show an error
    header('Location: animalsindex.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $state = trim($_POST['state']);

    if (
        isset($name) &&
        isset($description) &&
        isset($state) &&
        isset($_POST["id"])
    ) {
        if (
            !empty($name) &&
            !empty($description) &&
            !empty($state)
        ) {
            // Server-side validation: check if name contains only letters and spaces
            if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $error = "Name can only contain letters and spaces.";
            } else {
                // Create an Animal object
                $animal = new Animal(
                    null, // Assuming ID is not needed here, or use $_POST['id'] if needed
                    $name,
                    $description,
                    $state
                );

                // Update animal using the provided ID
                $animalC->updateAnimal($animal, $_POST['id']);

                // Redirect to the list of animals
                header('Location: animalsindex.php');
                exit;
            }
        } else {
            $error = "Missing information";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Animal</title>
    <style>
        /* Style the buttons with a green background and smaller size */
        button, input[type="submit"], input[type="reset"] {
            background-color: #6b7908; /* Green color */
            color: white; /* Text color */
            border: none;
            padding: 5px 10px; /* Smaller padding */
            font-size: 12px; /* Smaller font size */
            cursor: pointer;
            border-radius: 5px; /* Optional: rounded corners */
            transition: background-color 0.3s;
        }

        button:hover, input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #5a6c06; /* Darker green when hovered */
        }

        /* Make sure the link in the button looks like text */
        button a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <button><a href="animalsindex.php">Back to list</a></button>
    <hr>

    <!-- Display error messages if any -->
    <div id="error" style="color: red;">
        <?php echo $error; ?>
    </div>

    <?php if ($animal): ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="POST">
            <table>
                <tr>
                    <td><label for="id">Animal ID:</label></td>
                    <td>
                        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($animal['id']); ?>" readonly />
                    </td>
                </tr>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($animal['name']); ?>" />
                    </td>
                </tr>
                <tr>
                    <td><label for="description">Description:</label></td>
                    <td>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($animal['description']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><label for="state">State:</label></td>
                    <td>
                        <select id="state" name="state">
                            <option value="">Select State</option>
                            <option value="Tunis" <?php echo ($animal['state'] == 'Tunis') ? 'selected' : ''; ?>>Tunis</option>
                            <option value="Sfax" <?php echo ($animal['state'] == 'Sfax') ? 'selected' : ''; ?>>Sfax</option>
                            <option value="Kairouan" <?php echo ($animal['state'] == 'Kairouan') ? 'selected' : ''; ?>>Kairouan</option>
                            <option value="Sousse" <?php echo ($animal['state'] == 'Sousse') ? 'selected' : ''; ?>>Sousse</option>
                            <option value="Monastir" <?php echo ($animal['state'] == 'Monastir') ? 'selected' : ''; ?>>Monastir</option>
                            <option value="Gabès" <?php echo ($animal['state'] == 'Gabès') ? 'selected' : ''; ?>>Gabès</option>
                            <option value="Nabeul" <?php echo ($animal['state'] == 'Nabeul') ? 'selected' : ''; ?>>Nabeul</option>
                            <option value="Kébili" <?php echo ($animal['state'] == 'Kébili') ? 'selected' : ''; ?>>Kébili</option>
                            <option value="Zaghouan" <?php echo ($animal['state'] == 'Zaghouan') ? 'selected' : ''; ?>>Zaghouan</option>
                            <option value="Bizerte" <?php echo ($animal['state'] == 'Bizerte') ? 'selected' : ''; ?>>Bizerte</option>
                            <option value="Jendouba" <?php echo ($animal['state'] == 'Jendouba') ? 'selected' : ''; ?>>Jendouba</option>
                            <option value="Mahares" <?php echo ($animal['state'] == 'Mahares') ? 'selected' : ''; ?>>Mahares</option>
                            <option value="L'Ariana" <?php echo ($animal['state'] == "L'Ariana") ? 'selected' : ''; ?>>L'Ariana</option>
                            <option value="Le Kef" <?php echo ($animal['state'] == 'Le Kef') ? 'selected' : ''; ?>>Le Kef</option>
                            <option value="Siliana" <?php echo ($animal['state'] == 'Siliana') ? 'selected' : ''; ?>>Siliana</option>
                            <option value="Beja" <?php echo ($animal['state'] == 'Beja') ? 'selected' : ''; ?>>Beja</option>
                            <option value="Ben Arous" <?php echo ($animal['state'] == 'Ben Arous') ? 'selected' : ''; ?>>Ben Arous</option>
                            <option value="La Manouba" <?php echo ($animal['state'] == 'La Manouba') ? 'selected' : ''; ?>>La Manouba</option>
                            <option value="Kassérine" <?php echo ($animal['state'] == 'Kassérine') ? 'selected' : ''; ?>>Kassérine</option>
                            <option value="Sidi Bouzid" <?php echo ($animal['state'] == 'Sidi Bouzid') ? 'selected' : ''; ?>>Sidi Bouzid</option>
                            <option value="Tataouine" <?php echo ($animal['state'] == 'Tataouine') ? 'selected' : ''; ?>>Tataouine</option>
                            <option value="Mahdia" <?php echo ($animal['state'] == 'Mahdia') ? 'selected' : ''; ?>>Mahdia</option>
                            <option value="Médenine" <?php echo ($animal['state'] == 'Médenine') ? 'selected' : ''; ?>>Médenine</option>
                        </select>
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
        <p>Animal not found.</p>
    <?php endif; ?>
</body>
</html>
