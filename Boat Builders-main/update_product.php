<?php
// Database connection details
$databaseHost = 'localhost';
$databaseUsername = 'root';
$databasePassword = '';
$dbname = "balmes_db";

// Create a connection to the database
$conn = new mysqli($databaseHost, $databaseUsername, $databasePassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $_POST["productID"];
    $newStock = $_POST["newStock"];
    $newPrice = $_POST["newPrice"];

    // Validate and sanitize input values here if needed

    // Update the product information in the database
    $sql = "UPDATE product SET stocks = ?, product_price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ddi", $newStock, $newPrice, $productID);

        // Execute the statement
        if ($stmt->execute()) {
            echo "success"; // Send a success response back to the JavaScript
        } else {
            echo "error"; // Send an error response back to the JavaScript
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "error"; // Send an error response back to the JavaScript
    }
} else {
    echo "error"; // Send an error response back to the JavaScript for an invalid request
}

// Close the database connection
$conn->close();
?>
