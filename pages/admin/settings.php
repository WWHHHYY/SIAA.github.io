<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="../../css/setting.css">
    <link rel="stylesheet" type="text/css" href="../../css/settingsoverlay.css">
    <!-- Boxicos CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>

<div class="header">
    <h1>Settings</h1>
</div>

<div class="sidebar">
    <h2>Settings</h2>
    <ul>
        <li> <i class='bx bx-home'></i> <a href="Dashboard.php">Home</a> </li>
        <li> <i class='bx bx-cart'></i> <a href="Inventory.php">Inventory</a></li>
        <li> <i class='bx bx-history'></i> <a href="Order.php">Order History</a></li>
        <li> <i class='bx bx-dollar'></i> <a href="revenue.php">Revenues</a></li>
        <li> <i class='bx bx-cog'></i> <a href="settings.php">Settings</a></li>
        <li> <i class='bx bx-log-out'></i> <a href="logout.php">Logout</a></li>
    </ul>
</div>

<<div class="container">
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th> <!-- Add a new column for the Edit button -->
        </tr>
        <?php
        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbase = "siaa";

        $conn = new mysqli($servername, $username, $password, $dbase);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve all users from the database
        $query = "SELECT * FROM users"; // Assuming your table name is "users"
        $result = $conn->query($query);

        if ($result === false) {
            die("Error retrieving users: " . $conn->error);
        }

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['UserRole'] . "</td>";
            echo "<td><button class='edit-btn' data-username='" . $row['username'] . "' data-email='" . $row['Email'] . "' data-role='" . $row['UserRole'] . "' onclick='openOverlay(\"" . $row['username'] . "\", \"" . $row['Email'] . "\", \"" . $row['UserRole'] . "\")'>Edit</button></td>";
            echo "</tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<div id="editOverlay" class="overlay">
    <div class="overlay-content">
        <span class="close-btn" onclick="closeOverlay()">&times;</span>
        <h2>Edit User</h2>
        <form id="editForm">
            <label for="editUsername">Username:</label>
            <input type="text" id="editUsername" name="editUsername" readonly>

            <label for="editEmail">Email:</label>
            <input type="text" id="editEmail" name="editEmail">

            <label for="editRole">Role:</label>
            <input type="text" id="editRole" name="editRole">

            <button type="submit" value="Save" class="save-btn" onclick="closeOverlay()">Save</button>
            <button type="button" class="cancel-btn" onclick="closeOverlay()">Cancel</button>
        </form>
    </div>
</div>


<!-- edit overlay -->
<script>
    function openOverlay(username, email, role) {
        document.getElementById("editUsername").value = username;
        document.getElementById("editEmail").value = email;
        document.getElementById("editRole").value = role;
        document.getElementById("editOverlay").style.display = "flex";
    }

    function closeOverlay() {
        document.getElementById("editOverlay").style.display = "none";
    }

    // You can add an event listener to handle form submission and update the user data in the database
    document.getElementById("editForm").addEventListener("submit", function (event) {
        // Handle form submission (you can use AJAX to update the data in the database)
        event.preventDefault();
        closeOverlay();
    });
</script>


</body>
</html>