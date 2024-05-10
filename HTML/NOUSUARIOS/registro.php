<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GUAU! TE REGISTRASTE YA WEON?</title>
    <link rel="stylesheet" href="/CSS/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <header>
        <h1>SESSION ZERO</h1>
        <nav>
            <ul>
                <li><a href="/HTML/index.php">Inicio</a></li>
                <li><a href="../NOUSUARIOS/login.php">Iniciar Sesión</a></li>
                <li><a href="../NOUSUARIOS/registro.php">Registro</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="card gx-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <h2 class="text-uppercase text-center mb-5">¡Únete ya!</h2>
                                    </div>
                                    <form action="datosregistro.php" method="post">
                                        <div>
                                        <input type="text" name="username" id="form3Example1cg" class="form-control mb-4" placeholder="Nombre de Usuario" required/>
                                        <input type="email" name="email" id="form3Example3cg" class="form-control mb-4" placeholder="Correo Electrónico" required/>
                                        <input type="password" name="password" id="form3Example4cg" class="form-control mb-4" placeholder="Contraseña" required/>
                                        <input type="password" name="confirm_password" id="form3Example4cdg" class="form-control mb-4" placeholder="Repite la contraseña" required/>
                                        <input type="checkbox" class="form-check-input me-2" id="form2Example3cg" required/>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                        <button type="submit" name="submit" class="btn custom-btn2 fa-lg mb-3">¡Registrate ya!</button>
                                        </div>
                                        <p class="text-center mt-5 mb-0">Tienes ya una cuenta? <a href="../NOUSUARIOS/login.php" class="fw-bold text-body"><u>Inicia sesión</u></a></p>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <img src="/Images/login02.webp">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Session Zero. All rights reserved.</p>
    </footer>
</body>
</html>