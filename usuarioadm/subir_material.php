<?php
include('conexion.php');

// Ruta donde se guardará el archivo en el servidor
$carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/archivos_subidos/';

if(isset($_FILES['archivo'], $_POST['TipoArchivo']) && !empty($_FILES['archivo']['name']) && !empty($_POST['TipoArchivo'])) {
    // Nombre del archivo
    $nombre_archivo = $_FILES['archivo']['name'];
    $tipo_archivo = $_POST['TipoArchivo'];

    // Ruta completa del archivo en el servidor
    $ruta_archivo = $carpeta_destino . $nombre_archivo;

    // Mover el archivo al servidor
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)) {
        // El archivo se movió correctamente, ahora puedes guardar la ruta en la base de datos
        // Inserta la información del archivo en la base de datos
        $query_insert = "INSERT INTO archivo_material (NombreArchivo, TipoArchivo, RutaArchivo) VALUES (?, ?, ?)";
        $stmt_insert = $conexion->prepare($query_insert);
        $stmt_insert->bind_param("sss", $nombre_archivo, $tipo_archivo, $ruta_archivo);
        $stmt_insert->execute();

        // Redireccionar a la página de materiales después de subir el archivo
        header("Location: archivoMateriales.php");
        exit();
    } else {
        // Error al mover el archivo
        echo "Error al subir el archivo.";
    }
} else {
    echo "Error: Datos insuficientes o incorrectos.";
}

// Cerramos la conexión
$conexion->close();
?>
