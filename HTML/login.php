<?php
session_start();

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both email and password are provided
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $correo_electronico = $_POST['email'];
        $contraseña = $_POST['password'];

        // Your database connection details
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

        // Prepare SQL statement to fetch user by email
        $sql = "SELECT * FROM usuario WHERE correo_electronico = '$correo_electronico'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // User found, verify password
            $row = $result->fetch_assoc();
            if (password_verify($contraseña, $row['contraseña'])) {
                // Password is correct, start session and store user data
                $_SESSION['user_id'] = $row['usuario_id'];
                $_SESSION['username'] = $row['nombre'];
                // Redirect user to profile page
                header("Location: profile.html");
                exit();
            } else {
                $error_message = "Invalid password. Please try again.";
            }
        } else {
            $error_message = "Email not found in the database.";
        }
        // Close connection
        $conn->close();
    }
}

// Redirect to login page with error message
header("Location: login.html?error=" . urlencode($error_message));
exit();
?>
