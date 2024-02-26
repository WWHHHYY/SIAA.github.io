<?php
session_start();

include('logs_action.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbase = "siaa";

$conn = new mysqli($servername, $username, $password, $dbase);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {
    $usernameToRemove = $_POST["username"];

    // Fetch user details before removing
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $usernameToRemove);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();
    $stmt->close();

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $usernameToRemove);

    if ($stmt->execute()) {
        // Log the removal action
        logUserRemoval($userDetails['id'], $userDetails['username'], $userDetails['Email'], $userDetails['UserRole']);
        echo "User removed successfully";
    } else {
        echo "Error removing user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}

$conn->close();
?>
