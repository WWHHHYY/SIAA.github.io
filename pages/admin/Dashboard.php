<?php
session_start();

// Check if the user is not logged in, redirect to the login page
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
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <link rel=icon href=images/logo.png type=image> 
    <link rel="stylesheet" type="text/css" href="../../css/dash.css">

	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ccajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- Add your other head elements here -->

</head>

<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
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

    <div class="main">
		<div class="header">
			<h2>Welcome to CM NARIDO Dashboard</h2>
		</div>
		<div class="cards">
			<div class="card">
				<h3><a href="Inventory.php" id=inv>Products</a></h3>
				<p>1000+</p>
			</div>
			<div class="card">
				<h3><a href="Order.php" id=order>Orders</a></h3>
				<p>500</p>
			</div>
			<div class="card">
				<h3><a href="revenue.php" id=rev>Revenues</a></h3>
				<p>P10,000</p>
			</div>
		</div>
		<div class="table">
			<h2>Recent Orders</h2>
			<table>
				<tr>
					<th>Order ID</th>
					<th>Customer Name</th>
					<th>Product</th>
					<th>Price</th>
				</tr>
				<tr>
					<td>1</td>
					<td>Erika Balaguer</td>
					<td>Tender Juicy Hotdog</td>
					<td>P1000</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Earl Lagasca</td>
					<td>CDO: Young Pork Tocino</td>
					<td>P2000</td>
				</tr>
				<tr>
					<td>3</td>
					<td>Oscar Alavarez</td>
					<td>Holiday: Corned Beef</td>
					<td>P3000</td>
				</tr>
			</table>
		</div>
    </div>
</body>
</html>
