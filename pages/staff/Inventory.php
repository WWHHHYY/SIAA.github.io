<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "siaa";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Remove item
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id_to_remove = $_GET['id'];
    $sql_remove = "DELETE FROM items WHERE id = $id_to_remove";
    
    if ($conn->query($sql_remove) === TRUE) {
        echo "Item removed successfully";
    } else {
        echo "Error removing item: " . $conn->error;
    }
}

// Update item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-item'])) {
    $item_id = $_POST['item-id'];
    $new_quantity = $_POST['new-quantity'];
    $new_price = $_POST['new-price'];

    $sql_update = "UPDATE items SET item_quantity = $new_quantity, item_price = $new_price WHERE id = $item_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Item updated successfully";
    } else {
        echo "Error updating item: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item-name'];
    $item_quantity = $_POST['item-quantity'];
    $item_price = $_POST['item-price'];

    $sql_insert = "INSERT INTO items (item_name, item_quantity, item_price) VALUES ('$item_name', $item_quantity, $item_price)";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Item added successfully";
    } else {
        echo "Error adding item: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" type="text/css" href="../../css/shesh.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>

<div class="sidebar">
    <h2>Inventory</h2>
    <ul>
        <li> <i class='bx bx-home' ></i> <a href="Dashboard.php">Home</a> </li>
        <li> <i class='bx bx-cart' ></i> <a href="Inventory.php">Inventory</a></li>
        <li> <i class='bx bx-history' ></i> <a href="Order.php">Order History</a></li>
        <li> <i class='bx bx-dollar' ></i> <a href="revenue.php">Revenues</a></li>
        <li> <i class='bx bx-cog' ></i> <a href="settings.php">Settings</a></li>
        <li> <i class='bx bx-log-out'></i> <a href="/WEB-SYSTEM/pages/admin/logout.php">Logout</a></li>



    </ul>
</div>

<header>
    <div class="header">
        <h1>Inventory</h1>
    </div>
</header>

<div class="container">
    <form method="POST" action="">
        <label for="item-name">Item Name:</label>
        <input type="text" id="item-name" name="item-name" required>
        <label for="item-quantity">Quantity:</label>
        <input type="number" id="item-quantity" name="item-quantity" required>
        <label for="item-price">Price:</label>
        <input type="number" id="item-price" name="item-price" required>
        <button type="submit">Add Item</button>
    </form>

    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        $sql_select = "SELECT * FROM items";
        $result_select = $conn->query($sql_select);

        while ($row = $result_select->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td>" . $row['item_quantity'] . "</td>";
            echo "<td>" . $row['item_price'] . "</td>";
            echo "<td><a href='?action=remove&id=" . $row['id'] . "'>Remove</a> | <button onclick='showUpdateForm(" . $row['id'] . ")'>Update</button></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Update Item Form (Initially hidden) -->
    <div id="updateForm" style="display: none;">
        <form method="POST" action="">
            <input type="hidden" id="item-id" name="item-id">
            <label for="new-quantity">New Quantity:</label>
            <input type="number" id="new-quantity" name="new-quantity" required>
            <label for="new-price">New Price:</label>
            <input type="number" id="new-price" name="new-price" required>
            <button type="submit" name="update-item">Update Item</button>
        </form>
    </div>

    <script>
        function showUpdateForm(itemId) {
            document.getElementById('item-id').value = itemId;
            document.getElementById('updateForm').style.display = 'block';
        }
    </script>
</div>

</body>
</html>
