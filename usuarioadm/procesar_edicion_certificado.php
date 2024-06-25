<?php
include('conexion.php');
include('validarsesion.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['certificadoID']) && isset($_POST['nuevoNombreCertificado'])) {
        $certificadoID = $_POST['certificadoID'];
        $nuevoNombreCertificado = $_POST['nuevoNombreCertificado'];
        $consultaActualizar = "UPDATE certificados SET NombreCertificado = '$nuevoNombreCertificado' WHERE CertificadoID = $certificadoID";

        if (mysqli_query($conexion, $consultaActualizar)) {

            echo "<script>
            alert('¡Certificado actualizado correctamente!');
            window.location.href = 'certificados.php';
          </script>";

        } else {
            echo "Error al actualizar el certificado: " . mysqli_error($conexion);
        }
    } else {
        echo "Parámetros incorrectos.";
    }
} else {
    echo "Acceso denegado.";
}

mysqli_close($conexion);
?>
