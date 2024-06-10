<?php

// Detalles de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "sessionzero";

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Comprobar el acceso o no a la base de datos
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar los datos introducidos al form del registro
if (isset($_POST['submit'])) {
    // Se ajustan los datos del form del registro al código
    $nombre = $_POST['username'];
    $correo_electronico = $_POST['email'];
    $contraseña = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Comprobar si las contraseñas coinciden
    if ($contraseña !== $confirm_password) {
        echo "Las contraseñas no coinciden";
        exit(); // Stop script execution
    }

    //Se aplica la función hash a la contraseña para aumentar la seguridad
    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

    // Crear la consulta SQL para introducir los datos del form a la base de datos
    $sql = "INSERT INTO usuario (nombre_usuario, correo_electronico, contraseña) VALUES ('$nombre', '$correo_electronico', '$hashed_password')";

    // Execute query Ejecución de la consulta
    if ($conn->query($sql) === TRUE) {
        // Se completa el registo, se redirige el usuario a la URL correspondiente
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión con la base de datos
$conn->close();
?>
