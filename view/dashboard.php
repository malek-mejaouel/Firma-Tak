<?php
require_once '../config/database.php';
require_once '../controller/AuthController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in


if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header('Location: log.php'); // Redirect to login if not an admin
    exit();
}
// Instantiate the database connection
$conn = new Database();
$db = $conn->getConnection(); // Use getConnection method instead of connect()

// Instantiate the controller
$controller = new AuthController($db);

// Handle the delete user request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];
    
    // Check if the admin password is required for deletion (for admin users)
    $adminPassword = isset($_POST['admin_password']) ? $_POST['admin_password'] : null;
    
    // Call the deleteUser method in the controller
    if ($controller->deleteUser($userId, $adminPassword)) {
        echo "<script>alert('User deleted successfully.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to delete user. Please try again.');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $userId = $_POST['user_id']; // Get the user ID from the hidden input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Password can be blank if not changed
    $userType = $_POST['user_type'];

    // Call the editUser method in your AuthController
    if ($controller->editUser($userId, $name, $email, $password, $userType)) {
        echo "<script>alert('User updated successfully!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update user. Please try again.');</script>";
    }
}

// Fetch users for display
$users = $controller->listUser();

// Récupérez les utilisateurs récents
   // Assume $authController is an instance of the AuthController class
   $authController = new AuthController($db);

// Get the most recent user (make sure getRecentUser is returning data)
$newUser = $authController->getRecentUser(); // This should now be assigned before use

// Check if $newUser has data
if ($newUser) {
   // echo "User: " . htmlspecialchars($newUser['name']) . ", Email: " . htmlspecialchars($newUser['email']);
} else {
    echo "No new users.";
}

// Check if session messages exist and are an array
if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $admin = $_SESSION['user'];  // Get the admin's profile data

    // Get the user's profile picture (if any)
    $profilePicture = !empty($admin['profile_picture']) ? $admin['profile_picture'] : 'default_profile_picture.png'; // Provide a default image if none exists

    // You can now use $profilePicture and other session data
} else {
    // Handle case where session is not properly set
    echo "No user session found.";
}

 
   // Now you can call getRecentUser

    // Check if session messages exist and are an array
    
    $admin = $_SESSION['user']; 

    // Get the user's profile picture (if any)
    $profilePicture = !empty($admin['profile_picture']) ? $admin['profile_picture'] : 'uploads/default.jpg'; // Default profile picture if none set
    ?>
    

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALPHA Web Admin Panel</title>
    <link rel="stylesheet" href="styles.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Base Styles */
        body {
            background-color: #fff;
            color: #6b7908;
        }
        body.dark-mode .container .content {
    background: #1e1e1e; /* Dark content area */
}


        
        .dark-mode {
            background-color: #6b7908;
            color: #6b7908;
        }
        
        .dark-mode .btn {
            background-color: #4b6b3f;
            color: #6b7908;
        }
        
        .dark-mode .btn:hover {
            background: white;
            color: #6b7908;
        }
        
        .dark-mode .side-menu {
            background: #6b7908;
        }
        
        .dark-mode .container {
            background:#6b7908;
        }

        /* Additional dark mode styles */
    </style>
    <style>
    .notifications {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        padding: 10px;
        z-index: 1;
        right: 0;
    }

    .notifications:hover .dropdown-content {
        display: block;
    }

    .dropdown-content h4 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .dropdown-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .dropdown-content ul li {
        font-size: 14px;
        margin: 5px 0;
        color: #555;
  
    }
    .search {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    gap: 10px; /* Optional: Space between input and button */
    width: 100%; /* Full width */
    max-width: 600px; /* Optional: Limit width if necessary */
    margin: 0 auto; /* Center in the parent container */
}

/* Style for the label */
.search-label {
    font-size: 14px; /* Adjust font size */
    margin-right: 10px; /* Space between label and input */
}

/* Style for the input */
.search input {
    padding: 8px;
    font-size: 14px;
    width: 200px; /* Adjust width of the input */
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Style for the button */
.search button {
    padding: 8px;
    background-color: #6b7908;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.search button img {
    width: 16px; /* Smaller search icon size */
    height: 16px;
}
   
</style>
<style>
    .messages img {
        width: 24px; /* Adjust the width of the icon */
        height: 24px; /* Adjust the height of the icon */
        margin-right: 0.5cm; /* Move the icon to the left by 4cm */

    }
    /* Global reset for consistency */
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

h1, h2 {
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
    padding: 10px;
}

th, td {
    text-align: left;
    padding: 8px;
}

/* Side Menu */
.side-menu {
    position: fixed;
    top: 0;
    left: 0;
    background: #6b7908;
    width: 20vw;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    z-index: 10;
}

.side-menu .brand-name {
    height: 10vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #4b6b3f; /* Slightly darker background for brand */
}

.side-menu li {
    font-size: 24px;
    padding: 10px 40px;
    color: white;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease;
}

.side-menu li:hover {
    background: rgb(0, 0, 0);
    color: #6b7908;
}

.side-menu .brand-name h1 {
    font-size: 24px;
    color: white;
}

.container {
    margin-left: 20vw; /* Offset container to the right of the side menu */
    width: 80vw;
    min-height: 100vh;
    background: #f1f1f1;
}

.container .header {
    position: fixed;
    top: 0;
    right: 0;
    width: 80vw;
    height: 10vh;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.container .header .nav {
    width: 90%;
    display: flex;
    align-items: center;
}

.container .header .nav .user {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.container .header .nav .user img {
    width: 40px;
    height: 40px;
}

.container .content {
    margin-top: 10vh;
    min-height: 90vh;
    background: #f1f1f1;
    padding: 20px;
}

.container .content .cards {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.container .content .cards .card {
    width: 250px;
    height: 150px;
    background: white;
    margin: 20px 10px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
}

.container .content .content-2 {
    min-height: 60vh;
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    flex-wrap: wrap;
}

.container .content .content-2 .recent-payments {
    min-height: 50vh;
    flex: 5;
    background: white;
    margin: 0 25px 25px 25px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}

.container .content .content-2 .new-students {
    flex: 2;
    background: white;
    min-height: 50vh;
    margin: 0 25px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}

.container .content .content-2 .new-students table td:nth-child(1) img {
    height: 40px;
    width: 40px;
}

@media screen and (max-width: 1050px) {
    .side-menu li {
        font-size: 18px;
    }
}

@media screen and (max-width: 940px) {
    .side-menu li span {
        display: none;
    }
    .side-menu {
        align-items: center;
    }
    .side-menu li img {
        width: 40px;
        height: 40px;
    }
    .side-menu li:hover {
        background: #912F56;
        padding: 8px 38px;
        border: 2px solid white;
    }
}

@media screen and (max-width: 536px) {
    .brand-name h1 {
        font-size: 16px;
    }
    .container .content .cards {
        justify-content: center;
    }
    .side-menu li img {
        width: 30px;
        height: 30px;
    }
    .container .content .content-2 .recent-payments table th:nth-child(2),
    .container .content .content-2 .recent-payments table td:nth-child(2) {
        display: none;
    }
    .chart-container {
        margin: 20px;
        padding: 15px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .chart-container h3 {
        color: #444;
        margin-bottom: 10px;
        text-align: center;
    }
    
    canvas {
        max-width: 100%;
        height: 300px;
    }
}

/* Dark Mode Global Styles */
body.dark-mode {
    background-color: #121212; /* Dark background */
    color: #254a1b; /* Light text color */
}

body.dark-mode h1, 
body.dark-mode h2, 
body.dark-mode h3 {
    color: #22412e; /* Light color for headers */
}

/* Buttons */
body.dark-mode .btn {
    background: #4b6b3f; /* Darker button background */
    color: rgb(48, 78, 51);
}

body.dark-mode .btn:hover {
    background: white;
    color: #4b6b3f;
    border: 2px solid #4b6b3f;
}

/* Sidebar */
body.dark-mode .side-menu {
    background: #2a3d26; /* Dark sidebar */
}

body.dark-mode .side-menu li:hover {
    background: #4c7c2e; /* Dark hover effect */
    color: #6b7908;
}

/* Container */
body.dark-mode .container {
    background: #1e1e1e; /* Dark content background */
}

/* Header */
body.dark-mode .container .header {
    background: #333; /* Dark header */
}

/* Table */
body.dark-mode table, 
body.dark-mode th, 
body.dark-mode td {
    border-color: #444; /* Dark border color */
}

/* Content */
body.dark-mode .container .content {
    background: #28652d; /* Dark content area */
}

</style>
    
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <img src="images/logos.png" alt="">&nbsp;<h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="profile.php"><li><img src="images/reading-book (1).png" alt="">&nbsp;<span>PROFILE</span> </li></a>
            <a href="farmer.php"><li><img src="images/converted_image_2.png" alt="">&nbsp;<span>Statistics</span> </li></a>
            <a href="feedb.php"><li><img src="images/white_image_revised.png">&nbsp;<span>messages box</span> </li></a>
            <a href="message.php"><li><img src="images/payment.png" alt="">&nbsp;<span>tri</span> </li></a>
            <a href="pub.php"><li><img src="images/new.png" alt="">&nbsp; <span>pub settings</span></li></a>
            <a href="http://localhost/usercrud/view/php/animalsindex.php"><li><img src="images/converted_image_2.png" alt="">&nbsp;<span>animals</span> </li></a>
            <a href="http://localhost/usercrud/view/php/plantsindex.php"><li><img src="images/converted_image_2.png" alt="">&nbsp;<span>plants</span> </li></a>
            <a href="listback.php"><li><img src="images/settings.png" alt="">&nbsp;<span>Events</span> </li></a>
            <a href="prod.php"><li><img src="images/new.png" alt="">&nbsp;<span>products</span> </li></a>
            <a href="listLands.php"><li><img src="images/new.png" alt="">&nbsp;<span>land</span> </li></a>


        </ul>

    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                <form method="POST" action="user_details.php">
                <label for="search_term">Search for User: </label>

    <input type="text" name="search_term" id="search_term" required>
        <button type="submit"><img src="images/search.png" alt=""></button>


    </form>

                </div>
                <div class="messages">
            
            

                <div class="messages">
    <!-- Wrap the image with an anchor tag to navigate to the messages page -->
    <a href="usercrud/view/feedb.php"> <img src="images/email.png" alt="Messages" title="Go to Messages"> </a>
    </a>
</div>
    
</div>
                <div class="user">
               
            <li><button id="darkModeButton" onclick="toggleDarkMode()">🌙</button></li>

            <a href="logout.php" class="btn btn-danger">Logout</a>
            <div class="notifications">
                        <img src="images/notifications.png" alt="Notifications">
                        <div class="dropdown-content">
                            <h4>Recently Added Users</h4>
                            <?php if ($newUser): ?>
                                <ul>
                                    <li><?php echo htmlspecialchars($newUser['name']) . " (" . htmlspecialchars($newUser['email']) . ")"; ?></li>
                                </ul>
                            <?php else: ?>
                                <p>No new users.</p>
                            <?php endif; ?>
                        </div>
                    </div> <div class="img-case">
                        <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" style="max-width: 150px;">
                    </div>
                    <p class="admin-name">
                <?php
                if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] === 'admin') {
                    
                    echo " " . htmlspecialchars($_SESSION['user']['name']);
                    
                }
                ?>
            </p>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>Admin Dashboard</h1>

          

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                                <td>
                                    <!-- Action buttons below each other -->
                                    <form method="POST" action="" style="display: block; margin-bottom: 5px;">
                                         <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <!-- Show the password input field if the user is an admin -->
                    <?php if ($user['user_type'] === 'admin'): ?>
                        <label for="admin_password">Admin Password:</label>
                        <input type="password" name="admin_password" required>
                    <?php endif; ?>
                    <button type="submit" name="delete_user" class="delete-button">Delete</button>
                </form>
                                    <button class="edit-button" onclick="openEditForm(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Modal for Edit User -->
            <div id="editModal" style="display:none;">
                <form method="POST" action="" class="edit-form">
                    <label>id:</label>
                    <input type="text" name="user_id" id="edit_user_id">
                    <label>Name:</label>
                    <input type="text" name="name" id="edit_name" required>
                    <label>Email:</label>
                    <input type="email" name="email" id="edit_email" required>
                    <label>Password (Leave blank to keep current):</label>
                    <input type="password" name="password" id="edit_password">
                    <label>User Type:</label>
                    <label>User Type:</label>
<select name="user_type" id="edit_user_type" required>
    <option value="admin">Admin</option>
    <option value="fermier">Fermier</option>
    <option value="vendeur">Vendeur</option>
</select>
                    <button type="submit" name="edit_user">Save Changes</button>
                    <button type="button" onclick="closeEditForm()">Cancel</button>
                </form>
            </div>

            <!-- JavaScript for Modal -->
            <script>
                function openEditForm(user) {
                    document.getElementById('edit_user_id').value = user.id; // Set user ID
                    document.getElementById('edit_name').value = user.name; 
                    document.getElementById('edit_email').value = user.email; 
                    document.getElementById('edit_user_type').value = user.user_type; 
                    document.getElementById('edit_password').value = ''; // Clear password field
                    document.getElementById('editModal').style.display = 'block';
                }

                function closeEditForm() {
                    document.getElementById('editModal').style.display = 'none';
                }
            </script>

        </div>
    </div>

    <script src="fonction.js"></script>
    <style>
       h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

table td button {
    padding: 6px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Delete button styles */
table td button.delete-button {
    background-color:#6b7908; /* Red for delete */
    color: white;
}

table td button.delete-button:hover {
    background-color: #6b7908; /* Darker red on hover */
}

/* Edit button styles */
table td button.edit-button {
    background-color: #6b7908; /* Blue for edit */
    color: white;
}

table td button.edit-button:hover {
    background-color: #6b7908; /* Darker blue on hover */
}

table {
    width: 70%;
    margin: 12px auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    text-align: left;
    padding: 12px 19px;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #6b7908;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    font-weight: 500;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

table button {
    padding: 6px 12px;
    background-color: #6b7908;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

table button:hover {
    background-color: #5a6907;
}

#editModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 20px;
    z-index: 10;
    width: 40%;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#editModal label {
    font-weight: bold;
    font-size: 14px;
    color: #444;
}

#editModal input, #editModal select {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
    margin-bottom: 10px;
}

#editModal button {
    padding: 8px 15px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#editModal button[type="submit"] {
    background-color: #6b7908;
    color: #fff;
}

#editModal button[type="submit"]:hover {
    background-color: #5a6907;
}

#editModal button[type="button"] {
    background-color: #ddd;
}

#editModal button[type="button"]:hover {
    background-color: #ccc;
}

/* Modal background overlay */
#editModal::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #d1ebca;
    z-index: -1;
}

button.edit-button {
    background-color: #FFA500; /* Orange color for Edit button */
    color: white;
    border: none;
    padding: 8px 12px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Hover effect */
button.edit-button:hover {
    background-color: #FF8C00; /* Darker orange */
    transform: scale(1.05); /* Slight zoom on hover */
}

/* Focus effect */
button.edit-button:focus {
    outline: 2px solid #FFD700; /* Gold outline for focus */
}

/* Center align "No users found" message */
tbody tr td[colspan="5"] {
    text-align: center;
    font-style: italic;
    color: #666;
}
.admin-name {
    font-size: 16px;
    color: #333;
    margin-top: 10px;
    margin-left: 10px;
    font-weight: bold;
}
/* Hide the dropdown by default */
.messages {
    position: relative;
    display: inline-block;
}

#emailIcon {
    cursor: pointer;
    width: 24px;
    height: 24px;
}

.dropdown-content {
    display: none; /* Initially hidden */
    position: absolute;
    top: 30px; /* Adjust to position the dropdown below the icon */
    left: 0;
    background-color: #f9f9f9;
    min-width: 200px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    padding: 10px;
    z-index: 1;
}

.dropdown-content h4 {
    margin: 0;
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.dropdown-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dropdown-content ul li {
    font-size: 14px;
    margin: 5px 0;
    color: #555;
}
    </style>
    

</style>
<script>
  // Toggle Dark Mode
function toggleDarkMode() {
    const body = document.body;
    const button = document.getElementById('darkModeButton');

    // Toggle the 'dark-mode' class on the body element
    body.classList.toggle('dark-mode');

    // Update button text based on dark mode state
    if (body.classList.contains('dark-mode')) {
        button.textContent = '🌞'; // Sun icon when dark mode is active
    } else {
        button.textContent = '🌙'; // Moon icon when dark mode is inactive
    }
}
</script>
<script>
    document.querySelector('.messages img').addEventListener('click', function() {
        var dropdown = document.querySelector('.dropdown-content');
        dropdown.style.display = (dropdown.style.display === 'block' ? 'none' : 'block');
    });
</script>
</body>
</html>
