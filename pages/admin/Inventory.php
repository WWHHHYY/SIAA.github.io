<?php
session_start();

include('logs_action.php');

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

// logs

// Remove item
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id_to_remove = $_GET['id'];

    // Get item details before removal for archiving
    $sql_select_item = "SELECT * FROM items WHERE item_id = ?";
    $stmt_select_item = $conn->prepare($sql_select_item);
    $stmt_select_item->bind_param("i", $id_to_remove);
    $stmt_select_item->execute();

    $result_select_item = $stmt_select_item->get_result();

    if ($result_select_item->num_rows > 0) {
        $row_item = $result_select_item->fetch_assoc();
        $archived_item_id = $row_item['item_id'];
        $archived_item_name = $row_item['item_name'];
        $archived_item_quantity = $row_item['item_quantity'];
        $archived_item_price = $row_item['item_price'];
        $archived_product_type = $row_item['product_type'];
        $archived_prod_unit = $row_item['prod_unit'];

        // Insert item into archived_items table
        $sql_archive = "INSERT INTO archived_items (archived_item_id, archived_item_name, archived_item_quantity, archived_item_price, archived_product_type, archived_prod_unit) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_archive = $conn->prepare($sql_archive);
        $stmt_archive->bind_param("isdsss", $archived_item_id, $archived_item_name, $archived_item_quantity, $archived_item_price, $archived_product_type, $archived_prod_unit);
        $stmt_archive->execute();
        $stmt_archive->close();
    }
    $stmt_select_item->close();

    // Log the removal action
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Unknown User';
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown Username';
    $logMessage = "Item removed: $archived_item_name. Quantity: $archived_item_quantity, Price: $archived_item_price, Product Type: $archived_product_type, Product Unit: $archived_prod_unit, Username: $username";
    logAction($_SESSION['user_id'], $_SESSION['username'], 'Remove Item', $logMessage);

    // Remove item from the items table
    $sql_remove = "DELETE FROM items WHERE item_id = ?";
    $stmt_remove = $conn->prepare($sql_remove);
    $stmt_remove->bind_param("i", $id_to_remove);

    if ($stmt_remove->execute()) {
        // Redirect back to Inventory.php
        header("Location: Inventory.php");
        exit();
    } else {
        echo "Error removing item: " . $stmt_remove->error;
    }
    $stmt_remove->close();
}


// Update item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-item'])) {
    $item_id = $_POST['item-id'];
    $new_quantity = $_POST['new-quantity'];
    $new_price = $_POST['new-price'];
    $new_product_type = $_POST['new-product-type'];
    $new_prod_unit = $_POST['prod-unit']; // Updated line for prod_unit

    // Get item details before update for logging
    $itemNameBeforeUpdate = "";
    $quantityBeforeUpdate = "";
    $priceBeforeUpdate = "";
    $productTypeBeforeUpdate = "";
    $prodUnitBeforeUpdate = "";

    $sql_select_item_before_update = "SELECT * FROM items WHERE item_id = $item_id";
    $result_select_item_before_update = $conn->query($sql_select_item_before_update);

    if ($result_select_item_before_update->num_rows > 0) {
        $row_item_before_update = $result_select_item_before_update->fetch_assoc();
        $itemNameBeforeUpdate = $row_item_before_update['item_name'];
        $quantityBeforeUpdate = $row_item_before_update['item_quantity'];
        $priceBeforeUpdate = $row_item_before_update['item_price'];
        $productTypeBeforeUpdate = $row_item_before_update['product_type'];
        $prodUnitBeforeUpdate = $row_item_before_update['prod_unit'];
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE items SET item_quantity = ?, item_price = ?, product_type = ?, prod_unit = ? WHERE item_id = ?");
    $stmt->bind_param("dsssd", $new_quantity, $new_price, $new_product_type, $new_prod_unit, $item_id);

    if ($stmt->execute()) {
        // Log the update action
        $quantityChange = $new_quantity - $quantityBeforeUpdate;
        $priceChange = $new_price - $priceBeforeUpdate;
        $productTypeChange = $new_product_type !== $productTypeBeforeUpdate ? ", Product Type change: $productTypeBeforeUpdate to $new_product_type" : "";
        $prodUnitChange = $new_prod_unit !== $prodUnitBeforeUpdate ? ", Unit change: $prodUnitBeforeUpdate to $new_prod_unit" : "";
        $logMessage = "Item updated: $itemNameBeforeUpdate. Quantity change: $quantityChange, Price change: $priceChange$productTypeChange$prodUnitChange, Username: {$_SESSION['username']}";
        logAction($_SESSION['user_id'], $_SESSION['username'], 'Update Item', $logMessage);

        // Show a success popup using JavaScript
        echo '<script>alert("Item updated successfully. ' . addslashes($logMessage) . '");</script>';
    } else {
        // Show an error popup using JavaScript
        echo '<script>alert("Error updating item: ' . addslashes($stmt->error) . '");</script>';
    }

    $stmt->close();
}

// Add item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-item'])) {
    $item_name = $_POST['item-name'];
    $item_quantity = $_POST['item-quantity'];
    $item_price = $_POST['item-price'];
    $product_type = $_POST['new-product-type'];
    $prod_unit = $_POST['prod-unit'];

    // Check if item with the same name already exists
    $sql_check_existing = "SELECT * FROM items WHERE item_name = ?";
    $stmt_check_existing = $conn->prepare($sql_check_existing);
    $stmt_check_existing->bind_param("s", $item_name);
    $stmt_check_existing->execute();
    $result_check_existing = $stmt_check_existing->get_result();
    $stmt_check_existing->close();

    if ($result_check_existing->num_rows > 0) {
        // Item with the same name already exists
        echo '<script>alert("Item with the same name already exists. It is invalid to add a new item with the same name.");</script>';
        // You can redirect or handle the error logic here
    } else {
        // Item does not exist, proceed with adding
        $stmt = $conn->prepare("INSERT INTO items (item_name, item_quantity, item_price, product_type, prod_unit) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sddss", $item_name, $item_quantity, $item_price, $product_type, $prod_unit);

        if ($stmt->execute()) {
            // Log the add action with item details
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown Username';
            $logMessage = "Item added: $item_name. Type: $product_type, Unit: $prod_unit, Quantity: $item_quantity, Price: $item_price, Username: $username";
            logAction($_SESSION['user_id'], $_SESSION['username'], 'Add Item', $logMessage);
        } else {
            echo "Error adding item: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/shesh.css">
    <link rel="stylesheet" type="text/css" href="../../css/overlay.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ccajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    

<div class="sidebar">
        <ul>
        <h2>Inventory</h2>
		<li> <i class='bx bx-home'></i> <a href="Dashboard.php">Home</a> </li>
            <li> <i class='bx bx-cart'></i> <a href="Inventory.php">Inventory</a></li>
			<li> <i class='bx bx-user icon'></i> <a href="archive.php">archive</a></li>
            <li> <i class='bx bx-history'></i> <a href="Order.php">Order History</a></li>
            <li> <i class='bx bx-dollar'></i> <a href="revenue.php">Revenues</a></li>
			<li> <i class='bx bx-user-plus'></i> <a href="add.php">Add Account</a></li>
            <li> <i class='bx bx-user icon'></i> <a href="logs.php">Logs</a></li>
			<br><br><br><br><br><br><br> <br><br><br><br><br><br><br> <br><br><br><br><br><br><br>
            <li> <i class='bx bx-user-circle icon'></i> <a href="accounts.php">Accounts</a></li>
            <li> <i class='bx bx-log-out'></i> <a href="?action=logout">Logout</a></li>
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
        <label for="new-product-type">Product Type:</label>
        <input type="text" id="new-product-type" name="new-product-type" required>
        <label for="prod-unit">Product Unit:</label>
        <input type="text" id="prod-unit" name="prod-unit" required>
        <label for="item-quantity">Quantity:</label>
        <input type="number" id="item-quantity" name="item-quantity" required>
        <label for="item-price">Price:</label>
        <input type="number" id="item-price" name="item-price" required>
        <button type="submit" name="add-item">Add Item</button>
    </form>

    <table>
        <tr>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Unit</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        $sql_select = "SELECT item_id, item_name, product_type, prod_unit, item_quantity, item_price FROM items";
        $result_select = $conn->query($sql_select);

        while ($row = $result_select->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td>" . $row['product_type'] . "</td>";
            echo "<td>" . $row['prod_unit'] . "</td>";
            echo "<td>" . $row['item_quantity'] . "</td>";
            echo "<td>" . $row['item_price'] . "</td>";
            echo "<td>";
            echo "<a href='#' onclick='showRemoveConfirmation(" . $row['item_id'] . ", \"" . $row['item_name'] . "\")'>Remove</a> | ";
            echo "<button onclick='showUpdateForm(" . $row['item_id'] . "," . $row['item_quantity'] . "," . $row['item_price'] . ",\"" . $row['product_type'] . "\",\"" . $row['prod_unit'] . "\")'>Update</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Remove Confirmation Popup -->
    <div class="overlay" id="removeConfirmation">
        <div class="modal">
            <p id="removeText"></p>
            <button onclick="confirmRemove()">Yes</button>
            <button onclick="hideRemoveConfirmation()">No</button>
        </div>
    </div>

    <!-- Update Item Form (Initially hidden) -->
    <div class="overlay" id="overlay">
        <div class="modal" id="updateForm">
            <form method="POST" action="">
                <input type="hidden" id="item-id" name="item-id">
                <label for="new-quantity">New Quantity:</label>
                <input type="number" id="new-quantity" name="new-quantity" required>
                <label for="new-price">New Price:</label>
                <input type="number" id="new-price" name="new-price" required>
                <label for="update-product-type">New Product Type:</label>
                <input type="text" id="update-product-type" name="new-product-type" required>
                <label for="update-prod-unit">New Product Unit:</label>
                <input type="text" id="update-prod-unit" name="prod-unit" required>
                <button type="submit" name="update-item">Update Item</button>
                <button type="button" onclick="hideUpdateForm()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
    //FIX
    function showRemoveConfirmation(itemId, itemName) {
        var confirmationText = "Are you sure you want to remove '" + itemName + "'?";
        document.getElementById('removeText').innerHTML = confirmationText;
        document.getElementById('removeConfirmation').style.display = 'flex';
        document.getElementById('removeConfirmation').dataset.itemId = itemId;
    }

    function hideRemoveConfirmation() {
        document.getElementById('removeConfirmation').style.display = 'none';
    }

    function confirmRemove() {
        // Get the item id from the dataset
        var itemId = document.getElementById('removeConfirmation').dataset.itemId;
        window.location.href = '?action=remove&id=' + itemId;
    }

    function showUpdateForm(itemId, currentQuantity, currentPrice, currentProductType, currentProdUnit) {
    document.getElementById('item-id').value = itemId;
    document.getElementById('new-quantity').value = currentQuantity;
    document.getElementById('new-price').value = currentPrice;
    document.getElementById('update-product-type').value = currentProductType;
    document.getElementById('update-prod-unit').value = currentProdUnit;
    document.getElementById('overlay').style.display = 'flex';
}




    function hideUpdateForm() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

</body>

</html>
