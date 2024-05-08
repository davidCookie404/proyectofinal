<?php
$servername = "localhost";
$username = "root";
$password = "zezaguso10";
$database = "sessionzero";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$conn->close();
?>
