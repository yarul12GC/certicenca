<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NombrePrograma = $_POST['NombrePrograma'];

    $stmt = mysqli_prepare($conexion, "INSERT INTO programasestudio (NombrePrograma) VALUES (?)");
    mysqli_stmt_bind_param($stmt, 's', $NombrePrograma);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: programa.php");
        exit();
    } else {
        echo "Error al agregar el tipo de estudio: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}
?>