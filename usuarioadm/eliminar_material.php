<?php
include('conexion.php');

if(isset($_GET['archivoID'])) {
    $archivoID = $_GET['archivoID'];

    // Obtener la ruta del archivo a eliminar
    $query_ruta_archivo = "SELECT RutaArchivo FROM archivo_material WHERE ArchivoID = ?";
    $stmt_ruta_archivo = $conexion->prepare($query_ruta_archivo);
    $stmt_ruta_archivo->bind_param("i", $archivoID);
    $stmt_ruta_archivo->execute();
    $stmt_ruta_archivo->store_result();

    if ($stmt_ruta_archivo->num_rows > 0) {
        $stmt_ruta_archivo->bind_result($ruta_archivo);
        $stmt_ruta_archivo->fetch();
        
        // Verificar si el archivo existe antes de intentar eliminarlo
        if (file_exists($ruta_archivo)) {
            // Eliminar el archivo del sistema de archivos
            if (unlink($ruta_archivo)) {
                // Eliminar el registro del archivo de la base de datos
                $query_eliminar_archivo = "DELETE FROM archivo_material WHERE ArchivoID = ?";
                $stmt_eliminar_archivo = $conexion->prepare($query_eliminar_archivo);
                $stmt_eliminar_archivo->bind_param("i", $archivoID);
                $stmt_eliminar_archivo->execute();

                if ($stmt_eliminar_archivo->affected_rows > 0) {
                    // Redireccionar a la página de materiales después de eliminar el archivo
                    header("Location: archivoMateriales.php");
                    exit();
                } else {
                    echo "Error: No se pudo eliminar el registro del archivo de la base de datos.";
                }
            } else {
                echo "Error: No se pudo eliminar el archivo del sistema de archivos.";
            }
        } else {
            echo "Error: El archivo a eliminar no existe.";
        }
    } else {
        echo "Error: No se encontró el archivo.";
    }

    $stmt_ruta_archivo->close();
} else {
    echo "Error: No se proporcionó el ID del archivo.";
}

// Cerramos la conexión
$conexion->close();
?>
