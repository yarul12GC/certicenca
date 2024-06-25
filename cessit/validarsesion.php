<?php
require_once '../conexion.php';
// Configurar la ruta donde se guardarán los archivos de sesión
ini_set("session.save_path", "/var/cpanel/php/sessions/ea-php82");

// Iniciar o continuar la sesión
if (!session_start()) {
    echo "Error al iniciar la sesión";
    exit();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    header("Location: https://certicenca.cencacomex.com.mx/index.php");
    exit();
}

// Verificar el tiempo de inactividad de la sesión
$tiempoInactividad = 1200; // 10 minutos (en segundos)
if (isset($_SESSION['tiempo']) && (time() - $_SESSION['tiempo'] > $tiempoInactividad)) {
    // Destruir la sesión
    session_unset();
    session_destroy();
    header("Location: https://certicenca.cencacomex.com.mx/index.php");
    exit();
} else {
    // Actualizar el tiempo de la sesión
    $_SESSION['tiempo'] = time();
}

// Incluir el archivo de conexión a la base de datos
require_once '../conexion.php';

// Obtener el email del usuario de la sesión actual
$email = $_SESSION['email'];

// Preparar y ejecutar la consulta para obtener el TipoUsuarioID del usuario actual
$stmt = mysqli_prepare($conexion, "SELECT TipoUsuarioID FROM usuarios WHERE email = ?");
if (!$stmt) {
    echo "Error al preparar la consulta";
    exit();
}
mysqli_stmt_bind_param($stmt, 's', $email);
if (!mysqli_stmt_execute($stmt)) {
    echo "Error al ejecutar la consulta";
    exit();
}
mysqli_stmt_store_result($stmt);

// Verificar si la consulta fue exitosa y se encontró al usuario en la base de datos
if (mysqli_stmt_num_rows($stmt) > 0) {
    // Enlazar el resultado de la consulta
    mysqli_stmt_bind_result($stmt, $tipoUsuarioID);
    mysqli_stmt_fetch($stmt);

    // Verificar si el TipoUsuarioID es igual a 3 (tipo de usuario permitido)
    if ($tipoUsuarioID != 3) {
        header("Location: https://certicenca.cencacomex.com.mx/index.php");
        exit();
    }
} else {
    // Si no se encontró el usuario en la base de datos, mostrar un mensaje de error
    header("Location: https://certicenca.cencacomex.com.mx/index.php");
    exit();
}

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);
?>
