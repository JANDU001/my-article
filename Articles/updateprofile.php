<?php
require_once 'session.php';
require_once 'user.php';

session_start(); 

$user = new User();
$currentUser = $user->getCurrentUserDetails(); // Implement this method to retrieve the current user's details

$updateProfileSuccess = false;
$updateProfileError = '';

// Check for update profile submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];

    if ($user->updateProfile($currentUser['userId'], $fullName, $email, $newPassword)) {
        $updateProfileSuccess = true;
        // Retrieve the updated user details for display
        $currentUser = $user->getUserById($currentUser['userId']);
    } else {
        $updateProfileError = "Error updating profile. Please try again.";
        header("Location: index.php");
        exit();
    }
}
?>

// Add HTML content for the update profile page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>

<body>
<h2>Update Profile</h2>

<?php if ($updateProfileSuccess) : ?>
    <p style="color: green;">Profile updated successfully!</p>
<?php endif; ?>

<?php if ($updateProfileError) : ?>
    <p style="color: red;"><?php echo $updateProfileError; ?></p>
<?php endif; ?>

<form method="post" action="updateprofile.php">
    <label for="fullName">Full Name:</label>
    <input type="text" id="fullName" name="fullName" value="<?php echo $currentUser['Full_Name']; ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $currentUser['email']; ?>" required><br>

    <label for="password">New Password:</label>
    <input type="password" id="password" name="newPassword"><br>

    <button type="submit" name="updateProfile">Update Profile</button>
</form>
</body>

</html>
