<?php
$servername = "localhost";
$username = "root";
$password = "zezaguso10";
$database = "sessionzero";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $nombre = $_POST['username'];
    $correo_electronico = $_POST['email'];
    $contraseña = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($contraseña !== $confirm_password) {
        echo "Las contraseñas no coinciden";
        exit(); // Stop script execution
    }

    // Hash the password
    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

    // Create the SQL query
    $sql = "INSERT INTO usuario (nombre, correo_electronico, contraseña) VALUES ('$nombre', '$correo_electronico', '$hashed_password')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
