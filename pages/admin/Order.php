<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
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
        <h2>Order</h2>
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
    <h1>Order History</h1>
</div>

<div class="container">
    <table>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Items</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>1</td>
            <td>10/25/2023</td>
            <td>TJ Hotdog, Tocino</td>
            <td>P1254</td>
        </tr>
        <tr>
            <td>2</td>
            <td>10/24/2023</td>
            <td>Nuggets, Longganisa</td>
            <td>P2412</td>
        </tr>
        <tr>
            <td>3</td>
            <td>10/23/2023</td>
            <td>Corned Beef, Sausage, Tapa</td>
            <td>P12420</td>
        </tr>
    </table>
</div>

</body>
</html>
