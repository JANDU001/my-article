<?php
require_once 'session.php';
require_once 'user.php';

Session::start();

// Authenticate user and check user type
Session::authenticateUser();

// Add HTML content for managing users
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>

<body>
    <h2>Manage Users</h2>
    <!-- Add content for managing users here -->
    <a href="adduser.php">Add New User</a><br>
    <a href="listusers.php">List All Users</a><br>
    <a href="exportusers.php">Export Users</a><br>
    <!-- Add other user management links -->
    <a href="logout.php">Logout</a>
</body>

</html>

