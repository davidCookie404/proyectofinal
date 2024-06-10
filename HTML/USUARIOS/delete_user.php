<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: /HTML/index.php");
    exit();
}

// Comprobar si se proporciona el ID del usuario en la URL
if (!isset($_GET['usuario_id'])) {
    // Si no se proporciona, redirigir a una página adecuada o mostrar un error
    header("Location: /HTML/index.php"); // Redirigir a la página de inicio por ahora
    exit();
}

// Obtener el ID del usuario de la URL
$usuario_id = $_GET['usuario_id'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar y ejecutar la declaración SQL para eliminar al usuario
$sql = "DELETE FROM USUARIO WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirigir a una página adecuada después de la eliminación
header("Location: ../USUARIOS/admin_profile.php"); // Redirigir a la página de inicio por ahora
exit();
?>
