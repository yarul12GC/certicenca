<?php
include 'startSession.php';
require 'conexion.php';
?>

// Obtener los datos del formulario
$entrada_id = $_POST["entrada_id"];
$material = $_POST["material"];
$producto = $_POST["ProductoID"];
$cantidad = $_POST["cantidad"];
$unidad_medida = $_POST["unidad_medida"];
$monto = $_POST["monto"];
$fecha_recibo = $_POST["fecha_recibo"];
$proveedor = $_POST["ProveedorID"];
$cliente = $_POST["ClienteID"];
$num_factura_control_recibo = $_POST["num_factura_control_recibo"];
$orden_compra = $_POST["orden_compra"];
$identificador_sistema_corporativo = $_POST["identificador_sistema_corporativo"];
$contribuyente = $_POST["ContribuyenteID"];

// Preparar la consulta SQL para actualizar el registro
$sql = "UPDATE interfasesalidas SET MaterialID=$material, ProductoID=$producto, Cantidad=$cantidad, UnidadMedidaComercializacion='$unidad_medida', MontoDolares=$monto, FechaRecibo='$fecha_recibo', ProveedorID=$proveedor, ClienteID=$cliente, NumFacturaControlRecibo='$num_factura_control_recibo', OrdenCompra='$orden_compra', IdentificadorSistemaCorporativo='$identificador_sistema_corporativo', ContribuyenteID=$contribuyente WHERE InterfaseEntradaID=$entrada_id";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    // Redirigir a la página de éxito
    header("Location: salidas.php?mensaje=exito");
    exit();
} else {
    echo "Error al actualizar el registro: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
