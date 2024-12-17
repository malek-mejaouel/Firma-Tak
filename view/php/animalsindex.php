<?php


require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/animals.php');
require_once(__DIR__ . '/../../controller/animalsC.php');


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

try {
    $db = ( new Database())->getConnection();
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create an instance of AnimalC
$animalC = new AnimalC();

// Check if there's a search query
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // Default sort by 'name'
$validSortColumns = ['name', 'description', 'state'];

$sort = isset($_GET['sort']) && in_array($_GET['sort'], $validSortColumns) ? $_GET['sort'] : 'name';  // Default to 'name'
// Fetch the list of animals based on the search query and sort order
$animals = $animalC->listAnimals($search, $sort);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        h1,
        h2 {
            color: #444;
        }

        h3 {
            color: #999;
        }

        .btn {
            background: #6b7908;
            color: white;
            padding: 5px 10px;
            text-align: center;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            display: inline-block;
        }

        .btn:hover {
            color: #6b7908;
            background: white;
            padding: 3px 8px;
            border: 2px solid #6b7908;
        }

        .title {
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 15px 10px;
            border-bottom: 2px solid #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0; /* Remove any space between table cells */
        }

        th, td {
            border: 3px solid #ddd;
            padding: 2px 4px; /* Reduced padding to make cells tighter */
            text-align: left;
            font-size: 15px; /* Slightly smaller font for compactness */
        }

        th {
            background-color: #f2f2f2;
        }

        /* Ensure table links are black */
        table a {
            color: black; /* Ensure links in the table are black */
            text-decoration: none; /* Remove underline if any */
        }

        /* Optional: style for hover effect to keep it consistent */
        table a:hover {
            color: #333; /* Slightly darker shade of black for hover effect */
            background: none; /* Remove any background on hover */
        }

        /* Side menu styles */
        .side-menu {
            position: fixed;
            background : #6b7908;
            width: 20vw;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            padding-left: 10px;
        }

        .side-menu .brand-name {
            height: 10vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .side-menu li {
            font-size: 20px;
            padding: 10px 30px;
            color: white;
            display: flex;
            align-items: center;
        }

        .side-menu li:hover {
            background: rgb(0, 0, 0);
            color: #6b7908;
        }

        /* Main content container */
        .container {
            position: absolute;
            left: 20vw;
            width: 60vw;
            height: 100vh;
            background: #f1f1f1;
            padding: 10px;
        }

        .historical {
            position: absolute;
            right: 0;
            width: 20vw;
            height: 100vh;
            background: #e1e1e1;
            padding: 10px;
            overflow-y: auto;
            display: none; /* Initially hidden */
        }

        .historical-search {
            margin-bottom: 10px;
        }

        .historical-search input {
            padding: 5px;
            width: calc(100% - 12px);
            margin-right: 10px;
        }

        .historical-search button {
            padding: 5px 10px;
        }

        .toggle-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #6b7908;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .toggle-btn:hover {
            background: white;
            color: #6b7908;
            border: 2px solid #6b7908;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #6b7908;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .close-btn:hover {
            background: white;
            color: #6b7908;
            border: 2px solid #6b7908;
        }

        .historical p {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .historical p:last-child {
            border-bottom: none;
        }

        /* Highlight search term in red */
        .highlight {
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
        function toggleHistorical() {
            var historicalSection = document.querySelector('.historical');
            if (historicalSection.style.display === 'none' || historicalSection.style.display === '') {
                historicalSection.style.display = 'block';
            } else {
                historicalSection.style.display = 'none';
            }
        }

        function filterHistorical() {
            var input = document.getElementById('historicalSearch');
            var filter = input.value.toLowerCase();
            var historicalSection = document.querySelector('.historical');
            var items = historicalSection.getElementsByTagName('p');

            for (var i = 0; i < items.length; i++) {
                var txtValue = items[i].textContent || items[i].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    items[i].style.display = '';
                } else {
                    items[i].style.display = 'none';
                }
            }
        }

        function sortHistorical(criteria) {
            var historicalSection = document.querySelector('.historical');
            var items = Array.from(historicalSection.getElementsByTagName('p'));
            items.sort((a, b) => {
                var aText = a.textContent || a.innerText;
                var bText = b.textContent || b.innerText;
                if (criteria === 'date') {
                    var aDate = new Date(aText.split('added on ')[1]);
                    var bDate = new Date(bText.split('added on ')[1]);
                    return aDate - bDate;
                } else {
                    return aText.localeCompare(bText);
                }
            });
            items.forEach(item => historicalSection.appendChild(item));
        }
    </script>
</head>
<body>
    <!-- Side menu -->
    
    <!-- Main content -->
    <div class="container">
        <h1>List of Animals</h1>

        <!-- Search form -->
        <form method="GET" action="animalsindex.php">
            <input type="text" name="search" placeholder="Search by name or description" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
            <button type="submit" class="btn">Search</button>
            <br><br>
        </form>

        <!-- Add link to add a new animal -->
        <p class="add-link">
            <a href="add.php">Add New Animal</a>
            <a href="statistics.php" class="btn">Statistics</a>
        </p>

        <table>
            <tr>
                <th><a href="?sort=id">ID</a></th>
                <th><a href="?sort=name">Name</a></th>
                <th><a href="?sort=description">Description</a></th>
                <th><a href="?sort=state">State</a></th>
                <th>Actions</th>
            </tr>
            <?php
            // Check if there are any animals to display
            if ($animals && count($animals) > 0) {
                // Loop through the results and display each animal
                foreach ($animals as $animal) {
                    // Highlight search term in animal name and description
                    $highlighted_name = isset($search) ? str_ireplace($search, "<span class='highlight'>" . $search . "</span>", $animal['name']) : $animal['name'];
                    $highlighted_desc = isset($search) ? str_ireplace($search, "<span class='highlight'>" . $search . "</span>", $animal['description']) : $animal['description'];

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($animal['id']) . "</td>";
                    echo "<td>" . $highlighted_name . "</td>";
                    echo "<td>" . $highlighted_desc . "</td>";
                    echo "<td>" . htmlspecialchars($animal['state']) . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . htmlspecialchars($animal['id']) . "' class='btn'>Edit</a> |
                            <a href='delete.php?id=" . htmlspecialchars($animal['id']) . "' class='btn'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No animals found.</td></tr>";
            }
            ?>
        </table>
    </div>

    <button class="toggle-btn" onclick="toggleHistorical()">Toggle Historical Data</button>

    <div class="historical">
        <h2>Historical Data</h2>
        <button class="close-btn" onclick="toggleHistorical()">Close</button>
        <div class="historical-search">
            <br><br><br>
            <input type="text" id="historicalSearch" onkeyup="filterHistorical()" placeholder="Search historical data...">
            <button onclick="sortHistorical('date')">Sort by Date</button>
            <button onclick="sortHistorical('id')">Sort by ID</button>
        </div>
        <?php
        if ($animals && count($animals) > 0) {
            foreach ($animals as $animal) {
                echo "<p>Animal ID: " . htmlspecialchars($animal['id']) . " added on " . htmlspecialchars($animal['created_at'] ?? '') . "</p>";
            }
        } else {
            echo "<p>No historical data available.</p>";
        }
        ?>
    </div>
</body>
</html>
