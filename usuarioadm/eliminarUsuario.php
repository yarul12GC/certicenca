<?php
include 'conexion.php';

$idUsuario = $_GET['id'];

// Verificar si hay asignaciones de materiales asociadas al usuario
$sqlVerificarAsignaciones = "SELECT COUNT(*) AS total FROM asignaciones_materiales WHERE UsuarioID = $idUsuario";
$resultado = $conexion->query($sqlVerificarAsignaciones);
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    $totalAsignaciones = $fila['total'];
    
    // Si hay asignaciones de materiales asociadas, mostrar un mensaje y no eliminar al usuario
    if ($totalAsignaciones > 0) {
        echo "No se puede eliminar el usuario porque tiene asignaciones de materiales asociadas.";
    } else {
        // No hay asignaciones de materiales asociadas, proceder con la eliminaci¨®n
        $sqlEliminarCertificados = "DELETE FROM certificados WHERE UsuarioID = $idUsuario";
        if ($conexion->query($sqlEliminarCertificados) === TRUE) {
            $sqlEliminarUsuario = "DELETE FROM usuarios WHERE UsuarioID = $idUsuario";
            if ($conexion->query($sqlEliminarUsuario) === TRUE) {
                header("Location: usuarios.php");
            } else {
                echo "Error al eliminar el usuario: " . $conexion->error;
            }
        } else {
            echo "Error al eliminar los certificados: " . $conexion->error;
        }
    }
} else {
    echo "Error al verificar las asignaciones de materiales: " . $conexion->error;
}

$conexion->close();
?>
