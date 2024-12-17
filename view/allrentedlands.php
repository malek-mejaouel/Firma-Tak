<?php
require_once '../config/database.php';
require '../controller/LandRentController.php';

// Instantiate the controller
$controller = new LandRentController($conn);

// Fetch rented lands data
$rentedLands = $controller->getRentedLands();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rented Lands</title>

    <!-- Include Bootstrap and DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Rented Lands</h1>

    <?php if (count($rentedLands) > 0): ?>
        <table id="rentedLandsTable" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Land ID</th>
                    <th>Owner</th>
                    <th>Size (Km²)</th>
                    <th>Price per Year</th>
                    <th>Renter Name</th>
                    <th>Renter Phone</th>
                    <th>Rent Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentedLands as $land): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($land['land_id']); ?></td>
                        <td><?php echo htmlspecialchars($land['owner']); ?></td>
                        <td><?php echo htmlspecialchars($land['size_km2']); ?></td>
                        <td>$<?php echo number_format($land['price_per_year'], 2); ?></td>
                        <td><?php echo htmlspecialchars($land['renter_name']); ?></td>
                        <td><?php echo htmlspecialchars($land['renter_phone']); ?></td>
                        <td><?php echo htmlspecialchars($land['rent_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">No rented lands found.</div>
    <?php endif; ?>
</div>

<!-- Include Bootstrap and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#rentedLandsTable').DataTable();
    });
</script>

</body>
</html>
