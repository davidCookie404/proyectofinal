<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    // Si no es así, se redirige al usuario al URL correspondiente
    header("Location: /HTML/index.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');

// Database connection
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "SessionZero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users
$sql = "SELECT usuario_id, nombre_usuario FROM USUARIO";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = [];
}

// Check if the user array is empty
if (empty($users)) {
    // Destroy the session
    session_unset();
    session_destroy();
    // Redirect to the login page or any other appropriate page
    header("Location: ../NOUSUARIOS/login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenid@!</title>
    <link rel="stylesheet" href="/CSS/index.css">
    <link rel="icon" type="image/x-icon" href="/Images/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="header0">
        <div class="container">
            <div class="row w-100">
                <nav class="navbar navbar-expand-lg w-100">
                    <a class="navbar-brand" href="#">
                        <img class="imglogo" src="/images/5elogo.svg" alt="Logo">
                    </a>
                    <button class="navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/HTML/index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../USUARIOS/character_sheet.php">Personajes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../USUARIOS/profile.php">       
                                    Admin
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../USUARIOS/logout.php">
                                    Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main class="site">
        <section>
            <header>
                <div class="container py-5 div0 d-flex justify-content-center">
                    <h1>Usuarios de <i>Session Zero</i></h1>
                </div>
            </header>
            <section>
            <section>
                <?php foreach ($users as $user) : ?>
                    <div class="container div1 my-5">
                        <div class="row py-5 d-flex align-items-center me-1">
                            <div class="col-6 me-0">
                                <h3><?php echo $user['nombre_usuario']?></h3>
                            </div>
                            <div class="col-2">
                                <a href="#"><i class="bi bi-person-fill ch-button"></i></a>
                            </div>
                            <div class="col-2">
                                <a href="delete_user.php?usuario_id=<?php echo $user['usuario_id']; ?>"><i class="bi bi-ban ch-button"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
                <!-- Repeat the above block for each user -->
            </section>
    </main>
    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved to <i><a class="text-muted" href="https://dnd.wizards.com/">Wizards of the Coast</a></i></p>
    </footer>
</body>
</html>
