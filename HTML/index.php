<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // SI lo ha hecho, se irá a la dirección marcada
    header("Location: /HTML/USUARIOS/loggedin_index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Zero</title>
    <link rel="icon" type="image/x-icon" href="/Images/favicon.ico">
    <link rel="stylesheet" href="/CSS/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <header>
        <h1>SESSION ZERO</h1>
        <nav>
            <ul>
                <li><a href="/HTML/index.php">Inicio</a></li>
                <li><a href="./NOUSUARIOS/login.php">Iniciar Sesión</a></li>
                <li><a href="./NOUSUARIOS/registro.php">Registro</a></li>
            </ul>
        </nav>
    </header>

<main>
    <section class="container">
        <h2>¡Bienvenid@ a Session Zero!</h2>
        <p>Create</p>
        <a href="#" class="cta-button">¡Empieza ya!</a>
    </section>
    <section class="container d-flex">
        <div class="row">
            <div class="col-6">pepito</div>
            <div class="col-6">pepito</div>
        </div>

        <div class="container">
            <p>Texto con hover</p>
            <div class="bocadillo">
                <p>Otro texto dentro del bocadillo</p>
            </div>
        </div>
    </section>
</main>