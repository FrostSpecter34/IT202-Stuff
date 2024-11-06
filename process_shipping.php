<!-- Andrew Rodriguez, 10/6/2023/ IT 202-003, Unit 3 Assignment, ar327@njit.edu -->

<html>
    <link rel="stylesheet" href="bread_css.css">
    <?php include('header.php'); ?>
    <a href="bread_shop.php">Home</a>
</html>

<?php
//session_start();

    // Check if the user is not logged in
    //if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
        // User is not logged in, display error message or redirect
      //  header("Location: login_error.php");
        //exit();
    //}
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $ship_date = $_POST['ship_date'];
    $package_dimensions = $_POST['package_dimensions'];
    $package_weight = $_POST['package_weight'];

    $errors = [];

    if ($package_weight > 150) {
        $errors[] = "Package weight cannot exceed 150 pounds.";
    }

    $dimensions = explode("x", $package_dimensions);
    if (count($dimensions) !== 3 || max($dimensions) > 36) {
        $errors[] = "Invalid package dimensions. Maximum dimension should be 36 inches.";
    }

    if (!preg_match('/^[A-Za-z\s]+$/', $state) || !preg_match('/^\d{5}$/', $zip_code)) {
        $errors[] = "Invalid state or zip code.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
        echo "<a href='shipping_page.php'>Go back</a>";
    } else {
        // Generate packing label report
        echo "<h1>Packing Label:</h1>";
        echo "<p>From: Quality Bread Shop, 341 Baker Street, Breadville, NJ, 07201</p>";
        echo "<p>To: $first_name $last_name, $street_address, $city, $state, $zip_code</p>";
        echo "<p>Package Dimensions: $package_dimensions inches</p>";
        echo "<p>Package Weight: $package_weight lbs</p>";
        echo "<p>Shipping Company: FedEx</p>";
        echo "<p>Shipping Class: Priority Mail</p>";
        echo "<p>Tracking Number: 123456789</p>";
        echo "<p>Order Number: 213</p>";
        echo "<p>Ship Date: $ship_date</p>";
        echo "<img src='https://static.vecteezy.com/system/resources/previews/019/507/624/non_2x/barcode-on-white-background-illustration-free-vector.jpg' alt='Tracking Barcode' style='width:200px; height:100px'>";
    }
    include('footer.php');
?>