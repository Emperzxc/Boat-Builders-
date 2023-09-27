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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs from the form
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username and password match a record in the database
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        // You should perform proper validation and sanitization here
    
        $sql = "SELECT user_id FROM admin WHERE username = '$email' AND password = '$password'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Successful login, redirect to a dashboard page
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            echo '<script>window.location.href = "home.php";';
            echo 'alert("Login successful. Click OK to proceed.");</script>';
            exit();
        } else {
            $loginError =  "Invalid email or password.";
        }
    }
}

// Close the database connection
$conn->close();
include 'createdb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	
	<title>Balmes Online Booking</title>
     
</head>
<body>
    

    <header>

    </header>
    <div class="banner">
        <div class="right-content">
            <div class="login-box">
                <h2 style="color: red;">Admin Login</h2>
                <form method="post">
                <div class="input-group">
                        <label for="email">Username:</label>
                        <input type="text" id="email" name="email" required  placeholder="Enter Username">
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required placeholder="Enter Password">
                    </div><br>

                    <div class="input-group">
                        <button type="submit">  SIGN IN  </button>
                    </div>
                    <?php
                    if (isset($loginError)) {
                        echo '<div class="input-group" style="color: red;">' . $loginError . '</div>';
                    }
                    ?>

            </form>
        </div>
    </div>
</div>

<script>
</script>
</body>
</html>


