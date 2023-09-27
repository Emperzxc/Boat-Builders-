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
    $statusFilter = $_POST["paymentStatusFilter"];
    $orderIDSearch = $_POST["orderIDSearch"]; // Get the Order ID search input

    $sql = "SELECT * FROM orders WHERE 1";

    if (!empty($statusFilter)) {
        $sql .= " AND status = '$statusFilter'";
    }

    if (!empty($orderIDSearch)) { // Check if Order ID search input is not empty
        $sql .= " AND id = '$orderIDSearch'";
    }

    // Execute the SQL query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           
            echo  "<tr class='data-row-payment' data-id='{$row['id']}' data-name='{$row['name']}' data-phone='{$row['phone']}' data-amount='{$row['amount_paid']}' data-mode='{$row['pmode']}' data-reference='{$row['reference']}'>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['phone']} {$row['lastName']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['pmode']}</td>";
            echo "<td>{$row['products']}</td>";
            echo "<td>{$row['amount_paid']}</td>";
            echo "<td>{$row['location']}</td>";
            echo "<td>{$row['reference']}</td>";
            echo "<td><img src='{$row['receipt_image']}' alt='{$row['reference']}' width='50'></td>";
            echo "<td>{$row['status']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No orders found.</td></tr>";
    }
}
?>