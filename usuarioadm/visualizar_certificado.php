<?php
include('conexion.php');
include('validarsesion.php');
include('../vista/mensaje.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../media/locenca.png" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Certificado</title>
</head>
<body>
    <?php
    $certificadoID = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$certificadoID || !is_numeric($certificadoID)) {
        echo "ID de certificado no válido.";
        exit;
    }
    include('conexion.php');

    $consultaCertificado = "SELECT NombreCertificado, ArchivoPDF FROM certificados WHERE CertificadoID = ?";
    $stmt = mysqli_prepare($conexion, $consultaCertificado);
    mysqli_stmt_bind_param($stmt, 'i', $certificadoID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombreCertificado, $archivoPDF);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($archivoPDF) {
        echo "<embed src='data:application/pdf;base64," . base64_encode($archivoPDF) . "' type='application/pdf' width='100%' height='800px' />";
    } else {
        echo "El certificado no está disponible.";
    }

    mysqli_close($conexion);
    ?>
</body>
</html>
