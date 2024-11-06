<!-- Andrew Rodriguez, 11/3/2023/ IT 202-003, Unit 7 Assignment, ar327@njit.edu -->

<?php
require_once('bread_database.php');
//session_start();
    // Check if the user is not logged in
  //  if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
        // User is not logged in, display error message or redirect
    //    header("Location: login_error.php");
      //  exit();
    //}

// Define variables and initialize with empty values
$category_id = $breadCode = $breadName = $price = "";
$category_id_err = $breadCode_err = $breadName_err = $price_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Category
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id === false) {
        $category_id_err = "Please select a valid category.";
    }

    // Validate Bread Code
    $breadCode = trim($_POST["breadCode"]);
    if (empty($breadCode)) {
        $breadCode_err = "Please enter a bread code.";
    } else {
        // Check if the bread code already exists in the database
        try {
            $queryCheckCode = 'SELECT breadID FROM bread WHERE breadCode = :breadCode';
            $statementCheckCode = $db->prepare($queryCheckCode);
            $statementCheckCode->bindValue(':breadCode', $breadCode);
            $statementCheckCode->execute();
            if ($statementCheckCode->rowCount() > 0) {
                $breadCode_err = "This bread code already exists in the database.";
            }
            $statementCheckCode->closeCursor();
        } catch (PDOException $e) {
            echo "Error checking bread code: " . $e->getMessage();
        }
    }

    // Validate Bread Name and Price
    $breadName = trim($_POST["breadName"]);
    if (empty($breadName)) {
        $breadName_err = "Please enter a bread name.";
    }

    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    if ($price === false) {
        $price_err = "Please enter a valid bread price.";
    }
    
    // If no errors, insert the new bread item
    if (empty($category_id_err) && empty($breadCode_err) && empty($breadName_err) && empty($price_err)) {
        try {
            $queryInsertBread = 'INSERT INTO bread (breadCategoryID, breadCode, breadName, price) VALUES (:category_id, :breadCode, :breadName, :price)';
            $statementInsertBread = $db->prepare($queryInsertBread);
            $statementInsertBread->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $statementInsertBread->bindValue(':breadCode', $breadCode);
            $statementInsertBread->bindValue(':breadName', $breadName);
            $statementInsertBread->bindValue(':price', $price);

            if ($statementInsertBread->execute()) {
                // Redirect to the bread catalog page after successful insertion
                header("location: bread_catalog.php");
                exit();
            } else {
                echo "Error: Unable to insert the bread item.";
            }
        } catch (PDOException $e) {
            echo "Error inserting bread item: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Bread Item</title>
    <link rel="stylesheet" href="bread_css.css" />
</head>
<?php include('header.php'); ?>
<body>
<main>
    <h1>Add Bread Item</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <div class="form-group">
            <label>Category:</label>
            <select name="category_id" class="form-control">
                <option value="" disabled selected>Select a category</option>
                <?php
                $queryCategories = 'SELECT * FROM breadcategories';
                $statementCategories = $db->query($queryCategories);
                while ($row = $statementCategories->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['breadCategoryID'] . '">' . $row['breadCategoryName'] . '</option>';
                }
                ?>
            </select>
            <span class="error"><?php echo $category_id_err; ?></span>
        </div>
        <div class="form-group">
            <label>Bread Code:</label>
            <input type="text" name="breadCode" class="form-control" value="<?php echo $breadCode; ?>">
            <span class="error"><?php echo $breadCode_err; ?></span>
        </div>
        <div class="form-group">
            <label>Bread Name:</label>
            <input type="text" name="breadName" class="form-control" value="<?php echo $breadName; ?>">
            <span class="error"><?php echo $breadName_err; ?></span>
        </div>
        <div class="form-group">
            <label>Bread Price:</label>
            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
            <span class="error"><?php echo $price_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary" value="Clear">
        </div>
    </form>
</main>
<script>
    function validateForm() {
        let category = document.getElementsByName("category_id")[0].value;
        let breadCode = document.getElementsByName("breadCode")[0].value;
        let breadName = document.getElementsByName("breadName")[0].value;
        let price = document.getElementsByName("price")[0].value;

        if (category === "") {
            alert("Please select a category.");
            return false;
        }

        if (breadCode === "" || breadCode.length < 4 || breadCode.length > 10) {
            alert("Please enter a valid Bread Code (4-10 characters).");
            return false;
        }

        if (breadName === "" || breadName.length < 10 || breadName.length > 100) {
            alert("Please enter a valid Bread Name (10-100 characters).");
            return false;
        }

        if (price === "" || isNaN(price) || parseFloat(price) <= 0 || parseFloat(price) > 100000) {
            alert("Please enter a valid Bread Price (not blank, positive, and less than $100,000).");
            return false;
        }

        return true;
    }
</script>
<?php include('footer.php'); ?>
</body>
</html>
