<!-- Andrew Rodriguez, 10/20/2023/ IT 202-003, Unit 5 Assignment, ar327@njit.edu -->

<?php
$local_dsn = 'mysql:host=localhost;port=3306;dbname=bread_shop';
$local_username = 'mgs_user';
$local_password = 'pa55word';

$njit_dsn = 'mysql:host=sql1.njit.edu;port=3306;dbname=ar327';
$njit_username = 'ar327';
$njit_password = 'Mysqltho124_';

$dsn = $njit_dsn;
$username = $njit_username;
$password = $njit_password;

try {
    $db = new PDO($dsn, $username, $password);
    echo '<p>You are connected to the database!</p>';
} catch(PDOException $exception) {
    $error_message = $exception->getMessage();
    include('catalog_error.php');
    exit();
}

return $db;
?>