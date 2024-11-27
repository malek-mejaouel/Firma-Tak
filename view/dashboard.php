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
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <img src="images/logos.png" alt="">&nbsp;<h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="#"><li><img src="images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span> </li></a>
            <a href="#"><li><img src="images/reading-book (1).png" alt="">&nbsp;<span>Offers</span> </li></a>
            <a href="#"><li><img src="images/converted_image_2.png" alt="">&nbsp;<span>Farmers</span> </li></a>
            <a href="#"><li><img src="images/white_image_revised.png">&nbsp;<span>Grocerers</span> </li></a>
            <a href="#"><li><img src="images/payment.png" alt="">&nbsp;<span>Stock</span> </li></a>
            <a href="#"><li><img src="images/help-web-button.png" alt="">&nbsp; <span>Help</span></li></a>
            <a href="#"><li><img src="images/settings.png" alt="">&nbsp;<span>Settings</span> </li></a>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="images/search.png" alt=""></button>

                </div>
                <div class="user">
                <p class="admin-name">
                <?php
                if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] === 'admin') {
                    echo " " . htmlspecialchars($_SESSION['user']['name']);
                }
                ?>
            </p>
            <a href="logout.php" class="btn btn-danger">Logout</a>
            <img src="images/notifications.png" alt="">
                    <div class="img-case">
                        <img src="images/user.png" alt="">
                        <a href="profile.php"><img src="images/user.png" alt="Profile" style="cursor: pointer;"></a>

                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>Admin Dashboard</h1>

            <?php if (isset($message)): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

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
                    <select name="user_type" id="edit_user_type" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
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

    </style>
</body>
</html>
