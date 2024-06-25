<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreTipoEstudio = $_POST['nombreTipoEstudio'];

    $stmt = mysqli_prepare($conexion, "INSERT INTO tiposestudio (NombreTipoEstudio) VALUES (?)");
    mysqli_stmt_bind_param($stmt, 's', $nombreTipoEstudio);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: tipoestudio.php");
        exit();
    } else {
        echo "Error al agregar el tipo de estudio: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}
?>
