<?php
// update_user.php

include('logs_action.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Your database connection code
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbase = "siaa";

    $conn = new mysqli($servername, $username_db, $password_db, $dbase);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the existing user data before the update
    $oldUserData = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($oldUserData && $oldUserData->num_rows > 0) {
        $oldUser = $oldUserData->fetch_assoc();
        $userId = $oldUser['user_id']; // Assuming there is a user_id field in your 'users' table
        $oldUsername = $oldUser['username'];
        
        // Update the user data in the database using the received values
        $sql = "UPDATE users SET Email='$email', UserRole='$role' WHERE username='$username'";
        if ($conn->query($sql) === TRUE) {
            // Log the edit action with the username of the logged-in user
            logEdit($userId, $oldUsername, $newUsername, $newEmail, $newRole);
            // Echo a response if needed
            echo "User data updated successfully";
        } else {
            // Handle errors if the query fails
            echo "Error updating user data: " . $conn->error;
        }
    } else {
        // Handle errors if user data retrieval fails
        echo "Error retrieving user data for edit";
    }

    // Close the database connection
    $conn->close();
}

?>