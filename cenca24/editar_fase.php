<?php
include 'startSession.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php"; 
    
    $InterfaseEntradaID = $_POST['InterfaseEntradaID'];
    $material = $_POST['material'];
    $ProductoID = $_POST['ProductoID'];
    $cantidad = $_POST['cantidad'];
    $UnidadMedidaComercializacion = $_POST['UnidadMedidaComercializacion'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $proveedor = $_POST['proveedor'];
    $num_factura = $_POST['num_factura'];
    $orden_compra = $_POST['orden_compra'];
    $IdentificadorSistemaCorporativo = $_POST['IdentificadorSistemaCorporativo'];
    $contribuyente = $_POST['contribuyente'];
    $ClienteID = $_POST['ClienteID'];

    $consulta_contribuyente = mysqli_query($conn, "SELECT ContribuyenteID FROM contribuyente WHERE ContribuyenteID = '$contribuyente'");
    if(mysqli_num_rows($consulta_contribuyente) == 0) {
        echo "Error: El ContribuyenteID no existe en la tabla contribuyente.";
        exit; 
    }

    $actualizar_entrada = "UPDATE interfaseentradas SET 
                        MaterialID = '$material', 
                        ProductoID = '$ProductoID', 
                        Cantidad = '$cantidad', 
                        UnidadMedidaComercializacion = '$UnidadMedidaComercializacion', 
                        MontoDolares = '$monto', 
                        FechaRecibo = '$fecha', 
                        ProveedorID = '$proveedor', 
                        NumFacturaControlRecibo = '$num_factura', 
                        OrdenCompra = '$orden_compra', 
                        IdentificadorSistemaCorporativo = '$IdentificadorSistemaCorporativo', 
                        ContribuyenteID = '$contribuyente', 
                        ClienteID = '$ClienteID' 
                        WHERE InterfaseEntradaID = '$InterfaseEntradaID'";

    if (mysqli_query($conn, $actualizar_entrada)) {
        header("Location: entradas.php?mensaje=exito");
    } else {
        echo "Error al actualizar la información: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
