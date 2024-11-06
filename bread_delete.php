<!-- Andrew Rodriguez, 11/17/2023/ IT 202-003, Unit 9 Assignment, ar327@njit.edu -->

<?php
    session_start();

    // Check if the user is logged in
    //if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
        // Redirect or display an error message
           // header("location: login.php");
            //exit;
        //}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get bread ID from the POST request
        require_once('bread_database.php');
        
        $bread_id = $_POST['bread_id'];

        $queryDelete = 'DELETE FROM bread WHERE breadID = :bread_id';
        $statementDelete = $db->prepare($queryDelete);
        $statementDelete->bindValue(':bread_id', $bread_id, PDO::PARAM_INT);
        $statementDelete->execute();
        $statementDelete->closeCursor();

        // Redirect back to the bread catalog or display a success message
        header("location: bread_catalog.php");
        exit;
    }
?>