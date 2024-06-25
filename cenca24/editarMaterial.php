<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $MaterialID = $_POST['MaterialID'];
    $NumParte = $_POST['NumParte'];
    $DescripcionMaterial = $_POST['DescripcionMaterial'];
    $FraccionArancelaria = $_POST['FraccionArancelaria'];
    $UnidadMedidaComercializacion = $_POST['UnidadMedidaComercializacion'];
    $UnidadMedidaTIGIE = $_POST['UnidadMedidaTIGIE'];
    $TipoMaterial = $_POST['TipoMaterial'];
    $ProveedorID = $_POST["ProveedorID"];
    $ClienteID = $_POST["ClienteID"];

    try {
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE materiales SET
            NumParte = '$NumParte',
            DescripcionMaterial = '$DescripcionMaterial',
            FraccionArancelaria = '$FraccionArancelaria',
            UnidadMedidaComercializacion = '$UnidadMedidaComercializacion',
            UnidadMedidaTIGIE = '$UnidadMedidaTIGIE',
            TipoMaterial = '$TipoMaterial',
            ProveedorID = '$ProveedorID',
            ClienteID = '$ClienteID'
            WHERE MaterialID = $MaterialID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: materiales.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: materiales.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}
