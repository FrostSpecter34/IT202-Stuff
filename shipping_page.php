<!-- Andrew Rodriguez, 10/6/2023/ IT 202-003, Unit 3 Assignment, ar327@njit.edu -->

<html>
    <head>
        <title>Bread Shop Shipping</title>
        <link rel="stylesheet" href="bread_css.css">
    </head>
        <body>
        <?php include('header.php'); ?>
            <nav>
            </nav>
            <main>
                <h2>Shipping Page</h2>
                <form method="post" action="process_shipping.php">

                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" required><br>
                    
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" required><br>

                    <label for="street_address">Street Address:</label>
                    <input type="text" name="street_address" required><br>

                    <label for="city">City:</label>
                    <input type="text" name="city" required><br>

                    <label for="state">State:</label>
                    <input type="text" name="state" required><br>

                    <label for="zip_code">Zip Code:</label>
                    <input type="text" name="zip_code" required><br>

                    <label for="ship_date">Ship Date:</label>
                    <input type="date" name="ship_date" required><br>

                    <label for="package_dimensions">Package Dimensions (LxWxH):</label>
                    <input type="text" name="package_dimensions" required><br>

                    <label for="package_weight">Package Weight (lbs):</label>
                    <input type="number" name="package_weight" step="0.01" min="0" required><br>

                    <input type="submit" value="Generate Packing Label">
                </form>
            </main>
            <?php include('footer.php'); ?>
        </body>
</html>