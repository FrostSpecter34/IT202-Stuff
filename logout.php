<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("location: bread_login.php");
    exit();
}
?>