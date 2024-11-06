<!-- Andrew Rodriguez, 12/1/2023/ IT 202-003, Unit 11 Assignment, ar327@njit.edu -->

<?php

require_once('bread_database.php');

if (isset($_GET['breadID'])) {
    $breadID = $_GET['breadID'];
    
    $query = 'SELECT * FROM bread WHERE breadID = :bread_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':bread_id', $bread_id, PDO::PARAM_INT);
    $statement->execute();
    $breadItem = $statement->fetch();
    $statement->closeCursor();

    if ($breadItem) {
        // Display details of the selected bread item
        echo '<h1>Bread Details</h1>';
        echo '<p>Bread Code: ' . $breadItem['breadCode'] . '</p>';
        echo '<p>Bread Name: ' . $breadItem['breadName'] . '</p>';
        echo '<p>Price: ' . $breadItem['price'] . '</p>';
        // Display image associated with the bread item
        echo '<img src="images/' . $breadItem['breadCode'] . '.jpg" alt="Bread Image">';
    } else {
        echo "Error: Bread item not found.";
    }
} else {
    echo "Error: Bread ID not specified";
}
?>

<script>
    // Get the image element
    const breadImage = document.getElementById('breadImage');

    // Store the original and alternate image URLs
    const originalImage = breadImage.src;
    const alternateImage = 'images/' + '<?php echo $breadItem['breadCode']; ?>' + '-alternate.jpg';

    // Event listener for when the mouse enters the image area
    breadImage.addEventListener('mouseover', function() {
        breadImage.src = alternateImage;
    });

    // Event listener for when the mouse leaves the image area
    breadImage.addEventListener('mouseout', function() {
        breadImage.src = originalImage;
    });
</script>