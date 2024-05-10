<?php
session_start();

$error_message = ""; // Inicializa error en la URL si hubiese

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprobar si tanto el correo y contraseña están enviados correctamente
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $correo_electronico = $_POST['email'];
        $contraseña = $_POST['password'];

        // Detalles de la conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "zezaguso10";
        $database = "sessionzero";

        // Crear conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $database);

        // Comprobar el acceso o no a la base de datos
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Comprobar si el correo proporcionado existe
        $sql = "SELECT * FROM usuario WHERE correo_electronico = '$correo_electronico'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Se ha encontrado el correo, se verifica la contraseña
            $row = $result->fetch_assoc();
            if (password_verify($contraseña, $row['contraseña'])) {
                //La contraseña es correcta, se inicia sesión y se guardan los datos
                $_SESSION['user_id'] = $row['usuario_id'];
                $_SESSION['username'] = $row['nombre'];
                // Redigir al usuario a la URL correspondiente
                header("Location: ../USUARIOS/profile.php");
                exit();
            } else {
                $error_message = "Contraseña inválida. Vuelva a intentarlo";
            }
        } else {
            $error_message = "El correo no se encuentra en la base de datos";
        }
        //Cerrar la conexión con la base de datos
        $conn->close();
    }
}

// Redirect to login page with error message
header("Location: login.html?error=" . urlencode($error_message));
exit();
?>
