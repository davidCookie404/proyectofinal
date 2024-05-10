<?php
session_start();

// Check if user is logged in Comprobar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // Si es así, se le asigna el nombre de usuario que haya introducido
    $username = $_SESSION['username'];
} else {
    // Si no es así, se redirige al usuario al URL correspondiente
    header("Location: /HTML/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenid@!</title>
    <link rel="stylesheet" href="/CSS/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>SESSION ZERO</h1>
        <nav>
        <ul>
            <li><a href="/HTML/index.php">Inicio</a></li>
            <li><a href="../USUARIOS/character_sheet.php">Personajes</a></li>
            <li><a href="../USUARIOS/profile.php">       
            <?php if (isset($username)) : ?>
            <?php echo $username;?>
            <?php else : ?>
            <?php endif; ?></a></li>
        </ul>
        </nav>
    </header>
    <main>
    <section class="container">
        <?php if (isset($username)) : ?>
            <h2>¡Bienvenid@, <?php echo $username;?>!</h2>
        <?php else : ?>
            <h2>¡Bienvenid@s a Sesión Zero!</h2>
        <?php endif; ?>
        <p>Create</p>
        <a href="#" class="cta-button">¡Empieza ya!</a>
    </section>
    </main>
    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved.</p>
    </footer>
</body>
</html>