<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ModalidadID = $_POST['ModalidadID'];
    $NombreModalidad = $_POST['NombreModalidad'];

    // Evitar inyección SQL utilizando consultas preparadas
    $stmt = mysqli_prepare($conexion, "UPDATE modalidadesestudio SET NombreModalidad = ? WHERE ModalidadID = ?");
    
    mysqli_stmt_bind_param($stmt, 'si', $NombreModalidad, $ModalidadID);

    if (mysqli_stmt_execute($stmt)) {
        // Tipo de estudio editado con éxito
        header("Location: modalidades.php");
        exit();
    } else {
        // Error al editar el tipo de estudio
        echo "Error al editar el tipo de estudio: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}
?>
