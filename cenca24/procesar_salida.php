<?php
include 'startSession.php';
include "conexion.php";

// Obtener los datos del formulario
$entrada_id = $_POST["entrada_id"];
$material = $_POST["material"];
$producto = $_POST["producto"];
$cantidad = $_POST["cantidad"];
$unidad_medida = $_POST["unidad_medida"];
$monto = $_POST["monto"];
$fecha_recibo = $_POST["fecha_recibo"];
$proveedor = $_POST["proveedor"];
$cliente = $_POST["cliente"];
$num_factura_control_recibo = $_POST["num_factura_control_recibo"];
$orden_compra = $_POST["orden_compra"];
$identificador_sistema_corporativo = $_POST["identificador_sistema_corporativo"];
$contribuyente = $_POST["contribuyente"];

// Preparar la consulta SQL para insertar el nuevo registro
$sql = "INSERT INTO interfasesalidas (InterfaseEntradaID, MaterialID, ProductoID, Cantidad, UnidadMedidaComercializacion, MontoDolares, FechaRecibo, ProveedorID, ClienteID, NumFacturaControlRecibo, OrdenCompra, IdentificadorSistemaCorporativo, ContribuyenteID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Vincular los parámetros
$stmt->bind_param("iiiisisiiisii", $entrada_id, $material, $producto, $cantidad, $unidad_medida, $monto, $fecha_recibo, $proveedor, $cliente, $num_factura_control_recibo, $orden_compra, $identificador_sistema_corporativo, $contribuyente);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a la página de éxito
    header("Location: salidas.php?mensaje=exito");
    exit();
} else {
    echo "Error al insertar el registro: " . $stmt->error;
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>
