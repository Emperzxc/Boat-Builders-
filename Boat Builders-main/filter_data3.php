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
    $stockFilter = $_POST["stockFilter"];
    
    $sql = "SELECT * FROM product WHERE 1";
    
    if (!empty($stockFilter)) {
        if ($stockFilter === "less_than_10") {
            $sql .= " AND stocks < 10";
        } elseif ($stockFilter === "more_than_10") {
            $sql .= " AND stocks >= 10";
        }
    }
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='data-row-product' data-id='{$row['id']}' data-name='{$row['product_name']}'>";
            echo "<td>{$row['product_code']}</td>";
            echo "<td><img src='{$row['product_image']}' alt='{$row['product_name']}' width='100'></td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['product_price']}</td>";
            echo "<td>{$row['stocks']}</td>";
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No products found.</td></tr>";
    }
}

?>