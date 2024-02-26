<?php
session_start();
include '../../include/config.php';

if (!$conn->connect_error) {
    echo ""; 
}

$sql = "SELECT log_id, log_date, logs_username, action, details FROM logs ORDER BY log_id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Logs</title>
    <link rel="stylesheet" type="text/css" href="../../css/dash.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    <div class="sidebar">
        <h2>Logs</h2>
        <ul>
            <li> <i class='bx bx-home'></i> <a href="Dashboard.php">Home</a> </li>
            <li> <i class='bx bx-cart'></i> <a href="Inventory.php">Inventory</a></li>
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
            <h1>Logs</h1>
        </div>
    </header>

    <?php
    if ($result->num_rows > 0) {
        echo "<table class='LogsTable'>";
        echo "<tr>";
        echo "<th>Date</th>";
        echo "<th>Username</th>";
        echo "<th>Action</th>";
        echo "<th>Details</th>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['log_date'] . "</td>";
            echo "<td>" . $row['logs_username'] . "</td>";
            echo "<td>" . $row['action'] . "</td>";
            echo "<td>" . $row['details'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<br>Empty";
    }
    ?>
</body>

</html>
