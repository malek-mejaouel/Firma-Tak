<?php
require_once '../config/database.php';
require_once '../controller/AuthController.php';

// Instantiate the database connection
$conn = new Database();
$db = $conn->getConnection(); // Use getConnection method instead of connect()

// Instantiate the controller
$controller = new AuthController($db);

// Handle the delete user request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];
    
    // Call the deleteUser method in the controller
    if ($controller->deleteUser($userId)) {
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
                    <a href="#" class="btn">Add New</a>
                    <img src="images/notifications.png" alt="">
                    <div class="img-case">
                        <img src="images/user.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
        <h1>Admin Dashboard</h1>
        
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <table >
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
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" name="delete_user">Delete</button>
                        </form>
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
<td>
<button onclick="openEditForm(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</button></td>

<!-- Edit Modal (Hidden by default) -->
<div id="editModal" style="display:none;">
    <form method="POST" action="">
        <input type="hidden" name="user_id" id="edit_user_id">
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
    <script src="fonction.js"></script>
</body>

</html>