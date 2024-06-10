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
$password = "";  // Set password to empty string
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar una declaración para obtener los IDs de los personajes del usuario
$sql = "SELECT personaje_id FROM personaje WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$personaje_ids = [];
while ($row = $result->fetch_assoc()) {
    $personaje_ids[] = $row['personaje_id'];
}
$stmt->close();

// Eliminar los registros relacionados en la tabla `caracteristica_pj`
foreach ($personaje_ids as $personaje_id) {
    $sql = "DELETE FROM caracteristica_pj WHERE personaje_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $personaje_id);
    $stmt->execute();
    $stmt->close();
}

// Eliminar los registros relacionados en la tabla `personaje`
$sql = "DELETE FROM personaje WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->close();

// Ahora eliminar el usuario de la tabla `USUARIO`
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
