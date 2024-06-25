<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ProgramaID = $_POST['ProgramaID'];
    $NombrePrograma = $_POST['NombrePrograma'];
    $stmt = mysqli_prepare($conexion, "UPDATE programasestudio SET NombrePrograma = ? WHERE ProgramaID = ?");
    
    mysqli_stmt_bind_param($stmt, 'si', $NombrePrograma, $ProgramaID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: programa.php");
        exit();
    } else {
        echo "Error al editar el tipo de estudio: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}
?>