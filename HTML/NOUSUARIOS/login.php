<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Inicia Sesión!</title>
    <link rel="icon" type="image/x-icon" href="/Images/favicon.ico">
    <link rel="stylesheet" href="/proyectofinal-main/CSS/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <header class="header0">
        <div class="container">
            <div class="row w-100">
                <nav class="navbar navbar-expand-lg w-100">
                    <a class="navbar-brand" href="#">
                        <img class="imglogo" src="/proyectofinal-main/images/5elogo.svg">
                    </a>
                    <button class="navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/proyectofinal-main/HTML/index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../NOUSUARIOS/login.php">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../NOUSUARIOS/registro.php">Registro</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main class="site">
        <section>
            <div class="container">
                <div class="row">
                    <div class="card gx-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                    <h2 class="mt-1 mb-5 pb-1 text-uppercase">¡Únete ya!</h2>
                                    </div>
                                    <form action="login2.php" method="post">
                                        <div>
                                            <label class="form-label" for="formEx1">Correo Electrónico</label>
                                            <input type="text" name="email" id="formEx1" class="form-control mb-4" placeholder="" required>
                                            <label class="form-label" for="formEx2">Contraseña</label>
                                            <input type="password" name="password" id="formEx2" class="form-control mb-4" placeholder="" required>
                                        </div>
                                        <?php
                                    if(isset($_GET['error'])) {
                                        echo '<p class="alert alert-danger text-dark d-inline-block">' . urldecode($_GET['error']) . '</p>';
                                    }
                                    ?>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="submit" class="btn btn-outline-danger mb-4">Iniciar Sesión</button>
                                        </div>
                                    
                                        <div>
                                            <a class="d-flex justify-content-center text-muted mb-4" href="../NOUSUARIOS/recuperar_pw.php"><br>¿Olvidaste tu contraseña?</a>
                                        </div>
                                    
                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">¿Aún no tienes cuenta?</p>
                                            <a href="../NOUSUARIOS/registro.php" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Crear nueva cuenta</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="/proyectofinal-main/Images/login01.webp">
                            </div>
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
    <script src="/js/index.js"></script>
    
</body>
</html>