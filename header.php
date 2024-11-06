<!-- Andrew Rodriguez, 11/17/2023/ IT 202-003, Unit 9 Assignment, ar327@njit.edu -->
<header>
    <img src="https://www.nj.com/resizer/4m8lQlbc4dIn4pfc8vnf7f17-64=/arc-anglerfish-arc2-prod-advancelocal/public/LXKDTMX6F5EGFHSYTDD6TO2IGI.jpg" alt="Bread Shop Front Door" style="width:500px;height:250px;">
    <h1>Quality Bread Shop</h1>
    <h2>For all your bread needs!</h2>
    <?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['manager_logged_in']) && $_SESSION['manager_logged_in'] === true) {
    // User is logged in
    echo "Welcome " . $_SESSION['user_details']['firstName'] . " " . $_SESSION['user_details']['lastName'] . " (" . $_SESSION['user_details']['emailAddress'] . ")";
    // Display logout link
    echo '<a href="logout.php">Logout</a>';
} else {
    // User is not logged in
    echo '<a href="bread_login.php">Login</a>';
}
?>
</header>