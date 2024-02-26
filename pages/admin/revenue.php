<?php //this page will all be logs
session_start();
include '../../include/config.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Logout functionality
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Revenues</title>
    <link rel="stylesheet" type="text/css" href="../../css/reve.css">

    <!-- CSS and CDN links -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>

<div class="sidebar">
        <h2>Revenue</h2>
        <ul>
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

<div class="header">
    <h1>Revenues</h1>
</div>

<div class="container">
    <table>
        <?php
    $sql = "SELECT MONTH(FROM_UNIXTIME(order_date)) AS month, YEAR(FROM_UNIXTIME(order_date)) AS year, SUM(total) AS monthly_total
        FROM orders
        GROUP BY YEAR(order_date), MONTH(order_date)
        ORDER BY year DESC, month DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Month</th>";
    echo "<th>Year</th>";
    echo "<th>Total</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . date("F", mktime(0, 0, 0, $row['month'], 1)) . "</td>"; // Display month name
        echo "<td>" . $row['year'] . "</td>";
        echo "<td>" . $row['monthly_total'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No results found.";
}
?>
    </table>
</div>

</body>
</html>
