<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $ProductoID = $_POST['ProductoID'];
    $NumParte = $_POST['NumParte'];
    $DescripcionProducto = $_POST['DescripcionProducto'];
    $FraccionArancelaria = $_POST['FraccionArancelaria'];
    $UnidadMedidaComercializacion = $_POST['UnidadMedidaComercializacion'];
    $UnidadMedidaTIGIE = $_POST['UnidadMedidaTIGIE'];
    $ProveedorID = $_POST["ProveedorID"];
    $ClienteID = $_POST["ClienteID"];

    try {
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE productos SET
            NumParte = '$NumParte',
            DescripcionProducto = '$DescripcionProducto',
            FraccionArancelaria = '$FraccionArancelaria',
            UnidadMedidaComercializacion = '$UnidadMedidaComercializacion',
            UnidadMedidaTIGIE = '$UnidadMedidaTIGIE',
            ProveedorID = '$ProveedorID',
            ClienteID = '$ClienteID'
            WHERE ProductoID = $ProductoID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: productos.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: productos.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}
