<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="../../css/log.css">
</head>
<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Arial;
  font-size: 17px;
}

#myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%; 
  min-height: 89%;
}

.content {
  position: fixed;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  color: #f1f1f1;
  width: 100%;
  padding: 20px;
}

#myBtn {
  width: 200px;
  font-size: 18px;
  padding: 10px;
  border: none;
  background: #000;
  color: #fff;
  cursor: pointer;
}

#myBtn:hover {
  background: #ddd;
  color: black;
}
</style>

<body>
	<a style=display:block href="../../pages/admin/landing.php">
	<div><label>
	<img id=logo src="../../images/lg.png">
	</div></label></a>
    <div class="login-page">
        <div class="form">
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username"/>
                <input type="password" name="password" placeholder="Password"/>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>	
</body>
</html>
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
