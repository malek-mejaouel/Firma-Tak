<?php
require_once '../config/database.php';

// Handle rental form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $land_id = $_POST['land_id'];
    $renter_name = $_POST['renter_name'];
    $renter_phone = $_POST['renter_phone'];

    // Insert rental information into rented_lands table
    $insertSql = "INSERT INTO rented_lands (land_id, renter_name, renter_phone) VALUES (:land_id, :renter_name, :renter_phone)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bindParam(':land_id', $land_id);
    $stmt->bindParam(':renter_name', $renter_name);
    $stmt->bindParam(':renter_phone', $renter_phone);

    if ($stmt->execute()) {
        // Update land status to 'rented'
        $updateSql = "UPDATE lands SET status = 'rented' WHERE land_id = :land_id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':land_id', $land_id);
        $updateStmt->execute();

        echo "<script>alert('Land rented successfully!'); window.location.href='LandRented.php';</script>";
    } else {
        echo "<script>alert('Failed to rent the land.');</script>";
    }
}

// Fetch all available lands for rental
$sqlAvailableLands = "SELECT land_id, owner FROM lands WHERE status = 'available'";
$stmtAvailable = $conn->prepare($sqlAvailableLands);
$stmtAvailable->execute();
$availableLands = $stmtAvailable->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Land</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Rent a Land</h1>

    <!-- Rental Form -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="land_id">Select Land</label>
            <select class="form-control" id="land_id" name="land_id" required>
                <option value="">Select a Land</option>
                <?php foreach ($availableLands as $land): ?>
                    <option value="<?php echo $land['land_id']; ?>"><?php echo $land['land_id'] . ' - ' . $land['owner']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="renter_name">Renter Name</label>
            <input type="text" class="form-control" id="renter_name" name="renter_name" required>
        </div>
        <div class="form-group">
            <label for="renter_phone">Renter Phone</label>
            <input type="text" class="form-control" id="renter_phone" name="renter_phone" required>
        </div>
        <button type="submit" class="btn btn-success btn-block">Rent Land</button>
    </form>

    <br>
    <a href="showcaseLands.php" class="btn btn-info">Go back</a>
</div>

</body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<footer>
        <div class="footer-container">
            <div class="sec aboutus">
                <h2>About Us</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus quisquam minus quo illo numquam vel incidunt pariatur hic commodi expedita tempora praesentium at iure fugiat ea, quam laborum aperiam veritatis.</p>
                <ul class="sci">
                    <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                    <li><a href="#"><i class="bx bxl-instagram"></i></a></li>
                    <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                    <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="sec quicklinks">
                <h2>Quick Links</h2>
                <ul>
                    <><a href="#">Home</a>
                    <><a href="#">About</a>
                </ul>
            </div>
            <div class="sec contactBx">
                <h2>Contact Info</h2>
                <ul class="info">
                    <li>
                        <span><i class='bx bxs-map'></i></span>
                        <span>8081 bizerte <br> north bizerte 33445 <br> TUN</span>
                    </li>
                    <li>
                        <span><i class='bx bx-envelope'></i></span>
                        <p><a href="mailto:kingmejaouel@gmail.com">Kingmejaouel@gmail.com</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <style> footer{
    position: relative;
    width: 100%;
    height: auto;
    padding: 50px 100px;
    margin-top: 3rem;
    background: #111;
    display: flex;
    font-family: sans-serif;
    justify-content: space-between;
}

.footer-container{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    flex-direction: row;
}

.footer-container .sec{
    margin-right: 30px;
}

.footer-container .sec.aboutus{
    width: 40%;
}

.footer-container h2{
    position: relative;
    color: #fff;
    margin-bottom: 15px;
}

.footer-container h2::before{
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50px;
    height: 2px;
    background: rgb(77, 228, 255);
}

footer p{
    color: #fff;
}
</style>
</html>
