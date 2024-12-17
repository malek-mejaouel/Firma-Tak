<?php
// success.php
if (isset($_GET['land_id'])) {
    $land_id = $_GET['land_id'];
    echo "<h1>Land with ID $land_id rented successfully!</h1>";
} else {
    echo "<h1>Error: No land ID provided.</h1>";
}
?>
