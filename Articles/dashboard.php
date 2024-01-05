<?php
require_once 'session.php';

Session::start();

// Authenticate user and check user type
Session::authenticateUser();

// Check user type
$userType = $_SESSION['userType'];

// Add HTML content for the dashboard based on user type
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h2>Welcome to the Dashboard</h2>

    <?php if ($userType === 'Super_User') : ?>
        <!-- Content for Super User -->
        <a href="updateprofile.php">Update Profile</a><br>
        <a href="manageusers.php">Manage Users</a><br>
        <a href="viewarticles.php">View Articles</a><br>
    <?php elseif ($userType === 'Administrator') : ?>
        <!-- Content for Administrator -->
        <a href="updateprofile.php">Update Profile</a><br>
        <a href="manageauthors.php">Manage Authors</a><br>
        <a href="viewarticles.php">View Articles</a><br>
    
    <?php elseif ($userType === 'Author') : ?>
    <!-- Content for Author -->
    <a href="updateprofile.php">Update Profile</a><br>
    <a href="managearticles.php">Manage Articles</a><br>
    <a href="viewarticles.php">View Articles</a><br>
    <?php endif; ?>



    <a href="logout.php">Logout</a>
</body>

</html>
