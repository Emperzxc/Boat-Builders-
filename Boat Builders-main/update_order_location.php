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
    // Get the user ID and new location from the POST data
    $userID = $_POST["userID"];
    $newLocation = $_POST["newLocation"];

    // Perform the SQL update query
    $sql = "UPDATE orders SET location = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newLocation, $userID);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
