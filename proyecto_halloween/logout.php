<?php
session_start();

// Destruir la sesión
session_unset();
session_destroy();

// Borrar cookie
setcookie("usuario", "", time() - 3600, "/");

header("Location: index.php");
exit;
?>