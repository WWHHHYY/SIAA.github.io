<?php
// Start the session
session_start();

include('logs_action.php');

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Archived Items</title>
    <link rel="stylesheet" type="text/css" href="../../css/ord.css">

    <!-- CSS and CDN links -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>

<div class="sidebar">
    <ul>
        <h2>Archive</h2>
        <li><i class='bx bx-home'></i> <a href="Dashboard.php">Home</a></li>
        <li><i class='bx bx-cart'></i> <a href="Inventory.php">Inventory</a></li>
        <li><i class='bx bx-user icon'></i> <a href="archive.php">archive</a></li>
        <li><i class='bx bx-history'></i> <a href="Order.php">Order History</a></li>
        <li><i class='bx bx-dollar'></i> <a href="revenue.php">Revenues</a></li>
        <li><i class='bx bx-user-plus'></i> <a href="add.php">Add Account</a></li>
        <li><i class='bx bx-user icon'></i> <a href="logs.php">Logs</a></li>
        <br><br><br><br><br><br><br> <br><br><br><br><br><br><br> <br><br><br><br><br><br><br>
        <li><i class='bx bx-user-circle icon'></i> <a href="accounts.php">Accounts</a></li>
        <li><i class='bx bx-log-out'></i> <a href="?action=logout">Logout</a></li>
    </ul>
</div>

<div class="header">
    <h1>Archived Items</h1>
</div>

<div class="container">
    <table>
        <tr>
            <th>Item ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Product Type</th>
            <th>Product Unit</th>
        </tr>

        <?php

        // Replace these details with your database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "siaa";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Assuming you have a table named 'archived_items' with the mentioned columns
        $sql = "SELECT archived_item_id, archived_item_name, archived_item_quantity, archived_item_price, archived_product_type, archived_prod_unit FROM archived_items";
        $result = $conn->query($sql);

        // Check for errors
        if (!$result) {
            echo "Error: " . $conn->error;
        } else {
            // Process the result set
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["archived_item_id"] . "</td>
                            <td>" . $row["archived_item_name"] . "</td>
                            <td>" . $row["archived_item_quantity"] . "</td>
                            <td>" . $row["archived_item_price"] . "</td>
                            <td>" . $row["archived_product_type"] . "</td>
                            <td>" . $row["archived_prod_unit"] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No archived items found</td></tr>";
            }
        }

        // Close connection
        $conn->close();
        ?>

    </table>
</div>

</body>
</html>
