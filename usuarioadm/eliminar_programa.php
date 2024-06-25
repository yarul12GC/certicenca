<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $ProgramaID = $_GET['id'];
    $queryEliminar = "DELETE FROM programasestudio WHERE ProgramaID = $ProgramaID";

    if (mysqli_query($conexion, $queryEliminar)) {
        header("Location: programa.php?success=1");
        exit();
    } else {
        echo "Error al eliminar el tipo de estudio: " . mysqli_error($conexion);
    }
} else {
    echo "ID no válido o no proporcionado.";
}
?>