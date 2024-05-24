<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
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
                        <img class="imglogo" src="/images/5elogo.svg">
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
                                <?php if (isset($username)) : ?>
                                <?php echo $username;?>
                                <?php else : ?>
                                <?php endif; ?>
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
                    <h1> Personajes de <i><?php if (isset($username)) : ?>
                                        <?php echo $username;?>
                                        <?php else : ?>
                                        <?php endif; ?></i>
                    </h1>
                </div>
            </header>
            <section>
                <div class="container div1 my-5">
                    <div class="row py-5 d-flex align-items-center me-1">
                        <div class="col-6 me-0">
                            <h3>xexinho</h3>
                        </div>
                        <div class="col-2   ">
                            <a href="#"><i class="bi bi-person-fill ch-button"></i></a>
                        </div>
                        <div class="col-2">
                            <a href="#"><i class="bi bi-ban ch-button"></i></a>
                        </div>
                    </div>
                </div>
                <div class="container div1 my-5">
                    <div class="row py-5 d-flex align-items-center me-2">
                        <div class="col-6">
                            <h3>xexinho</h3>
                        </div>
                        <div class="col-2">
                            <a href="#"><i class="bi bi-person-fill ch-button"></i></a>
                        </div>
                        <div class="col-2">
                            <a href="#"><i class="bi bi-ban ch-button"></i></a>
                        </div>
                    </div>
                </div>
                <div class="container div1 my-5">
                    <div class="row py-5 d-flex align-items-center me-2">
                    <div class="col-6">
                            <h3>xexinho</h3>
                        </div>
                        <div class="col-2">
                            <a href="#"><i class="bi bi-person-fill ch-button"></i></a>
                        </div>
                        <div class="col-2">
                            <a href="#"><i class="bi bi-ban ch-button"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
    </main>
    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved to <i><a class="text-muted" href="https://dnd.wizards.com/">Wizards of the Coast</a></i></p>
    </footer>
</body>
</html>