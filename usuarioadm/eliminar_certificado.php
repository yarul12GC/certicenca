<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['certificadoID'])) {
    $certificadoID = $_POST['certificadoID'];
    $consultaEliminar = "DELETE FROM certificados WHERE CertificadoID = ?";
    $stmt = mysqli_prepare($conexion, $consultaEliminar);
    mysqli_stmt_bind_param($stmt, 'i', $certificadoID);

    if (mysqli_stmt_execute($stmt)) {
        echo "Certificado eliminado exitosamente";
    } else {
        echo "Error al eliminar el certificado: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "ID del certificado no proporcionado";
}
?>
