<?php
require_once 'session.php';
require_once 'user.php';

Session::start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];  

    $user = new User();

    if ($user->login($username, $password, $userType)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid login or password";
    }
}

// Check if the form is submitted for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    $user = new User();

    if ($user->register($fullName, $email, $username, $password, $userType)) {
        $_SESSION['registration_success'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Error during registration. Please try again.";
    }
    // Check for registration success
$registrationSuccess = isset($_SESSION['registration_success']) ? $_SESSION['registration_success'] : false;

if ($registrationSuccess) {
    echo '<p style="color: green;">Registration successful! You can now log in.</p>';
    unset($_SESSION['registration_success']); // Clear the session variable
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login and Registration</title>
</head>

<body>
   <h2>Login</h2>

<?php if (isset($error_message)) : ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="post" action="index.php">
    <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    </div>
    <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    </div>
    <label for="userType">User Type:</label>
    <select id="userType" name="userType" required>
        <option value="Super_User">Super User</option>
        <option value="Author">Author</option>
        <option value="Administrator">Administrator</option>
    </select><br>

    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>

    <hr>

    <h2>Registration</h2>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" action="index.php">
        <div class="form-group">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required><br>
        </div>
        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        </div>
        <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        </div>
        <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        </div>

        <label for="userType">User Type:</label>
        <select id="userType" name="userType" required>
            <option value="Super_User">Super User</option>
            <option value="Author">Author</option>
            <option value="Administrator">Administrator</option>
        </select><br>

        <button type="submit" name="register" class="btn btn-primary">Register</button>
    </form>
</body>

</html>
