<?php
// Iniciar sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    header("Location: https://certicenca.cencacomex.com.mx/index.php");
    exit();
}

$tiempoInactividad = 1200; // 10 minutos (en segundos)
if (isset($_SESSION['tiempo']) && (time() - $_SESSION['tiempo'] > $tiempoInactividad)) {
    session_unset();
    session_destroy();
    header("Location: https://certicenca.cencacomex.com.mx/index.php");
    exit();
}
$_SESSION['tiempo'] = time();

include('conexionlog.php');

$email = $_SESSION['email'];

$stmt = mysqli_prepare($conexion, "SELECT TipoUsuarioID FROM usuarios WHERE email = ?");
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Verificar si se encontró el usuario en la base de datos
if (mysqli_stmt_num_rows($stmt) > 0) {
    // Enlazar el resultado de la consulta
    mysqli_stmt_bind_result($stmt, $tipoUsuarioID);
    mysqli_stmt_fetch($stmt);

    // Verificar si el TipoUsuarioID es igual a 2 o 3 (tipos de usuario permitidos)
    if ($tipoUsuarioID != 2 && $tipoUsuarioID != 3) {
        echo '<script>alert("No tienes permisos para acceder a esta página.");</script>';
        header("Location: https://certicenca.cencacomex.com.mx/index.php");
        exit();
    }
} else {
    // Si no se encontró el usuario en la base de datos, mostrar un mensaje de error
    echo '<script>alert("Usuario no encontrado. Por favor, inicia sesión nuevamente.");</script>';
    header("Location:https://certicenca.cencacomex.com.mx/index.php");
    exit();
}

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);
?>
