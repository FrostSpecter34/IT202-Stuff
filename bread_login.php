<!-- Andrew Rodriguez, 11/17/2023/ IT 202-003, Unit 9 Assignment, ar327@njit.edu -->

<?php
// Check if the form is submitted (login form)
require_once('admin_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to check user credentials
    $query = "SELECT * FROM breadManagers WHERE emailAddress = :email";
    $statement = $db->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute(); //Getting error message here, but the error is that database 'ar327' cannot be found
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Verify user and password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['manager_logged_in'] = true;
        $_SESSION['email'] = $user['emailAddress'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];
        // Set other session variables as needed

        header("location: bread_shop.php"); // Redirect to home page after successful login
        exit();
    } else {
        $login_error = "Invalid email or password. Please try again.";
    }
}

?>

<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="bread_css.css" />
</head>
<?php include('header.php'); ?>
<body>
    <!-- Your login form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Login">
    </form>
    <!-- Display error message if login failed -->
    <?php if (isset($login_error)) : ?>
        <p><?php echo $login_error; ?></p>
    <?php endif; ?>
    <?php include('footer.php'); ?>
</body>
</html>