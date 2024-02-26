<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "siaa";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$itemName = $_GET['item_name'];
$sql_select_price = "SELECT item_price FROM items WHERE item_name = '$itemName'";
$result = $conn->query($sql_select_price);

$response = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['success'] = true;
    $response['price'] = $row['item_price'];
} else {
    $response['success'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
