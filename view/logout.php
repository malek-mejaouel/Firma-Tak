<?php
session_start();
session_unset();
session_destroy();

// Redirect to login or homepage
header("Location: log.php");
exit();
?>