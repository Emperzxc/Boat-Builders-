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
    $statusFilter = $_POST["statusFilter"];
    $issueFilter = $_POST["issueFilter"];
    $boatIDSearch = $_POST["boatIDSearch"]; // Retrieve boatIDSearch from POST data

    $sql = "SELECT * FROM user_booking WHERE 1";

    if (!empty($statusFilter)) {
        $sql .= " AND status = '$statusFilter'";
    }

    if (!empty($issueFilter)) {
        $sql .= " AND issue = '$issueFilter'";
    }

    if (!empty($boatIDSearch)) { // Check if Boat ID search input is not empty
        $sql .= " AND boatID = '$boatIDSearch'";
    }

    // Execute the SQL query
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='data-row' data-id='{$row['boatID']}' data-name='{$row['givenName']} {$row['lastName']}'>";
            echo "<td>{$row['boatID']}</td>";
            echo "<td>{$row['mobile']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['givenName']} {$row['lastName']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['details']}</td>";
            echo "<td>{$row['issue']}</td>";
            echo "<td>{$row['event_start_date']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No orders found.</td></tr>";
    }
}
?>