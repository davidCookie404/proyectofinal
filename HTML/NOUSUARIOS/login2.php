<?php
session_start();

// Detalles de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "sessionzero";

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Error si la conexión no se establece con éxito
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Comprobar los datos introducidos al form de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_electronico = $_POST['email'];
    $contraseña = $_POST['password'];

    // Crear la consulta SQL para introducir los datos del form a la base de datos
    $sql = "SELECT * FROM usuario WHERE correo_electronico = '$correo_electronico'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Se ha encontrado al usuario, busca la constraseña
        $row = $result->fetch_assoc();
        if (password_verify($contraseña, $row['contraseña'])) {
            // La contraseña es correcta
            $_SESSION['user_id'] = $row['usuario_id'];
            $_SESSION['username'] = $row['nombre_usuario'];
            $_SESSION['is_admin'] = $row['is_admin'];

            // Se le dirige a diferent URL dependiendo del tipo de usuario
            if ($_SESSION['is_admin']) {
                header("Location: ../USUARIOS/admin_profile.php");
            } else {
                header("Location: ../USUARIOS/profile.php");
            }
            exit();
        } else {
            $error_message = "Contraseña equivocada. Vuelva a intentarlo";
        }
    } else {
        $error_message = "No se ha encontrado el correo en la base de datos";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
