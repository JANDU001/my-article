<?php
require_once 'session.php';

Session::start();

// Destroy the session and redirect to the login page
Session::destroy();
header("Location: index.php");
exit();
?>
