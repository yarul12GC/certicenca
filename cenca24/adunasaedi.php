<?php

include 'startSession.php';

require 'conexion.php';

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID de la aduana de salida
    if (isset($_POST['aduana_salida_id'])) {
        // Obtener los datos del formulario
        $aduana_salida_id = $_POST['aduana_salida_id'];
        $num_pedimento = $_POST['num_pedimento'];
        $fecha_pedimento = $_POST['fecha_pedimento'];
        $clave_pedimento = $_POST['clave_pedimento'];
        $pais_destino = $_POST['pais_destino'];
        $aduana_entrada_id = $_POST['AduanaEntradaID'];
        $material_id = $_POST['MaterialID'];
        $CantidadSalidaAd = $_POST['CantidadSalidaAd'];
        $factura_comercial = $_POST['factura_comercial'];
        $tipo_impuesto = $_POST['TipoImpuesto'];
        $tasa_impuesto = $_POST['TasaDeImpuesto'];
        $aviso_electronico = $_POST['aviso_electronico'];
        $fecha_cruce = $_POST['fecha_cruce'];
        $contribuyente_id = $_POST['contribuyente_id'];
        $ClienteID = $_POST['ClienteID'];
        $ProductoID = $_POST['ProductoID'];
        $submanufactura_id = $_POST['SubmanufacturaID'];
        $agente_aduanal_id = $_POST['AgenteAduanalID'];
        $proveedor_id = $_POST['ProveedorID'];

        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE aduanasalidas SET 
                            NumeroPedimento = '$num_pedimento', 
                            FechaPedimento = '$fecha_pedimento', 
                            ClavePedimento = '$clave_pedimento', 
                            PaisOrigenMercancia = '$pais_destino', 
                            AduanaEntradaID = '$aduana_entrada_id', 
                            MaterialID = '$material_id', 
                            CantidadSalidaAd = '$CantidadSalidaAd',
                            FacturaComercial = '$factura_comercial', 
                            tipoImpuesto = '$tipo_impuesto', 
                            TasaDeImpuesto = '$tasa_impuesto', 
                            AvisoElectronico = '$aviso_electronico', 
                            FechaCruce = '$fecha_cruce', 
                            ContribuyenteID = '$contribuyente_id', 
                            ClienteID = '$ClienteID', 
                            ProductoID = '$ProductoID',
                            SubmanufacturaID = '$submanufactura_id', 
                            AgenteAduanalID = '$agente_aduanal_id', 
                            ProveedorID = '$proveedor_id' 
                            WHERE AduanaSalidaID = '$aduana_salida_id'";

        // Ejecutar la consulta de actualización
        if (mysqli_query($conn, $actualizar_query)) {
            header("Location: infoaduanera.php?mensaje=exito");
        } else {
            echo "Error al actualizar los datos: " . mysqli_error($conn);
        }
    } else {
        echo "No se recibió el ID de la aduana de salida.";
    }
}
