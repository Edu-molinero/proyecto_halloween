<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Página de Bienvenida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
:root {
    --halloween-orange: #B44E0A;
    --halloween-dark: #1b1b1b;
    --halloween-deep: #3a0f2f;
    --muted: #f4efe6;
}

body {
    background: linear-gradient(180deg, #0b0b0b 0%, #1b1b1b 60%);
    color: var(--muted);
    padding-top: 72px;
    /* espacio para navbar fijo */
    font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

.navbar-custom {
    background: linear-gradient(90deg, rgba(180, 78, 10, 0.95), rgba(58, 15, 47, 0.9));
    border-bottom: 3px solid rgba(0, 0, 0, 0.4);
}

.navbar-custom .nav-link {
    color: #ffeeda;
}

.navbar-custom .nav-link.active {
    color: white;
    font-weight: 600;
}

.hero {
    background: linear-gradient(180deg, rgba(180, 78, 10, 0.15), rgba(58, 15, 47, 0.12));
    border: 2px solid rgba(180, 78, 10, 0.12);
    padding: 2.5rem 1rem;
    text-align: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.6);
    color: var(--muted);
    border-radius: 8px;
}

.hero h1 {
    color: #fff7ec;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
}

footer.site-footer {
    background: linear-gradient(180deg, rgba(58, 15, 47, 0.9), rgba(18, 8, 10, 0.95));
    color: #ffeeda;
    padding: 2rem 0;
    margin-top: 2rem;
}

.social-btn {
    margin: 0 .4rem;
    color: #ffeeda;
    text-decoration: none;
    background: transparent;
    border: 1px solid rgba(255, 238, 217, 0.06);
    padding: .45rem .6rem;
    border-radius: 8px;
}

.social-btn:hover {
    background: rgba(180, 78, 10, 0.14);
    transform: translateY(-2px);
}

@media (min-width: 992px) {
    .news-image {
        min-height: 220px;
    }
}
</style>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
            aria-label="Toggle navigation"></button>

        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="https://www.youtube.com/shorts/wGzFU25m51I" style="letter-spacing:1px;">
                🎃 Halloween
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon" style="filter:invert(1) hue-rotate(200deg)"></span>
            </button>
            <form class="d-flex my-2 my-lg-0">
                <input class="form-control me-sm-2" type="text" placeholder="Buscar" />
                <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Enter</button>
            </form>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="../home.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="./sistema/noticias.html">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="./sistema/tienda.html">Tienda</a></li>
                </ul>
            </div>
        </div>

    </nav>

    <!-- Hero -->
    <main class="container">
        <section class="hero">
            <h1>Bienvenidos a Halloween - 31 Octubre</h1>
            <p class="lead">Aquí encontrarás la mejor página de noticias y la mejor tienda de Halloween de 2025.</p>
        </section>

        <!-- Contacto -->
        <section id="contacto" class="bg-light py-5">
            <div class="container text-bg-dark p-4 my-4 rounded">
                <h2 class="text-center mb-4 text-bg-dark">Quienes Somos</h2>
                <p class="text-center">Si tienes alguna duda crea un ticket</p>

                <!-- Formulario -->
                <div class="row justify-content-center mt-4">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="mb-3">Envíanos tu opinión</h5>
                                <form>
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" id="nombre" class="form-control" placeholder="Tu nombre">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mensaje" class="form-label">Mensaje</label>
                                        <textarea id="mensaje" class="form-control"
                                            placeholder="Escribe tu mensaje"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    // comprobar si la variable reservada sesion tiene un usuario
    if (isset($_SESSION['usuario'])) {
        echo "<p>Hola <strong>" . $_SESSION['usuario'] . "</strong>, tu nombre está guardado en la sesión.</p>";
    } else {
        echo "<p>No hay sesión activa.</p>";
    }

    // Mostrar desde cookie
    if (isset($_COOKIE['usuario'])) {
        echo "<p>También te recordamos con una cookie: <strong>" . $_COOKIE['usuario'] . "</strong></p>";
    } else {
        echo "<p>No hay cookie guardada.</p>";
    }
    // comprobar si la hora actual - la hora en la que se inicio sesion es mayor que 10, si es mayor
    // se redirige al usuario a la pagina de inicio con el parametro de expirado=1
    // al no ser responsive, hay que recargar la pagina para comprobar esa diferencia de tiempo
    if (isset($_SESSION['inicio']) && (time() - $_SESSION['inicio']) > 10) {
        // Destruir sesión
        session_unset();
        session_destroy();

        // Location: index.php?expirado=1
        // Esto de arriba va justo en las comillas del - header("Location: index.php?expirado=1");
        // Redirigir al login
        header("");
        exit;
    }
    ?>

        <footer class="site-footer">
            <div class="container text-center">
                <div class="mb-3">
                </div>
                <h5>Síguenos en nuestras redes sociales</h5>
                <br>
                <a class="social-btn" href="#" aria-label="Instagram">📸</a>
                <a class="social-btn" href="#" aria-label="Twitter">🐦</a>
                <a class="social-btn" href="#" aria-label="Facebook">📘</a>
                <a class="social-btn" href="#" aria-label="TikTok">🎵</a>
                <br>
                <br>
                <small>© 2025 Halloween. Todos los derechos reservados.</small>
                <br>
                <br>
                <a href="logout.php">Cerrar sesión y borrar las cookies</a>

            </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        </script>

</body>

</html>