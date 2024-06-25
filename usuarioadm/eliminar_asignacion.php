<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se recibió el parámetro ID
if (isset($_GET['id'])) {
    // Obtener el ID de la asignación de material
    $asignacionID = $_GET['id'];

    // Consulta para eliminar la asignación de material
    $query = "DELETE FROM asignaciones_materiales WHERE AsignacionID = $asignacionID";

    // Ejecutar la consulta
    if ($conexion->query($query) === TRUE) {
        // Redirigir de vuelta a la página principal o a donde sea necesario
        header("Location: materiales.php");
        exit();
    } else {
        echo "Error al eliminar la asignación: " . $conexion->error;
    }
} else {
    echo "ID de asignación no proporcionado.";
}
?>
