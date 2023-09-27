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
    
    $sql = "SELECT * FROM user_booking WHERE 1";
    
    if (!empty($statusFilter)) {
        $sql .= " AND status = '$statusFilter'";
    }
    
    if (!empty($issueFilter)) {
        $sql .= " AND issue = '$issueFilter'";
    }
    
    $result = $conn->query($sql);
} else {
    // Default query without filters
    $sql = "SELECT * FROM user_booking";
    $result = $conn->query($sql);
}


$connOrders = new mysqli($databaseHost, $databaseUsername, $databasePassword, $dbname);


if ($connOrders->connect_error) {
    die("Connection failed: " . $connOrders->connect_error);
}


$sqlOrders = "SELECT * FROM orders";
$resultOrders = $connOrders->query($sqlOrders);


$connProd = new mysqli($databaseHost, $databaseUsername, $databasePassword, $dbname);


if ($connProd->connect_error) {
    die("Connection failed: " . $connProd->connect_error);
}


$sqlProd = "SELECT * FROM product";
$resultProd = $connProd->query($sqlProd);
?>
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
$sqlOrder = "SELECT * FROM orders";
$resultOrder = $connOrders->query($sqlOrder);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	
	<title>Balmes Online Booking</title>
     
</head>
<body>
    <header>
        <h2 class="logo">
                <img src="image/logo.png" alt="Logo">
        </h2> 
        <div class="address">Balmes Online Booking
            <div class="sub" style="color:red;">Admin Page</div> 
        </div>

        <nav class="navigation">
            <a class="active" href="home.php">Home</a> 
            <a href="schedule.php">Calendar</a> 
        </nav> 
    </header>
    <div class ="banner">
    <aside class="sidebar">
      <ul class="tabs">
      <li class="tab" data-tab="booking">
            Manage Bookings
        <li class="tab" data-tab="payments">
            Manage Payments
        </li>
        <li class="tab" data-tab="stocks">
            Manage Product Stocks
        </li>
        <li class="tab" data-tab="tracking">
            Manage Order tracking 
        </li>
      </ul>
    </aside>
    <main class="main-content">
        <div class="tab-content">
            <div class="tab-pane" id="booking">
                    <form id="filterForm" class="filter-form">
                        <label for="statusFilter">Status:</label>
                        <select id="statusFilter" name="statusFilter">
                            <option value="">Show All</option>
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Completed">Completed</option>
                        </select>
                        
                        <label for="issueFilter">Issue:</label>
                        <select id="issueFilter" name="issueFilter">
                            <option value="">Show All</option>
                            <option value="Boat Building">Boat Building</option>
                            <option value="Boat Repair">Boat Repair</option>
                            <option value="Boat Documentation">Boat Documentation</option>
                        </select>
                        
                        <button type="submit">Filter</button>
                        <button type="button" id="showAll">Show All</button>

                       
                            <input type="text" id="boatIDSearch" name="boatIDSearch" placeholder="Enter Boat ID"><button type="button" id="searchButton" class="search-icon-button"><i class="fas fa-search"></i></button>
                            <button type="button" id="clearSearch">Clear</button>
                      
                    </form>
                 <?php if ($result->num_rows > 0) : ?>
                    <div class="content-table1-container">
                <table class="content-table1">
                    <thead>
                        <tr>
                            <th>Boat ID</th>
                            <th>Mobile No.</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Details</th>
                            <th>Issue</th>
                            <th>Booking date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr class="data-row" data-id="<?= $row['boatID'] ?>" data-name="<?= $row['givenName'] . ' ' . $row['lastName'] ?>">
                                <td><?= $row['boatID'] ?></td>
                                <td><?= $row['mobile'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['givenName'] . ' ' . $row['lastName'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $row['details'] ?></td>
                                <td><?= $row['issue'] ?></td>
                                <td><?= $row['event_start_date'] ?></td>
                                <td><?= $row['status'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
        <p>No orders found.</p>
    <?php endif; ?>
    </div>
            
        <!-- Create a hidden edit modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Change Status</h2>
                <div class="modal-body">
                    <p style="font-weight:bold;">Boat ID: <span id="editBoatID"style="font-weight:normal; color:red;"></span></p>
                    <p style="font-weight:bold;">Name: <span id="editName" style="font-weight:normal; color:red;"></span></p>
                    <div class="form-group">
                        <label for="editStatus">Status:</label>
                        <select id="editStatus" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <button id="saveEdit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        <!-- Add jQuery library (you can include it from a CDN) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>    
          $(document).ready(function () {
                // Add an event handler for the "Search" button
                $("#searchButton").click(function () {
                    $("#filterForm").submit(); // Trigger the form submission
                });
                // Function to refresh the table content
                function refreshTable() {
                    $.ajax({
                        type: "POST",
                        url: "filter_data.php",
                        data: $("#filterForm").serialize(),
                        success: function (response) {
                            $("#tableBody").html(response);
                        }
                    });
                }

                // Handle filter form submission
                $("#filterForm").submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        type: "POST",
                        url: "filter_data.php",
                        data: formData,
                        success: function (response) {
                            $("#tableBody").html(response);
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX error:", status, error);
                        }
                    });
                });

                // Handle "Show All" button click
                $("#showAll").click(function () {
                    $("#statusFilter").val("");
                    $("#issueFilter").val("");
                    $("#boatIDSearch").val(""); // Clear the search input
                    $("#filterForm").submit();
                });

                // Handle "Clear Search" button click
                $("#clearSearch").click(function () {
                    $("#boatIDSearch").val(""); // Clear the search input
                    $("#filterForm").submit();
                });

                // Handle clicking a row to edit product information
                $("#tableBody").on("click", ".data-row", function () {
                    // Get the data from the clicked row
                    var boatID = $(this).data("id");
                    var name = $(this).data("name");

                    // Populate the modal with data
                    $("#editBoatID").text(boatID);
                    $("#editName").text(name);

                    // Show the modal
                    $("#editModal").css("display", "block");
                });

                // Close the modal when the "x" button is clicked
                $(".close").click(function () {
                    $("#editModal").css("display", "none");
                });

                // Save the edited data when the "Save" button is clicked
                $("#saveEdit").click(function () {
                    var boatID = $("#editBoatID").text();
                    var newStatus = $("#editStatus").val();

                    // Send an AJAX request to update the status in the database
                    $.ajax({
                        type: "POST",
                        url: "update_booking_status.php",
                        data: {
                            boatID: boatID,
                            newStatus: newStatus
                        },
                        success: function (response) {
                            if (response === "success") {
                                alert("Status updated successfully.");
                                // Close the modal
                                $("#editModal").css("display", "none");
                                // Refresh the table content
                                refreshTable();
                            } else {
                                alert("Error updating status.");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX error:", status, error);
                            alert("Error updating status.");
                        }
                    });
                });
            });

        </script>

        </div>   
        <div class="tab-pane" id="payments">
            <form id="paymentFilterForm" class="filter-form">
                <label for="paymentStatusFilter">Status:</label>
                <select id="paymentStatusFilter" name="paymentStatusFilter">
                    <option value="">Show All</option>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit">Filter</button>
                <button type="button" id="showAllPayments">Show All</button>

                <input type="text" id="orderIDSearch" name="orderIDSearch" placeholder="Enter Order ID"><button type="button" id="searchOrderIDButton" class="search-icon-button"><i class="fas fa-search"></i></button>
                 <button type="button" id="clearOrderIDSearch">Clear</button>
            </form>
            <?php if ($resultOrders->num_rows > 0) : ?>
                <div class="content-table2-container">
                    <table class="content-table2">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Payment Method</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Location</th>
                                <th>Reference Number</th>
                                <th>Receipt</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTableBody">
                            <?php while ($row = $resultOrders->fetch_assoc()) : ?>
                                <tr class="data-row-payment" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" data-phone="<?= $row['phone'] ?>" data-amount="<?= $row['amount_paid'] ?>" data-mode="<?= $row['pmode'] ?>" data-reference="<?= $row['reference'] ?>"data-receipt="<?= $row['receipt_image'] ?>">
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['pmode'] ?></td>
                                    <td><?= $row['products'] ?></td>
                                    <td><?= $row['amount_paid'] ?></td>
                                    <td><?= $row['location'] ?></td>
                                    <td><?= $row['reference'] ?></td>
                                    <td><img src="<?= $row['receipt_image'] ?>" alt="<?= $row['reference'] ?>" width="50"></td>
                                    <td><?= $row['status'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p>No payment orders found.</p>
            <?php endif; ?>
            </div>    

            <div id="paymentEditModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Payment Order Status</h2>
                    <div class="modal-body">
                        <p style="font-weight: bold;">User ID: <span id="editUserID" style="font-weight: normal; color: red;"></span></p>
                        <p style="font-weight: bold;">Name: <span id="editUserName" style="font-weight: normal; color: red;"></span></p>
                        <p style="font-weight: bold;">Phone Number: <span id="editUserPhone" style="font-weight: normal; color: red;"></span></p>
                        <p style="font-weight: bold;">Amount: <span id="editOrderAmount" style="font-weight: normal; color: red;"></span></p>
                        <p style="font-weight: bold;">Payment Mode: <span id="editPaymentMode" style="font-weight: normal; color: red;"></span></p>
                        <p style="font-weight: bold;">Reference: <span id="editOrderReference" style="font-weight: normal; color: red;"></span></p>
                        <div>
                            <p style="font-weight: bold;">Receipt:</p>
                            <img id="editReceiptImage" src="" alt="Receipt" width="100" style="height: 400px; width:230px; margin-bottom:20px; margin-top:20px;">
                        </div>
                        <div class="form-group">
                            <label for="editPaymentStatus">Status:</label>
                            <select id="editPaymentStatus" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <button id="savePaymentEdit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    // Function to refresh the payments table content
                    function refreshPaymentsTable() {
                        $.ajax({
                            type: "POST",
                            url: "filter_data2.php", // Change to the correct URL
                            data: $("#paymentFilterForm").serialize(),
                            success: function (response) {
                                $("#paymentsTableBody").html(response);
                            }
                        });
                    }
                     // Handle filter form submission for payments
                    $("#paymentFilterForm").submit(function (e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        
                        $.ajax({
                            type: "POST",
                            url: "filter_data2.php", // Change to the correct URL
                            data: formData,
                            success: function (response) {
                                $("#paymentsTableBody").html(response);
                            }
                        });
                    });

                    // Handle clicking the Order ID search button
                    $("#searchOrderIDButton").click(function () {
                            var orderIDSearch = $("#orderIDSearch").val();

                            // Perform an AJAX request to filter the data by Order ID
                            $.ajax({
                                type: "POST",
                                url: "filter_data2.php", // Change to the correct URL
                                data: {
                                    paymentStatusFilter: $("#paymentStatusFilter").val(),
                                    orderIDSearch: orderIDSearch // Add Order ID search parameter
                                },
                                success: function (response) {
                                    $("#paymentsTableBody").html(response);
                                }
                            });
                        });

                        // Handle clicking the Clear Order ID search button
                        $("#clearOrderIDSearch").click(function () {
                            $("#orderIDSearch").val("");
                            // Trigger the form submission to clear the search
                            $("#paymentFilterForm").submit();
                        });

                        // Handle "Show All" button click for payments
                        $("#showAllPayments").click(function () {
                                        $("#paymentStatusFilter").val("");
                                        $("#paymentFilterForm").submit();
                        });
                        // Handle clicks on payment order rows
                        $("#paymentsTableBody").on("click", ".data-row-payment", function ()  {
                            var userID = $(this).data("id");
                            var userName = $(this).data("name");
                            var userPhone = $(this).data("phone");
                            var orderAmount = $(this).data("amount");
                            var paymentMode = $(this).data("mode");
                            var orderReference = $(this).data("reference");
                            var receiptImage = $(this).data("receipt");

                            // Populate the modal with data
                            $("#editUserID").text(userID);
                            $("#editUserName").text(userName);
                            $("#editUserPhone").text(userPhone);
                            $("#editOrderAmount").text(orderAmount);
                            $("#editPaymentMode").text(paymentMode);
                            $("#editOrderReference").text(orderReference);
                            $("#editReceiptImage").attr("src", receiptImage);

                            // Show the modal
                            $("#paymentEditModal").css("display", "block");
                        });

                            // Handle closing the modal
                            $(".close").click(function () {
                                $("#paymentEditModal").css("display", "none");
                            });

                        // Save the edited payment order data when the "Save" button is clicked
                        $("#savePaymentEdit").click(function () {
                            var userID = $("#editUserID").text();
                            var newStatus = $("#editPaymentStatus").val();

                            // Send an AJAX request to update the status in the database
                            $.ajax({
                                type: "POST",
                                url: "update_payment_status.php", // Replace with the correct path to your PHP file
                                data: {
                                    userID: userID,
                                    newStatus: newStatus
                                },
                                success: function (response) {
                                if (response === "success") {
                                    alert("Payment order status updated successfully.");
                                    // Close the modal
                                    $("#paymentEditModal").css("display", "none");
                                    
                                    // Refresh the payments table content
                                    refreshPaymentsTable();
                                } else {
                                        alert("Error updating payment order status.");
                                    }
                                }
                            });
                        });
                });
            </script>
        </div>
        <div class="tab-pane"  id="stocks"> 
        <form id="stockFilterForm" class="filter-form">
            <label for="stockFilter">Available Stock:</label>
            <select id="stockFilter" name="stockFilter">
                <option value="">Show All</option>
                <option value="less_than_10">Less than 10</option>
                <option value="more_than_10">More than 10</option>
            </select>
            <button type="submit">Filter</button>
            <button type="button" id="showAllStocks">Show All</button>
        </form>
            <?php if ($resultProd->num_rows > 0) : ?>
                <div class="content-table3-container">
                <table class="content-table3" >
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Available Stocks</th>
                            
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <?php while ($row = $resultProd->fetch_assoc()) : ?>
                            <tr class="data-row-product" data-id="<?= $row['id'] ?>" data-name="<?= $row['product_name'] ?>">
                                <td><?= $row['product_code'] ?></td>
                                <td><img src="<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>" width="100"></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['product_price'] ?></td>
                                <td><?= $row['stocks'] ?></td>
                                
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No payment orders found.</p>
            <?php endif; ?>
            </div>

            <!-- Create a hidden edit modal for managing product stocks -->
            <div id="editProductModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Product Stock</h2>
                    <div class="modal-body">
                        <p style="font-weight:bold;">Product ID: <span id="editProductID" style="font-weight:normal; color:red;"></span></p>
                        <p style="font-weight:bold;">Product Name: <span id="editProductName" style="font-weight:normal; color:red;"></span></p>
                        <div class="form-group">
                            <label for="editStock">Stocks:</label>
                            <input type="number" id="editStock" class="form-control" placeholder="Enter new stock" required>
                        </div>
                        <div class="form-group">
                            <label for="editPrice">Price:</label>
                            <input type="number" id="editPrice" class="form-control" placeholder="Enter new price" required>
                        </div>
                        <button id="saveProductEdit" class="btn btn-primary" type="submit" value="Submit">Save</button>
                    </div>
                </div>
            </div>
            
            <script>
                $(document).ready(function () {
                    // Function to refresh the table content
                    function refreshTable() {
                        $.ajax({
                            type: "POST",
                            url: "filter_data3.php", // Change to the correct PHP file
                            data: $("#stockFilterForm").serialize(),
                            success: function (response) {
                                $("#productTableBody").html(response);
                            }
                        });
                    }
                    // Handle stock filter form submission
                    $("#stockFilterForm").submit(function (e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        
                        $.ajax({
                            type: "POST",
                            url: "filter_data3.php", // Change to the correct PHP file
                            data: formData,
                            success: function (response) {
                                $("#productTableBody").html(response);
                            }
                        });
                    });

                    // Handle "Show All" button click
                    $("#showAllStocks").click(function () {
                        $("#stockFilter").val("");
                        $("#stockFilterForm").submit();
                    });
                     // Handle clicking a row to edit product information
                     $("#productTableBody").on("click", ".data-row-product", function ()  {
                        // Get the data from the clicked row
                        var productID = $(this).data("id");
                        var productName = $(this).data("name");

                        // Populate the modal with data
                        $("#editProductID").text(productID);
                        $("#editProductName").text(productName);

                        // Show the modal
                        $("#editProductModal").css("display", "block");
                    });

                    // Handle closing the modal
                    $(".close").click(function () {
                        $("#editProductModal").css("display", "none");
                    });

                    // Handle saving edited product information
                    $("#saveProductEdit").click(function () {
                            var productID = $("#editProductID").text();
                            var newStock = $("#editStock").val();
                            var newPrice = $("#editPrice").val();

                            // Check if either price or stock input is empty
                            if (!newPrice.trim() || !newStock.trim()) {
                                alert("Please enter both a new price and a new stock value.");
                                return; // Prevent the AJAX request
                            }

                            // Send an AJAX request to update the stock and price in the database
                            $.ajax({
                                type: "POST",
                                url: "update_product.php", // Change this to the correct path of your PHP file
                                data: {
                                    productID: productID,
                                    newStock: newStock,
                                    newPrice: newPrice
                                },
                                success: function (response) {
                                    if (response === "success") {
                                        alert("Product information updated successfully.");
                                        // Close the modal
                                        $("#editProductModal").css("display", "none");
                                        
                                        // Refresh the table content
                                        refreshTable();
                                    } else {
                                        alert("Error updating product information.");
                                    }
                                }
                            });
                        });
                    });
                </script>
        </div>
        <div class="tab-pane" id="tracking">
            <form id="orderTrackingFilterForm" class="filter-form">
                <label for="orderTrackingStatusFilter">Status:</label>
                <select id="orderTrackingStatusFilter" name="orderTrackingStatusFilter">
                    <option value="">Show All</option>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                </select>
                <button type="submit">Filter</button>
                <button type="button" id="showAllOrderTracking">Show All</button>

                <input type="text" id="orderIDSearch2" name="orderIDSearch2" placeholder="Enter Order ID"><button type="button" id="searchOrderIDButton2" class="search-icon-button"><i class="fas fa-search"></i></button>
                 <button type="button" id="clearOrderIDSearch2">Clear</button>
            </form>
            <?php if ($resultOrder->num_rows > 0) : ?>
                <div class="content-table2-container">
                <table class="content-table2">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="orderTrackingTableBody">
                        <?php while ($row = $resultOrder->fetch_assoc()) : ?>
                            <tr class="data-row-order-tracking" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>"data-phone="<?= $row['phone'] ?>">
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['phone'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $row['products'] ?></td>
                                <td><?= $row['amount_paid'] ?></td>
                                <td><?= $row['location'] ?></td>
                                <td><?= $row['status'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No order tracking records found.</p>
            <?php endif; ?>
            </div>
            <!-- Create a hidden edit modal for Order Tracking -->
            <div id="orderEditModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Order Location</h2>
                    <div class="modal-body">
                        <p style="font-weight:bold;">User ID: <span id="orderEditUserID" style="font-weight:normal; color:red;"></span></p>
                        <p style="font-weight:bold;">Name: <span id="orderEditName" style="font-weight:normal; color:red;"></span></p>
                        <p style="font-weight:bold;">Phone: <span id="orderEditPhone" style="font-weight:normal; color:red;"></span></p>
                        <div class="form-group">
                            <label for="editLocation">New Location:</label>
                            <input type="text" id="editLocation" class="form-control">
                        </div>
                        <button id="saveOrderEdit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    // Function to refresh the order tracking table content
                    function refreshOrderTrackingTable() {
                        $.ajax({
                            type: "POST",
                            url: "filter_data_order_tracking.php", // Change to the correct PHP file
                            data: $("#orderTrackingFilterForm").serialize(),
                            success: function (response) {
                                $("#orderTrackingTableBody").html(response);
                            }
                        });
                    }

                    // Handle filter form submission for order tracking
                    $("#orderTrackingFilterForm").submit(function (e) {
                        e.preventDefault();
                        var formData = $(this).serialize();

                        $.ajax({
                            type: "POST",
                            url: "filter_data_order_tracking.php", // Create this PHP file
                            data: formData,
                            success: function (response) {
                                $("#orderTrackingTableBody").html(response);
                            }
                        });
                    });

                    
                    // Handle clicking the Order ID search button
                    $("#searchOrderIDButton2").click(function () {
                        var orderIDSearch = $("#orderIDSearch2").val();

                        // Perform an AJAX request to filter the data by Order ID
                        $.ajax({
                            type: "POST",
                            url: "filter_data_order_tracking.php", // Change to the correct URL
                            data: {
                                orderTrackingStatusFilter: $("#orderTrackingStatusFilter").val(),
                                orderIDSearch: orderIDSearch // Add Order ID search parameter
                            },
                            success: function (response) {
                                $("#orderTrackingTableBody").html(response);
                            }
                        });
                    });

                    // Handle clicking the Clear Order ID search button
                    $("#clearOrderIDSearch2").click(function () {
                        $("#orderIDSearch2").val("");
                        // Trigger the form submission to clear the search
                        $("#orderTrackingFilterForm").submit();
                    });
                    // Handle click events on rows in the "Manage Order Tracking" tab using event delegation
                    $("#orderTrackingTableBody").on("click", ".data-row-order-tracking", function () {
                        // Get the data from the clicked row
                        var userID = $(this).data("id");
                        var name = $(this).data("name");
                        var phone = $(this).data("phone");

                        // Populate the modal with data
                        $("#orderEditUserID").text(userID);
                        $("#orderEditName").text(name);
                        $("#orderEditPhone").text(phone);
                       

                        // Show the modal
                        $("#orderEditModal").css("display", "block");
                    });

                    // Close the Order Tracking edit modal when the "x" button is clicked
                    $(".close").click(function () {
                        $("#orderEditModal").css("display", "none");
                    });

                    // Save the edited location when the "Save" button is clicked
                    $("#saveOrderEdit").click(function () {
                        var userID = $("#orderEditUserID").text();
                        var newLocation = $("#editLocation").val();

                        // Check if the new location input is empty
                        if (!newLocation.trim()) {
                            alert("Please enter a new location.");
                            return; // Prevent the AJAX request
                        }
                        // Send an AJAX request to update the location in the database
                        $.ajax({
                            type: "POST",
                            url: "update_order_location.php", // Change this to the correct path of your PHP file
                            data: {
                                userID: userID,
                                newLocation: newLocation
                            },
                            success: function (response) {
                                if (response === "success") {
                                    alert("Location updated successfully.");
                                    // Close the modal
                                    $("#orderEditModal").css("display", "none");
                                      // Refresh the order tracking table content
                                    refreshOrderTrackingTable();
                                } else {
                                    alert("Error updating location.");
                                }
                            }
                        });
                    });

                    // Handle "Show All" button click for order tracking
                    $("#showAllOrderTracking").click(function () {
                        $("#orderTrackingStatusFilter").val("");
                        $("#orderTrackingFilterForm").submit();
                    });
                });

            </script>
        </div>
      </div>
    </main>
    </div>  
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dashboardTab = document.querySelector('.tab[data-tab="booking"]');
        const dashboardTabPane = document.getElementById('booking');

        dashboardTab.classList.add('active');
        dashboardTabPane.style.display = 'block';
    });

    // tab active display script
    const tabs = document.querySelectorAll('.tab');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(tab => tab.classList.remove('active'));
            tabPanes.forEach(pane => pane.style.display = 'none');
            tab.classList.add('active');
            const tabId = tab.getAttribute('data-tab');
            document.getElementById(tabId).style.display = 'block'; // Display the corresponding tab pane
        });
    });
</script>


</body>
</html>