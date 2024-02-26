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

<div class="container">
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
            <th>Remove</th> 
        </tr>
        <?php
        session_start();

        

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbase = "siaa";

        $conn = new mysqli($servername  , $username, $password, $dbase);

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
            echo "<td>" . (isset($row['username']) ? $row['username'] : '') . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['UserRole'] . "</td>";
        
            // Edit button
            echo "<td><button class='edit-btn' data-username='" . (@$row['username'] ?: '') . "' data-email='" . $row['Email'] . "' data-role='" . $row['UserRole'] . "' onclick='openOverlay(\"" . (@$row['username'] ?: '') . "\", \"" . $row['Email'] . "\", \"" . $row['UserRole'] . "\")'>Edit</button></td>";
        
            // Remove button
            echo "<td><button class='remove-btn' data-username='" . (@$row['username'] ?: '') . "' onclick='removeUser(\"" . (@$row['username'] ?: '') . "\")'>Remove</button></td>";
        
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
<div id="editOverlay" class="overlay">
    <div class="overlay-content">
        <span class="close-btn" onclick="closeOverlay()">&times;</span>
        <h2>Edit User</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Username:</td>
                <td><span id="editUsername" class="editable" contenteditable="false"></span></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><span id="editEmail" class="editable" contenteditable="true"></span></td>
            </tr>
            <tr>
                <td>Role:</td>
                <td><span id="editRole" class="editable" contenteditable="true"></span></td>
            </tr>
        </table>
        <button type="button" class="save-btn" onclick="saveChanges()">Save</button>
        <button type="button" class="cancel-btn" onclick="closeOverlay()">Cancel</button>
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

    document.getElementById("editForm").addEventListener("submit", function (event) {
        event.preventDefault();

        var username = document.getElementById("editUsername").value;
        var email = document.getElementById("editEmail").value;
        var role = document.getElementById("editRole").value;

        // Create a FormData object
        var formData = new FormData();
        formData.append("username", username);
        formData.append("email", email);
        formData.append("role", role);

        // Create and send an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_user.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    location.reload(true);
                } else {
                    console.error("Error updating user data: " + xhr.statusText);
                }
            }
        };
        xhr.send(formData);

        closeOverlay();
    });
</script>

<script>


    function removeUser(username) {
        var confirmRemove = confirm("Are you sure you want to remove the user?");
        if (confirmRemove) {
            // Create and send an AJAX request to remove the user
            var xhrRemove = new XMLHttpRequest();
            xhrRemove.open("POST", "remove_user.php", true);
            xhrRemove.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhrRemove.onreadystatechange = function () {
                if (xhrRemove.readyState === 4) {
                    if (xhrRemove.status === 200) {
                        console.log(xhrRemove.responseText);
                        location.reload(true);
                    } else {
                        console.error("Error removing user: " + xhrRemove.statusText);
                    }
                }
            };
            xhrRemove.send("username=" + username);
        }
    }
</script>



</body>
</html>