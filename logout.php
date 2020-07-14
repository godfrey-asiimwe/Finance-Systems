<?php
session_start();
session_destroy();
// Redirect to the login page:
$parent = dirname($_SERVER['REQUEST_URI']);
header("Location: login.php");
?>