<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbase = "siaa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbase);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to log an action
function logAction($userId, $username, $action, $details) {
    global $conn;

    $userId = mysqli_real_escape_string($conn, $userId);
    $username = mysqli_real_escape_string($conn, $username);
    $action = mysqli_real_escape_string($conn, $action);
    $details = mysqli_real_escape_string($conn, $details);

    // Use prepared statement
    $stmt = $conn->prepare("INSERT INTO logs (user_id, logs_username, action, details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userId, $username, $action, $details);

    if ($stmt->execute()) {
        // Comment out or remove the following line
        // echo "Log recorded successfully";
    } else {
        // Comment out or remove the following line
        // echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Function to log changes when editing a user
function logEdit($userId, $oldUsername, $newUsername, $newEmail, $newRole, $loggedInUsername) {
    global $conn;

    $logDetails = "User ID: $userId, Old Username: $oldUsername, New Username: $newUsername, New Email: $newEmail, New Role: $newRole, Edited by: $loggedInUsername";

    // Use prepared statement
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, 'Edit User', ?)");
    $stmt->bind_param("is", $userId, $logDetails);

    if ($stmt->execute()) {
        // Comment out or remove the following line
        // echo "Log recorded successfully";
    } else {
        // Comment out or remove the following line
        // echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Function to log user addition
function logUserAddition($userId, $username, $email, $role) {
    global $conn;

    $logDetails = "User ID: $userId, Username: $username, Email: $email, Role: $role";

    // Use prepared statement
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, 'Add User', ?)");
    $stmt->bind_param("is", $userId, $logDetails);

    if ($stmt->execute()) {
        // Comment out or remove the following line
        // echo "Log recorded successfully";
    } else {
        // Comment out or remove the following line
        // echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Function to log user removal
function logUserRemoval($userId, $username, $email, $role) {
    global $conn;

    $logDetails = "User ID: $userId, Username: $username, Email: $email, Role: $role";

    // Use prepared statement
    $stmt = $conn->prepare("INSERT INTO logs (user_id, action, details) VALUES (?, 'Remove User', ?)");
    $stmt->bind_param("is", $userId, $logDetails);

    if ($stmt->execute()) {
        // Comment out or remove the following line
        // echo "Log recorded successfully";
    } else {
        // Comment out or remove the following line
        // echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Do not close the connection here
// $conn->close();
?>