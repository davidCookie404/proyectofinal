<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Inicia Sesión!</title>
    <link rel="icon" type="image/x-icon" href="/Images/favicon.ico">
    <link rel="stylesheet" href="/CSS/index.css">
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
                                    <h2 class="mt-1 mb-5 pb-1 text-uppercase">RECUPERACIÓN DE CONTRASEÑA</h2>
                                    </div>
                                    <form action="recuperarpw.php" method="post">
                                        <div>
                                        <input type="email" name="email" class="form-control mb-4" placeholder="Correo Electrónico" required/>
                                        <input type="password" name="password" class="form-control mb-4" placeholder="Contraseña" required/>
                                        <input type="password" name="confirm_password" class="form-control mb-4" placeholder="Repite la contraseña" required/>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button type="submit" name="submit" class="btn custom-btn mb-4">Aceptar</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="/Images/login03.webp">
                            </div>
                        </div>
                    </div>x
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