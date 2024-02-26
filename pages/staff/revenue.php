<?php
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /WEB-SYSTEM/pages/admin/login.php");
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
    <h2>Revenues</h2>
    <ul>
        <li> <i class='bx bx-home'></i> <a href="Dashboard.php">Home</a> </li>
        <li> <i class='bx bx-cart'></i> <a href="Inventory.php">Inventory</a></li>
        <li> <i class='bx bx-history'></i> <a href="Order.php">Order History</a></li>
        <li> <i class='bx bx-dollar'></i> <a href="revenue.php">Revenues</a></li>
        <li> <i class='bx bx-cog'></i> <a href="settings.php">Settings</a></li>
        <li> <i class='bx bx-log-out'></i> <a href="/WEB-SYSTEM/pages/admin/logout.php">Logout</a></li>
    </ul>
</div>

<div class="header">
    <h1>Revenues</h1>
</div>

<div class="container">
    <table>
        <tr>
            <th>Month</th>
            <th>Revenue</th>
        </tr>
        <tr>
            <td>January</td>
            <td>P10,000</td>
        </tr>
        <tr>
            <td>February</td>
            <td>P12,000</td>
        </tr>
        <tr>
            <td>March</td>
            <td>P15,000</td>
        </tr>
    </table>
</div>

</body>
</html>
