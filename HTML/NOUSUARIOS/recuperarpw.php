<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "sessionzero";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in the database
    $sql = "UPDATE usuario SET contraseña='$hashed_password' WHERE correo_electronico='$email'";
    if ($conn->query($sql) === TRUE) {
        echo "Password has been reset successfully.";
        header("Location: login.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
