<?php
include('conexion.php');

if (isset($_GET['id'])) {
    $certificadoID = $_GET['id'];

    $consultaCertificado = "SELECT NombreCertificado, ArchivoPDF FROM certificados WHERE CertificadoID = ?";
    $stmt = mysqli_prepare($conexion, $consultaCertificado);
    mysqli_stmt_bind_param($stmt, 'i', $certificadoID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombreCertificado, $archivoPDF);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $nombreCertificado . '.pdf"');
    header('Content-Length: ' . strlen($archivoPDF));
    echo $archivoPDF;
    mysqli_close($conexion);
    exit();
} else {
    echo "ID del certificado no proporcionado";
}
?>
