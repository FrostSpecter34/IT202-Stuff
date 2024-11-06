<!-- Andrew Rodriguez, 11/17/2023/ IT 202-003, Unit 9 Assignment, ar327@njit.edu -->

<?php

$njit_dsn = 'mysql:host=sql1.njit.edu;port=3306;dbname=ar327';
$njit_username = 'ar327';
$njit_password = 'Mysqltho124_';

$dsn = $njit_dsn;
$dbusername = $njit_username;
$dbpassword = $njit_password;

//database 'ar327' cannot be found, yet this is the same structure used for bread_database 
//and that file works fine, so I got stuck here

try {
    $db = new PDO($dsn, $dbusername, $dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function add_bread_manager($email, $password, $firstName, $lastName) {
        global $db;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO breadManagers (emailAddress, password, firstName, lastName)
                  VALUES (:email, :password, :firstName, :lastName)';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->execute();
        $statement->closeCursor();
    }
function is_valid_bread_manager($email, $password) {
    $db = Database::getDB();
    $query = 'SELECT password FROM breadManagers
              WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    $hash = $row['password'];
    return password_verify($password, $hash);
}
    } catch(PDOException $exception) {
        $error_message = $exception->getMessage();
        include('catalog_error.php');
        exit();
    }
    
return $db;
?>