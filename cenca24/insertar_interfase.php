<?php
include 'startSession.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include('conexion.php');
    
    // Recibir los datos del formulario
    $material = $_POST['material'];
    $producto = $_POST['ProductoID'];
    $cantidad = $_POST['cantidad'];
    $unidad_medida = $_POST['UnidadMedidaComercializacion'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $cliente = $_POST['ClienteID'];
    $proveedor = $_POST['proveedor'];
    $num_factura = $_POST['num_factura'];
    $orden_compra = $_POST['orden_compra'];
    $identificador_sistema = $_POST['IdentificadorSistemaCorporativo'];
    $contribuyente = $_POST['ContribuyenteID'];
    
    // Preparar la consulta SQL para insertar los datos
    $consulta = "INSERT INTO interfaseentradas (MaterialID, ProductoID, Cantidad, UnidadMedidaComercializacion, MontoDolares, FechaRecibo, ClienteID, ProveedorID, NumFacturaControlRecibo, OrdenCompra, IdentificadorSistemaCorporativo, ContribuyenteID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conn, $consulta);
    
    // Vincular los parámetros con los valores
    mysqli_stmt_bind_param($stmt, "iiisdsisssss", $material, $producto, $cantidad, $unidad_medida, $monto, $fecha, $cliente, $proveedor, $num_factura, $orden_compra, $identificador_sistema, $contribuyente);
    
    // Ejecutar la sentencia
    if (mysqli_stmt_execute($stmt)) {
        header("Location: entradas.php?mensaje=exito_registro");
    } else {
        echo "Error al insertar los datos: " . mysqli_error($conn);
    }
    
    // Cerrar la conexión y la sentencia
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Si no se ha enviado el formulario, redirigir al formulario
    header("Location: nombre_del_formulario.php");
    exit();
}
?>
