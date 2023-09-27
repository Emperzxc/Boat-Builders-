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
    $userID = $_POST["userID"];
    $newStatus = $_POST["newStatus"];

    // Update the payment order status in the database
    $updateSql = "UPDATE orders SET status = '$newStatus' WHERE id = $userID";

    if ($conn->query($updateSql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
