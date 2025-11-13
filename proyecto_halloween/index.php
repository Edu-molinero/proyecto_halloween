<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Ejemplo de Sesiones y Cookies</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>

<body>
    <div class="login-container">
        <h2><b>Login</b></h2>
        <form method="post" action="index.php">
            <label>
                <h3>Ingresa tu usuario:</h3>
            </label>
            <input type="text" name="nombre"><br><br>

            <label>
                <h3>Ingresa tu contraseña:</h3>
            </label>
            <input type="password" name="password"><br><br>
            <input type="submit" value="Entrar" name="enviar">
            <div id="error-msg" style="color:white; margin-top:10px;"></div>
        </form>
    </div>

    <?php
    if (isset($_POST['enviar'])) {
        $nombre = $_POST['nombre'];

        // Guardar en sesión el nombre de usuario y la hora en la que se hizo login
        $_SESSION['usuario'] = $nombre;
        $_SESSION['inicio'] = time();

        // Guardar en cookie (duración: 1 hora)
        setcookie("usuario", $nombre, time() + 3600, "/");

        // Redirigir a la página de bienvenida
        header("Location: home.php");
        exit;
    }
    ?>

    <!-- Canvas para el efecto Matrix con calabazas -->
    <canvas id="matrix-canvas"></canvas>

    <script>
    // Script inlined: efecto de muchas calabazas cayendo y eliminación del fondo blanco en runtime
    (function() {
        const canvas = document.getElementById('matrix-canvas');
        const ctx = canvas.getContext('2d');

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        // Cargar imagen de la calabaza
        const pumpkinSrc = 'imagen/calabaza.png';
        const pumpkinImg = new Image();
        pumpkinImg.src = pumpkinSrc;

        // Canvas auxiliar para procesar la imagen y quitar el fondo blanco
        const aux = document.createElement('canvas');
        const aCtx = aux.getContext('2d');
        let pumpkinCanvas = null; // contendrá la versión con transparencia

        function makeTransparentImage(img) {
            aux.width = img.width;
            aux.height = img.height;
            aCtx.clearRect(0, 0, aux.width, aux.height);
            aCtx.drawImage(img, 0, 0);
            const imgData = aCtx.getImageData(0, 0, aux.width, aux.height);
            const data = imgData.data;
            // Convertir píxeles casi blancos en transparentes
            for (let i = 0; i < data.length; i += 4) {
                const r = data[i],
                    g = data[i + 1],
                    b = data[i + 2];
                // Umbral: si r,g,b están cerca de 255, lo consideramos fondo
                if (r > 240 && g > 240 && b > 240) {
                    data[i + 3] = 0; // alpha = 0
                }
            }
            aCtx.putImageData(imgData, 0, 0);
            // Guardar en otro canvas para uso posterior
            pumpkinCanvas = document.createElement('canvas');
            pumpkinCanvas.width = aux.width;
            pumpkinCanvas.height = aux.height;
            pumpkinCanvas.getContext('2d').drawImage(aux, 0, 0);
        }

        // Parámetros
        const NUM = 120; // número de calabazas
        const drops = [];

        function rand(min, max) {
            return Math.random() * (max - min) + min;
        }

        // Inicializar drops
        function init() {
            for (let i = 0; i < NUM; i++) {
                drops.push({
                    x: rand(0, canvas.width),
                    y: rand(-canvas.height, 0),
                    speed: rand(40, 220), // px por segundo
                    size: rand(12, 36), // tamaño en px (escala para la imagen)
                    rot: rand(0, Math.PI * 2),
                    rotSpeed: rand(-1, 1) * 0.5
                });
            }
        }

        let last = performance.now();

        function loop(now) {
            const dt = (now - last) / 1000; // segundos
            last = now;

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < drops.length; i++) {
                const d = drops[i];
                d.y += d.speed * dt;
                d.rot += d.rotSpeed * dt;

                if (d.y - d.size > canvas.height) {
                    d.y = rand(-canvas.height * 0.25, -d.size);
                    d.x = rand(0, canvas.width);
                    d.speed = rand(40, 220);
                    d.size = rand(12, 36);
                }

                ctx.save();
                ctx.translate(d.x, d.y);
                ctx.rotate(d.rot);
                const w = d.size;
                const h = d.size;
                if (pumpkinCanvas) {
                    // Dibujar desde la versión procesada para transparencia
                    ctx.drawImage(pumpkinCanvas, -w / 2, -h / 2, w, h);
                } else if (pumpkinImg.complete) {
                    // fallback: dibujar la imagen original (si no se procesó)
                    ctx.drawImage(pumpkinImg, -w / 2, -h / 2, w, h);
                } else {
                    ctx.fillStyle = 'orange';
                    ctx.beginPath();
                    ctx.ellipse(0, 0, w / 2, h / 2, 0, 0, Math.PI * 2);
                    ctx.fill();
                }
                ctx.restore();
            }

            requestAnimationFrame(loop);
        }

        pumpkinImg.onload = function() {
            try {
                makeTransparentImage(pumpkinImg);
            } catch (e) {
                // Si hay tainted canvas por CORS, no podremos acceder a pixels
                console.warn(
                    'No se pudo procesar la imagen para eliminar fondo (CORS?). Usando imagen original.');
            }
            if (drops.length === 0) init();
            last = performance.now();
            requestAnimationFrame(loop);
        };

        // Iniciar de todos modos si la imagen tarda
        setTimeout(() => {
            if (drops.length === 0) init();
            if (!pumpkinImg.complete) {
                last = performance.now();
                requestAnimationFrame(loop);
            }
        }, 300);

    })();
    </script>
    <script>
document.querySelector('form').addEventListener('submit', function(event) {
    const usuario = document.querySelector('input[name="nombre"]').value;
    const contrasena = document.querySelector('input[name="password"]').value;
    const mensajeError = document.getElementById('error-msg');

    if (usuario === "" || contrasena === "") {
        event.preventDefault();
        mensajeError.textContent = "Debes poner nombre de usuario y contraseña";
    } else {
        mensajeError.textContent = "";
    }
});
</script>
</body>

</html>