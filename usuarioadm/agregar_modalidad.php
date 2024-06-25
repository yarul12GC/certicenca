<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NombreModalidad = $_POST['NombreModalidad'];

    $stmt = mysqli_prepare($conexion, "INSERT INTO modalidadesestudio (NombreModalidad) VALUES (?)");
    mysqli_stmt_bind_param($stmt, 's', $NombreModalidad);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: modalidades.php");
        exit();
    } else {
        echo "Error al agregar el tipo de estudio: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}
?>