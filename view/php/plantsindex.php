<?php
// Include the necessary files to set up database connection and models

require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/plants.php');
require_once(__DIR__ . '/../../controller/plantsC.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

try {
    // Establish the database connection using config
    $db = ( new Database())->getConnection();
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create an instance of PlantC (the controller class for Plant)
$plantC = new PlantC();

// Check if there's a search query
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'namep'; // Default sort by 'namep'
$validSortColumns = ['namep', 'descriptionp', 'statep'];

$sort = isset($_GET['sort']) && in_array($_GET['sort'], $validSortColumns) ? $_GET['sort'] : 'namep';  // Default to 'namep'
// Fetch the list of plants based on the search query and sort order
$plants = $plantC->listPlants($search, $sort);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant List</title>
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
            border-radius: 4px;
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

        .side-menu {
            position: fixed;
            background: #6b7908;
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

        table a {
            color: black; /* Ensure links in the table are black */
            text-decoration: none; /* Remove underline if any */
        }

        /* Optional: style for hover effect to keep it consistent */
        table a:hover {
            color: #333; /* Slightly darker shade of black for hover effect */
            background: none; /* Remove any background on hover */
        }

        th, td {
            border: 12px solid #ddd;
            padding: 2px 4px;
            text-align: left;
            font-size: 15px;
        }

        th {
            background-color: #f2f2f2;
        }

        .highlight {
            color: red;
            font-weight: bold;
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
    <div class="side-menu">
        <!-- Side menu content -->
        <div class="brand-name">
            <img src="images/logos.png" alt="">&nbsp;<h2>FIRMA-TAK</h2>
        </div>
        <ul>
            
        <a href="http://localhost/usercrud/view/profile.php"><li><img src="images/reading-book (1).png" alt="">&nbsp;<span>PROFILE</span> </li></a>
            <a href="http://localhost/usercrud/view/farmer.php"><li><img src="images/converted_image_2.png" alt="">&nbsp;<span>Statistics</span> </li></a>
            <a href="http://localhost/usercrud/view/feedb.php"><li><img src="images/white_image_revised.png">&nbsp;<span>messages box</span> </li></a>
            <a href="http://localhost/usercrud/view/message.php"><li><img src="images/payment.png" alt="">&nbsp;<span>tri</span> </li></a>
            <a href="http://localhost/usercrud/view/pub.php"><li><img src="images/help-web-button.png" alt="">&nbsp; <span>Help</span></li></a>
            <a href="http://localhost/usercrud/view/php/animalsindex.php"><li><img src="images/converted_image_2.png" alt="">&nbsp;<span>AnimalsIndex</span></li></a>
            <a href="http://localhost/usercrud/view/php/plantsindex.php"><li><img src="images/white_image_revised.png">&nbsp;<span>plants</span></li></a>
           
        </ul>
    </div>

    <div class="container">
        <h1>List of Plants</h1>
        <p class="add-link">
            <a href="addp.php"></a>
        </p>

        <!-- Search form -->
        <form method="GET" action="plantsindex.php">
            <input type="text" name="search" placeholder="Search by name or description" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
            <button type="submit" class="btn">Search</button>
            <br><br>
        </form>

        <p>
            <a href="addp.php" class="btn">Add New Plant</a>
            <a href="statistics2.php" class="btn">Statistics</a>
        </p>

        <table>
            <tr>
                <th><a href="?sort=ido">ID</a></th>
                <th><a href="?sort=namep">Name</a></th>
                <th><a href="?sort=descriptionp">Description</a></th>
                <th><a href="?sort=statep">State</a></th>
                <th>Actions</th>
            </tr>

            <?php
            if ($plants && count($plants) > 0) {
                foreach ($plants as $plant) {
                    // Highlight search term in plant name and description
                    $highlighted_name = isset($search) ? str_ireplace($search, "<span class='highlight'>" . $search . "</span>", $plant['namep']) : $plant['namep'];
                    $highlighted_desc = isset($search) ? str_ireplace($search, "<span class='highlight'>" . $search . "</span>", $plant['descriptionp']) : $plant['descriptionp'];

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($plant['ido'] ?? '') . "</td>";
                    echo "<td>" . $highlighted_name . "</td>";
                    echo "<td>" . $highlighted_desc . "</td>";
                    echo "<td>" . htmlspecialchars($plant['statep'] ?? '') . "</td>";
                    echo "<td>
                            <a href='editp.php?id=" . htmlspecialchars($plant['ido'] ?? '') . "' class='btn'>Edit</a> |
                            <a href='deletep.php?id=" . htmlspecialchars($plant['ido'] ?? '') . "' class='btn'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No plants found.</td></tr>";
            }
            ?>
        </table>
    </div>

    <button class="toggle-btn" onclick="toggleHistorical()">Toggle Historical Data</button>

    <div class="historical">
        <h2>Historical Data</h2>
        <button class="close-btn" onclick="toggleHistorical()">Close</button>
        <div class="historical-search">
            <br> <br>  <br> 
            <input type="text" id="historicalSearch" onkeyup="filterHistorical()" placeholder="Search historical data...">

            <button onclick="sortHistorical('date')">Sort by Date</button>
            <button onclick="sortHistorical('id')">Sort by ID</button>
        </div>
        <?php
        if ($plants && count($plants) > 0) {
            foreach ($plants as $plant) {
                echo "<p>Plant ID: " . htmlspecialchars($plant['ido'] ?? '') . " added on " . htmlspecialchars($plant['created_at'] ?? '') . "</p>";
            }
        } else {
            echo "<p>No historical data available.</p>";
        }
        ?>
    </div>
</body>
</html>
