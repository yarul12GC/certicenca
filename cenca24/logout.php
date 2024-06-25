<?php
// Iniciamos la sesión
session_start();

// Destruimos todas las variables de sesión
$_SESSION = array();

// Eliminamos la cookie de sesión si está presente
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
}

// Finalmente, destruimos la sesión
session_destroy();

// Redirigimos al usuario a la página de inicio o a donde desees después de cerrar sesión
header("Location: index.php"); // Cambia "index.php" por la página a la que quieres redirigir al usuario
exit();
