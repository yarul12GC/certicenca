<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipoEstudioID = $_POST['TipoEstudioID'];
    $nombreTipoEstudio = $_POST['NombreTipoEstudio'];
    $stmt = mysqli_prepare($conexion, "UPDATE tiposestudio SET NombreTipoEstudio = ? WHERE TipoEstudioID = ?");
    
    mysqli_stmt_bind_param($stmt, 'si', $nombreTipoEstudio, $tipoEstudioID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: tipoestudio.php");
        exit();
    } else {
        echo "Error al editar el tipo de estudio: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}
?>
