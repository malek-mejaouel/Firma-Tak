<?php
require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/animals.php');
require_once(__DIR__ . '/../../controller/animalsC.php');

$error = "";
$animal = null;

// Create an instance of the controller
$animalC = new AnimalC(); // Ensure 'AnimalC' is the correct class name

// Check if form is submitted
if (isset($_POST["name"])) {
    // Initialize variables
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $state = trim($_POST['state']);

    // Server-side validation
    if (empty($name)) {
        $error .= "Name is required.<br>";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        // Ensure name contains only letters and spaces
        $error .= "Name can only contain letters and spaces.<br>";
    }

    if (empty($description)) {
        $error .= "Description is required.<br>";
    }

    if (empty($state)) {
        $error .= "State is required.<br>";
    }

    // If no errors, proceed with data handling
    if (empty($error)) {
        // Sanitize inputs to prevent XSS or SQL Injection
        $name = htmlspecialchars($name);
        $description = htmlspecialchars($description);
        $state = htmlspecialchars($state);

        // Create the Animal object
        $animal = new Animal( // Ensure you are using the correct class name 'Animal'
            null,
            $name,
            $description,
            $state
        );

        // Add the animal to the database
        $animalC->addAnimal($animal);

        // Redirect to the list page
        header('Location: animalsindex.php');
        exit; // Always exit after a header redirect
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Animal</title>
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
            padding: 10px;
        }

        td {
            padding: 10px;
        }

        label {
            font-weight: bold;
        }

        #error {
            color: red;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <!-- "Back to List" link -->
    <a href="animalsindex.php">Back to list</a>
    <hr>

    <!-- Display error messages if any -->
    <div id="error">
        <?php 
            if (!empty($error)) {
                echo "<div style='color: red;'>$error</div>";
            }
        ?>
    </div>

    <!-- Form for adding an animal -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td>
                    <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" />
                </td>
            </tr>
            <tr>
                <td><label for="description">Description:</label></td>
                <td>
                    <textarea id="description" name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
                </td>
            </tr>
            <tr>
                <td><label for="state">State:</label></td>
                <td>
                    <select id="state" name="state">
                        <option value="">Select State</option>
                        <option value="Tunis" <?php echo (isset($state) && $state == 'Tunis') ? 'selected' : ''; ?>>Tunis</option>
                        <option value="Sfax" <?php echo (isset($state) && $state == 'Sfax') ? 'selected' : ''; ?>>Sfax</option>
                        <option value="Kairouan" <?php echo (isset($state) && $state == 'Kairouan') ? 'selected' : ''; ?>>Kairouan</option>
                        <option value="Sousse" <?php echo (isset($state) && $state == 'Sousse') ? 'selected' : ''; ?>>Sousse</option>
                        <option value="Monastir" <?php echo (isset($state) && $state == 'Monastir') ? 'selected' : ''; ?>>Monastir</option>
                        <option value="Gabès" <?php echo (isset($state) && $state == 'Gabès') ? 'selected' : ''; ?>>Gabès</option>
                        <option value="Nabeul" <?php echo (isset($state) && $state == 'Nabeul') ? 'selected' : ''; ?>>Nabeul</option>
                        <option value="Kébili" <?php echo (isset($state) && $state == 'Kébili') ? 'selected' : ''; ?>>Kébili</option>
                        <option value="Zaghouan" <?php echo (isset($state) && $state == 'Zaghouan') ? 'selected' : ''; ?>>Zaghouan</option>
                        <option value="Bizerte" <?php echo (isset($state) && $state == 'Bizerte') ? 'selected' : ''; ?>>Bizerte</option>
                        <option value="Jendouba" <?php echo (isset($state) && $state == 'Jendouba') ? 'selected' : ''; ?>>Jendouba</option>
                        <option value="Mahares" <?php echo (isset($state) && $state == 'Mahares') ? 'selected' : ''; ?>>Mahares</option>
                        <option value="L'Ariana" <?php echo (isset($state) && $state == 'L\'Ariana') ? 'selected' : ''; ?>>L'Ariana</option>
                        <option value="Le Kef" <?php echo (isset($state) && $state == 'Le Kef') ? 'selected' : ''; ?>>Le Kef</option>
                        <option value="Siliana" <?php echo (isset($state) && $state == 'Siliana') ? 'selected' : ''; ?>>Siliana</option>
                        <option value="Beja" <?php echo (isset($state) && $state == 'Beja') ? 'selected' : ''; ?>>Beja</option>
                        <option value="Ben Arous" <?php echo (isset($state) && $state == 'Ben Arous') ? 'selected' : ''; ?>>Ben Arous</option>
                        <option value="La Manouba" <?php echo (isset($state) && $state == 'La Manouba') ? 'selected' : ''; ?>>La Manouba</option>
                        <option value="Kassérine" <?php echo (isset($state) && $state == 'Kassérine') ? 'selected' : ''; ?>>Kassérine</option>
                        <option value="Sidi Bouzid" <?php echo (isset($state) && $state == 'Sidi Bouzid') ? 'selected' : ''; ?>>Sidi Bouzid</option>
                        <option value="Tataouine" <?php echo (isset($state) && $state == 'Tataouine') ? 'selected' : ''; ?>>Tataouine</option>
                        <option value="Mahdia" <?php echo (isset($state) && $state == 'Mahdia') ? 'selected' : ''; ?>>Mahdia</option>
                        <option value="Médenine" <?php echo (isset($state) && $state == 'Médenine') ? 'selected' : ''; ?>>Médenine</option>
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
</body>
</html>
