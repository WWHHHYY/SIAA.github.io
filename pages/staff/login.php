<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="../../css/log.css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username"/>
                <input type="password" name="password" placeholder="Password"/>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username and password match a database entry
        $query = "SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
            
            // Authentication successful
            $_SESSION['username'] = $username;

            // Check user role
            if ($user_data['UserRole'] == 'admin') {
                header("Location: Dashboard.php");
                exit();
            } else {
                header("Location: ../staff/Dashboard.php");
                exit();
            }    
        } else {
            // Authentication failed
            echo "<script>alert('Invalid Username/Password');</script>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
