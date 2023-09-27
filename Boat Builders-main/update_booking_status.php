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
    // Retrieve data from the POST request
    $boatID = $_POST["boatID"];
    $newStatus = $_POST["newStatus"];

    // Log the value of boatID to the error log
    error_log("Received boatID: " . $boatID);

    // Prepare and execute the SQL update query
    $sql = "UPDATE user_booking SET status = ? WHERE boatID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $boatID);

    if ($stmt->execute()) {
        echo "success"; // Return success message to the client
    } else {
        echo "error"; // Return error message to the client
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
