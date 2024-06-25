<?php
include 'startSession.php';
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php";

    $NumParte = $_POST["NumParte"];
    $DescripcionProducto = $_POST["DescripcionProducto"];
    $FraccionArancelaria = $_POST["FraccionArancelaria"];
    $UnidadMedidaComercializacion = $_POST["UnidadMedidaComercializacion"];
    $UnidadMedidaTIGIE = $_POST["UnidadMedidaTIGIE"];
    $ProveedorID = $_POST["ProveedorID"];
    $ClienteID = $_POST["ClienteID"];

    try {
        // Query para insertar el nuevo material en la base de datos
        $query = "INSERT INTO productos (NumParte, 
        DescripcionProducto, 
        FraccionArancelaria, 
        UnidadMedidaComercializacion, 
        UnidadMedidaTIGIE,  
        ProveedorID,
        ClienteID) 
        VALUES ('$NumParte', 
        '$DescripcionProducto', 
        '$FraccionArancelaria', 
        '$UnidadMedidaComercializacion', 
        '$UnidadMedidaTIGIE',  
        '$ProveedorID', 
        '$ClienteID')";
        // Ejecutar la consulta
        if (mysqli_query($conn, $query)) {
            // Éxito al registrar
            header("Location: productos.php?mensaje=exito_registro");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: productos.php?mensaje=error_registro");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
