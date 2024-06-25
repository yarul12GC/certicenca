<?php
include('conexion.php');
include('validarsesion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioID = $_POST['usuarioID'];
    $nombreCertificado = $_POST['nombreCertificado'];
    $archivoPDF = file_get_contents($_FILES['archivoPDF']['tmp_name']);

    $verificarUsuario = "SELECT UsuarioID FROM usuarios WHERE UsuarioID = ?";
    $stmtVerificar = mysqli_prepare($conexion, $verificarUsuario);
    mysqli_stmt_bind_param($stmtVerificar, 'i', $usuarioID);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);

    if (mysqli_stmt_num_rows($stmtVerificar) > 0) {
        $queryInsert = "INSERT INTO certificados (UsuarioID, NombreCertificado, ArchivoPDF) VALUES (?, ?, ?)";
    
        $stmt = mysqli_prepare($conexion, $queryInsert);
        mysqli_stmt_bind_param($stmt, 'iss', $usuarioID, $nombreCertificado, $archivoPDF);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: certificados.php?success=1");
            exit();
        } else {
            echo "Error al subir el certificado: " . mysqli_error($conexion);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "El usuario con ID $usuarioID no existe.";
    }

    mysqli_stmt_close($stmtVerificar);
}

header("Location: certificados.php");
exit();
?>
