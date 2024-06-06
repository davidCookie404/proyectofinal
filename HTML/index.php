<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    // SI lo ha hecho, se irá a la dirección marcada
    header("Location: /proyectofinal-main/HTML/USUARIOS/loggedin_index.php");
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
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s">

    
</head>
</body>
    <header class="header0">
        <div class="container">
            <div class="row w-100">
                <nav class="navbar navbar-expand-lg w-100">
                    <a class="navbar-brand" href="#">
                        <img class="imglogo" src="../images/5elogo.svg">
                    </a>
                    <button class="navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../HTML/index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./NOUSUARIOS/login.php">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./NOUSUARIOS/registro.php">Registro</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main class="site">
        <section class="container py-2">
            <h2 class="text-center">¡Bienvenid@ a Session Zero!</h2>
        </section>

        <!-- Comparador Imágenes -->
        <section class="container pb-5">
            <div class="row">
                <div class="col-lg-6 col-12 pt-2 div0 wrapper">
                    <div class="images">
                        <div class="img-1"></div>
                        <div class="img-2"></div>
                    </div>
                    <div class="slider">
                        <div class="drag-line">
                        <span></span>
                        </div>
                        <input type="range" min="0" max="96" value="50">
                    </div>
                </div>
                <div class="col-lg-1 col-12 p-4"></div>
                <div class="col-lg-5 col-12 p-4 div0">
                    <h3>¿Alguna vez has querido empezar pero te has sentido abrumado?</h3>
                    <h3>En <i>Session Zero</i> queremos que crear un personaje te sea llevadero</h3>
                    <h3>¡Solo tienes que registrate para acceder a la creación de personaje!</h3>
                    <a href="./NOUSUARIOS/registro.php" class="cta-button">Empieza ya</a>
                </div>
            </div>
            <!-- <div class="container">
                <p>Texto con hover</p>
                <div class="bocadillo">
                    <p>Otro texto dentro del bocadillo</p>
                </div>
            </div> -->
        </section>

        <!-- CARRUSEL -->
        <section class="container">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                </div>
                <div class="carousel-inner p-2 div0">
                    <div class="carousel-item active">
                        <img src="../images/bg01.webp" class="img-fluid carousel-image" alt="Los Angeles" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/bg02.jpg" class="img-fluid carousel-image custom-carousel-img" alt="Chicago" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/bg03.webp" class="img-fluid carousel-image" alt="New York" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="../images/bg04.jpg" class="img-fluid carousel-image" alt="Colorado" class="d-block w-100">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </section>

        <section>
            <div class="container pt-5">
                <div class="carousel-header">
                    <div class="row d-flex text-center">
                        <div>
                            <h2 class="t">¡Apoya el contenido oficial!</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-2 py-sm-4 position-relative">
                <div class="owl-carousel owl-theme position-relative" id="owl3a">
                    <div class="item">
                        <div class="container apoyo">
                            <a href="https://dnd.wizards.com/es/products/rpg_playershandbook" target="_blank"><img src="../images/book01.webp"></a>
                            <a href="https://dnd.wizards.com/es/products/rpg_playershandbook" target="_blank" class="button">Comprar</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="container apoyo">
                            <a href="https://dnd.wizards.com/es/products/dungeon-masters-guide" target="_blank"><img src="../images/book02.webp"></a>
                            <a href="https://dnd.wizards.com/es/products/dungeon-masters-guide" target="_blank" class="button">Comprar</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="container apoyo">
                            <a href="https://dnd.wizards.com/es/products/monster-manual" target="_blank"><img src="../images/book03.webp"></a>
                            <a href="https://dnd.wizards.com/es/products/monster-manual" target="_blank" class="button">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2024 Colorful Website. All rights reserved to <i><a class="text-muted" href="https://dnd.wizards.com/">Wizards of the Coast</a></i></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/index.js"></script>
    
</body>
</html>