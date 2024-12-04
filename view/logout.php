<<<<<<< HEAD
<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: log.php");
exit();
=======
<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: log.php");
exit();
>>>>>>> 37c0a90981e4f7e7c4f904f49623766305824530
?>