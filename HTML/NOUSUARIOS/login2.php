<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "1234";
$database = "sessionzero";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_electronico = $_POST['email'];
    $contraseña = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE correo_electronico = '$correo_electronico'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($contraseña, $row['contraseña'])) {
            $_SESSION['user_id'] = $row['usuario_id'];
            $_SESSION['username'] = $row['nombre_usuario'];
            $_SESSION['is_admin'] = $row['is_admin'];

            if ($_SESSION['is_admin']) {
                header("Location: ../USUARIOS/admin_profile.php");
            } else {
                header("Location: ../USUARIOS/profile.php");
            }
            exit();
        } else {
            header("Location: login.php?error=Contraseña%20equivocada.%20Vuelva%20a%20intentarlo");
            exit();
        }
    } else {
        header("Location: login.php?error=No%20se%20ha%20encontrado%20el%20correo%20en%20la%20base%20de%20datos");
        exit();
    }
}

$conn->close();
?>
