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
$_SESSION['usuario'] = $nombre;
$_SESSION['inicio'] = time();
setcookie("usuario", $nombre, time() + 3600, "/");
header("Location: home.php");
exit;
}
?>

    <canvas id="matrix-canvas"></canvas>

    <script>
    (function() {
        const canvas = document.getElementById('matrix-canvas');
        const ctx = canvas.getContext('2d');

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();
        const pumpkinSrc = 'imagen/calabaza.png';
        const pumpkinImg = new Image();
        pumpkinImg.src = pumpkinSrc;
        const aux = document.createElement('canvas');
        const aCtx = aux.getContext('2d');
        let pumpkinCanvas = null;

        function makeTransparentImage(img) {
            aux.width = img.width;
            aux.height = img.height;
            aCtx.clearRect(0, 0, aux.width, aux.height);
            aCtx.drawImage(img, 0, 0);
            const imgData = aCtx.getImageData(0, 0, aux.width, aux.height);
            const data = imgData.data;
            for (let i = 0; i < data.length; i += 4) {
                const r = data[i],
                    g = data[i + 1],
                    b = data[i + 2];
                if (r > 240 && g > 240 && b > 240) {
                    data[i + 3] = 0;
                }
            }
            aCtx.putImageData(imgData, 0, 0);
            pumpkinCanvas = document.createElement('canvas');
            pumpkinCanvas.width = aux.width;
            pumpkinCanvas.height = aux.height;
            pumpkinCanvas.getContext('2d').drawImage(aux, 0, 0);
        }
        const NUM = 120;
        const drops = [];

        function rand(min, max) {
            return Math.random() * (max - min) + min;
        }

        function init() {
            for (let i = 0; i < NUM; i++) {
                drops.push({
                    x: rand(0, canvas.width),
                    y: rand(-canvas.height, 0),
                    speed: rand(40, 220),
                    size: rand(12, 36),
                    rot: rand(0, Math.PI * 2),
                    rotSpeed: rand(-1, 1) * 0.5
                });
            }
        }
        let last = performance.now();

        function loop(now) {
            const dt = (now - last) / 1000;
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
                    ctx.drawImage(pumpkinCanvas, -w / 2, -h / 2, w, h);
                } else if (pumpkinImg.complete) {
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
                console.warn('No se pudo procesar la imagen para eliminar fondo.');
            }
            if (drops.length === 0) init();
            last = performance.now();
            requestAnimationFrame(loop);
        };
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