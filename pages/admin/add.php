<?php
session_start();

include('logs_action.php');

$servername = "localhost";
$username = "root";
$password = "";
$database = "siaa";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-account'])) {
    $newUsername = $_POST['new-username'];
    $newEmail = $_POST['new-email'];
    $newPassword = $_POST['new-password'];
    $newRole = $_POST['new-role'];

    // Remove password hashing
    $stmt = $conn->prepare("INSERT INTO users (username, password, UserRole, Email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $newUsername, $newPassword, $newRole, $newEmail);

    if ($stmt->execute()) {
        echo "Account added successfully!";

        // Get the user ID of the newly added user
        $userId = $conn->insert_id;

        // Log user addition
        // Ensure that $_SESSION['username'] is set correctly
        logUserAddition($userId, $_SESSION['username'], $newEmail, $newRole);
    } else {
        echo "Error adding account: " . $stmt->error;
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/setting.css">
    <link rel="stylesheet" type="text/css" href="../../css/settingsoverlay.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css" href="../../css/shesh.css">
    <link rel="stylesheet" type="text/css" href="../../css/overlay.css">
</head>

<body>

    <div class="sidebar">
        <h2>Add Account</h2>
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

    <header>
        <div class="header">
            <h1>Account Management</h1>
        </div>
    </header>

    <div class="container">
        <form method="POST" action="">
            <label for="new-username">Username:</label>
            <input type="text" id="new-username" name="new-username" required>
            <label for="new-password">Password:</label>
            <input type="password" id="new-password" name="new-password" required>
            <label for="new-email">Email:</label>
            <input type="email" id="new-email" name="new-email" required>
            <label for="new-role">Role:</label>
            <input type="text" id="new-role" name="new-role" required>
            <button type="submit" name="add-account">Add Account</button>
        </form>

        <table>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Role</th>
        <th>Action</th>
    </tr>

    <?php
    $query = "SELECT * FROM users";
    $result = $conn->query($query);

    if ($result === false) {
        die("Error retrieving users: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . (isset($row['username']) ? $row['username'] : '') . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        // Display password with circles
        echo "<td class='password-field' data-password='" . htmlspecialchars($row['password']) . "'>&#8226;&#8226;&#8226;&#8226;&#8226;</td>";
        echo "<td>" . $row['UserRole'] . "</td>";
        // Add action button to reveal password
        echo "<td><button class='reveal-password-btn' onclick='revealPassword(this)'>Reveal</button></td>";
        echo "</tr>";
    }
    ?>
</table>

    </div>

    <!-- Additional JavaScript for password reveal -->
    <script>
    function revealPassword(button) {
        var row = button.parentNode.parentNode;
        var passwordField = row.querySelector('.password-field');
        var password = passwordField.getAttribute('data-password');
        passwordField.innerHTML = password;
        setTimeout(function () {
            passwordField.innerHTML = '<span class="password-circle">&#8226;</span>';
        }, 3000);
    }
</script>

</body>
</html>


