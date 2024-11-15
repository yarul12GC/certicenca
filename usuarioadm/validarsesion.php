<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si la sesión está activa
if (!isset($_SESSION['email'])) {
    header("Location: https://certicenca.cencacomex.com.mx/");
    exit();
}

$tiempoInactividad = 1200; //  minutos (en segundos)
if (isset($_SESSION['tiempo']) && (time() - $_SESSION['tiempo'] > $tiempoInactividad)) {
    session_unset();
    session_destroy();
    header("Location: https://certicenca.cencacomex.com.mx/");
    exit();
}
$_SESSION['tiempo'] = time();

include('conexion.php');

$email = $_SESSION['email'];
$stmt = mysqli_prepare($conexion, "SELECT TipoUsuarioID FROM usuarios WHERE email = ?");
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_bind_result($stmt, $tipoUsuarioID);
    mysqli_stmt_fetch($stmt);

    if ($tipoUsuarioID != 2) {
        mysqli_stmt_close($stmt);
        echo '<script>alert("No tienes permisos para acceder a esta página.");</script>';
        header("Location: https://certicenca.cencacomex.com.mx/");
        exit();
    }
} else {
    mysqli_stmt_close($stmt);
    echo '<script>alert("Usuario no encontrado. Por favor, inicia sesión nuevamente.");</script>';
    header("Location: https://certicenca.cencacomex.com.mx/");
    exit();
}
?>
