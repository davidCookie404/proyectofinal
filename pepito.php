<?php
$servername = "localhost";
$username = "tu_usuario_de_mysql";
$password = "tu_contraseña_de_mysql";
$database = "sesion0";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos a insertar
$email = "ejemplo@example.com";
$contraseña = "contraseña_segura";

// Crear la consulta SQL
$sql = "INSERT INTO usuario (email, contraseña) VALUES ('$email', '$contraseña')";

if ($conn->query($sql) === TRUE) {
    echo "Registro insertado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
