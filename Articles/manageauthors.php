
<?php
require_once 'session.php';
require_once 'user.php';

Session::start();
Session::authenticateUser();

$adminId = $_SESSION['userId'];
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addAuthor'])) {
    // Handle form submission for adding a new Author
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the register method in the User class to add a new Author
    if ($user->register($fullName, $email, $username, $password, 'Author')) {
        // Author added successfully
        header("Location: manageauthors.php");
        exit();
    } else {
        // Error adding Author
        $error_message = "Error adding Author. Please try again.";
    }
}

// Fetch the list of all Authors
$allAuthors = $user->getAllAuthors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors</title>
</head>

<body>
    <h2>Manage Authors</h2>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Add new Author form -->
    <form method="post" action="manageauthors.php">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit" name="addAuthor">Add Author</button>
    </form>

    <!-- Display the list of all Authors -->
    <?php foreach ($allAuthors as $author) : ?>
        <li>
            <!-- Content for each author -->
        </li>
    <?php endforeach; ?>
    
    </body>

    </html>