<!-- Andrew Rodriguez, 10/20/2023/ IT 202-003, Unit 5 Assignment, ar327@njit.edu -->

<?php
require_once('bread_database.php');

$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);

if ($category_id === NULL || $category_id === FALSE) {
    $category_id = 1;
}

$queryCategory = 'SELECT * FROM breadcategories WHERE breadCategoryID = :category_id';
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement1->execute();
$category = $statement1->fetch();
$category_name = $category['breadCategoryName'];
$statement1->closeCursor();

$queryAllCategories = 'SELECT * FROM breadcategories ORDER BY breadCategoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

$queryProducts = 'SELECT * FROM bread WHERE breadCategoryID = :category_id ORDER BY breadID';
$statement3 = $db->prepare($queryProducts);
$statement3->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement3->execute();
$products = $statement3->fetchAll();
$statement3->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quality Bread Shop</title>
    <link rel="stylesheet" href="bread_css.css" />
</head>
<?php include('header.php'); ?>
<body>
<main>
    <h1>Product List</h1>
    <aside>
        <h2>Categories</h2>
        <nav>
        <ul>
            <?php foreach ($categories as $category) : ?>
            <li>
                <a href="?category_id=<?php echo $category['breadCategoryID']; ?>">
                    <?php echo $category['breadCategoryName']; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        </nav>           
    </aside>
    <section>
        <h2><?php echo $category_name; ?></h2>
        <table>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th class="right">Price</th>
            </tr>
 
            <?php foreach ($products as $product) : ?>
            <tr>
                <td>
                    <a href="bread_details.php?bread_id=4<?php echo $product['breadID']; ?>"></a>
                    <?php echo $product['breadCode']; ?>
                </td>
                <td><?php echo $product['breadName']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td>
                    <!-- Delete button for each bread item
                    code below is what would be used if login were working
                    <php
                    session_start();
                    if (isset($_SESSION['manager_logged_in']) && $_SESSION['manager_logged_in'] === true) {
                        echo '<form action="bread_delete.php" method="post">
                                <input type="hidden" name="bread_id" value="' . $product['breadID'] . '">
                                <input type="submit" value="Delete">
                            </form>';
                    }
                    ?> -->
                    <form action="bread_delete.php" method="post">
                        <input type="hidden" name="bread_id" value="<?php echo $product['breadID']; ?>">
                        <input type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete this item?');">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>    
<?php include('footer.php'); ?>
</body>
</html>