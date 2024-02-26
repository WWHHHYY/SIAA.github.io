<?php
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /WEB-SYSTEM/pages/admin/login.php");
    exit();
}

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbase = "siaa";

$conn = new mysqli($servername, $username, $password, $dbase);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM Users WHERE Username = '$username'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
} else {
    // Handle the case when user data is not found
    die("User not found");
}

// Handle form submission to update user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated data from the form
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Update the user's profile in the database
    $updateQuery = "UPDATE Users SET username='$newName', Email='$newEmail', password='$newPassword' WHERE username='$username'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "Profile updated successfully";
        // Optionally, you can redirect to another page after the update
        // header("Location: some_other_page.php");
        // exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="../../css/setting.css">
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
            <li> <i class='bx bx-home' ></i> <a href="Dashboard.php">Home</a> </li>
            <li> <i class='bx bx-cart' ></i> <a href="Inventory.php">Inventory</a></li>
            <li> <i class='bx bx-history' ></i> <a href="Order.php">Order History</a></li>
            <li> <i class='bx bx-dollar' ></i> <a href="revenue.php">Revenues</a></li>
            <li> <i class='bx bx-log-out'></i> <a href="/WEB-SYSTEM/pages/admin/logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="container">
        <form method="post" onsubmit="return confirm('Are you sure you want to save changes?');">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user_data['username']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['Email']; ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $user_data['password']; ?>" required>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
