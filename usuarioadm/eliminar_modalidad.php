<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $ModalidadID = $_GET['id'];
    $queryEliminar = "DELETE FROM modalidadesestudio WHERE ModalidadID = $ModalidadID";

    if (mysqli_query($conexion, $queryEliminar)) {
        header("Location: modalidades.php?success=1");
        exit();
    } else {
        echo "Error al eliminar el tipo de estudio: " . mysqli_error($conexion);
    }
} else {
    echo "ID no válido o no proporcionado.";
}
?>