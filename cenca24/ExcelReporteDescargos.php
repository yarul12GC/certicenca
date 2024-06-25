<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex =
    "SELECT 
                          'Descargo de materiales' AS Tabla,
                            im.*,
                            im.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoMovi,  
                            ife.Cantidad AS CantidadE,                                              
                            ife.UnidadMedidaComercializacion AS UnidadMedidaComercializacionE,
                            ife.MontoDolares AS MontoDolaresE,
                            ife.FechaRecibo As FechaReciboEntrada,
                            ife.NumFacturaControlRecibo AS NumFacturaControlReciboE,
                            ife.OrdenCompra AS OrdenCompraE,
                            ife.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoE,
                            ifs.Cantidad AS CantidadS,    
                            ifs.UnidadMedidaComercializacion AS UnidadMedidaComercializacionS,
                            ifs.MontoDolares AS MontoDolaresS,
                            ifs.FechaRecibo As FechaReciboS,
                            ifs.NumFacturaControlRecibo AS NumFacturaControlReciboS,
                            ifs.OrdenCompra AS OrdenCompraS,
                            ifs.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoS,
                            ct.*,
                            p.*,
                            m.NumParte AS MaterialNumParte,
                            m.DescripcionMaterial,
                            m.FraccionArancelaria AS MaterialFraccionArancelaria,
                            m.UnidadMedidaComercializacion AS MaterialUnidadMedidaComercializacion,
                            m.UnidadMedidaTIGIE AS MaterialUnidadMedidaTIGIE,
                            m.TipoMaterial
                        FROM 
                            interfasemovimientos im
                        LEFT JOIN 
                            interfaseentradas ife ON im.InterfaseEntradaID = ife.InterfaseEntradaID
                        LEFT JOIN 
                            interfasesalidas ifs ON im.InterfaseSalidaID = ifs.InterfaseSalidaID
                        LEFT JOIN 
                            materiales m ON im.MaterialID = m.MaterialID
                        LEFT JOIN 
                            productos p ON im.ProductoID = p.ProductoID
                        LEFT JOIN 
                            contribuyente ct ON im.ContribuyenteID = ct.ContribuyenteID";


$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Reporte-de-Descargos");

$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'Consolidado de Movimientos');
$hojaActiva->setCellValue('C1', 'Consumo real');
$hojaActiva->setCellValue('D1', 'Faltantes');
$hojaActiva->setCellValue('E1', 'Sobrantes');
$hojaActiva->setCellValue('F1', 'Mermas');
$hojaActiva->setCellValue('G1', 'Descripción del Mercancia');
$hojaActiva->setCellValue('H1', 'Unidad de medida');
$hojaActiva->setCellValue('I1', 'Cantidad de Mercancia');
$hojaActiva->setCellValue('J1', 'Valor unitario en dolares');
$hojaActiva->setCellValue('K1', 'Monto Total en Dolares');
$hojaActiva->setCellValue('L1', 'Fecha de Recuperacion');
$hojaActiva->setCellValue('M1', 'Identificador del Sistema');
$hojaActiva->setCellValue('N1', 'Número o clave de identificación (Material)');
$hojaActiva->setCellValue('O1', 'Descripción del material');
$hojaActiva->setCellValue('P1', 'Fracción arancelaria');
$hojaActiva->setCellValue('Q1', 'Unidad de medida de comercialización');
$hojaActiva->setCellValue('R1', 'Unidad de medida de la TIGIE');
$hojaActiva->setCellValue('S1', 'Tipo de material');
$hojaActiva->setCellValue('T1', 'Número o clave de identificación (producto)');
$hojaActiva->setCellValue('U1', 'Descripción del producto');
$hojaActiva->setCellValue('V1', 'Fracción arancelaria');
$hojaActiva->setCellValue('W1', 'Unidad de medida de comercialización');
$hojaActiva->setCellValue('X1', 'Unidad de Medida TIGIE');
$hojaActiva->setCellValue('Y1', 'Cantidad Entrada');
$hojaActiva->setCellValue('Z1', 'Unidad de Medida de Comercialización');
$hojaActiva->setCellValue('AA1', 'Monto en Dolares');
$hojaActiva->setCellValue('AB1', 'Fecha de Recibo');
$hojaActiva->setCellValue('AC1', 'Numero de Factura Control');
$hojaActiva->setCellValue('AD1', 'Orden de Compra');
$hojaActiva->setCellValue('AE1', 'Identificador del SistemaCorporativo');
$hojaActiva->setCellValue('AF1', 'Cantidad Salida');
$hojaActiva->setCellValue('AG1', 'Unidad de Medida de Comercialización');
$hojaActiva->setCellValue('AH1', 'Monto en Dolares');
$hojaActiva->setCellValue('AI1', 'Fecha de Recibo');
$hojaActiva->setCellValue('AJ1', 'Numero de Factura Control');
$hojaActiva->setCellValue('AK1', 'Orden de Compra');
$hojaActiva->setCellValue('AL1', 'Identificador del SistemaCorporativo');
$hojaActiva->setCellValue('AM1', 'Denominación o Razón Social Contribuyente');
$hojaActiva->setCellValue('AN1', 'Clave RFC');
$hojaActiva->setCellValue('AO1', 'Número de Programa IMMEX');
$hojaActiva->setCellValue('AP1', 'Tipo de Domicilio');
$hojaActiva->setCellValue('AQ1', 'Calle');
$hojaActiva->setCellValue('AR1', 'Numero');
$hojaActiva->setCellValue('AS1', 'Codigo Postal');
$hojaActiva->setCellValue('AT1', 'Colonia');
$hojaActiva->setCellValue('AU1', 'Entidad Federativa');



// Puedes continuar agregando más columnas según tus necesidades

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->setCellValue('B' . $fila, $rows['ConsolidadoMovimientos']);
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C' . $fila, $rows['ConsumoReal']);
    $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D' . $fila, $rows['Faltantes']);
    $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E' . $fila, $rows['Sobrantes']);
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F' . $fila, $rows['Mermas']);
    $hojaActiva->getColumnDimension('G')->setWidth(100);
    $hojaActiva->setCellValue('G' . $fila, $rows['Mermas']);
    $hojaActiva->getColumnDimension('H')->setWidth(20);
    $hojaActiva->setCellValue('H' . $fila, $rows['UnidadMedida']);
    $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I' . $fila, $rows['CantidadMercancia']);
    $hojaActiva->getColumnDimension('J')->setWidth(20);
    $hojaActiva->setCellValue('J' . $fila, $rows['ValorUnitarioDolares']);
    $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K' . $fila, $rows['MontoTotalDolares']);
    $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L' . $fila, $rows['FechaRecuperacion']);
    $hojaActiva->getColumnDimension('M')->setWidth(20);
    $hojaActiva->setCellValue('M' . $fila, $rows['IdentificadorSistemaCorporativoMovi']);
    $hojaActiva->getColumnDimension('N')->setWidth(20);
    $hojaActiva->setCellValue('N' . $fila, $rows['MaterialNumParte']);
    $hojaActiva->getColumnDimension('O')->setWidth(20);
    $hojaActiva->setCellValue('O' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->getColumnDimension('P')->setWidth(20);
    $hojaActiva->setCellValue('P' . $fila, $rows['MaterialFraccionArancelaria']);
    $hojaActiva->getColumnDimension('Q')->setWidth(30);
    $hojaActiva->setCellValue('Q' . $fila, $rows['MaterialUnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('R')->setWidth(20);
    $hojaActiva->setCellValue('R' . $fila, $rows['MaterialUnidadMedidaTIGIE']);
    $hojaActiva->getColumnDimension('S')->setWidth(20);
    $hojaActiva->setCellValue('S' . $fila, $rows['TipoMaterial']);
    $hojaActiva->getColumnDimension('T')->setWidth(20);
    $hojaActiva->setCellValue('T' . $fila, $rows['NumParte']);
    $hojaActiva->getColumnDimension('U')->setWidth(20);
    $hojaActiva->setCellValue('U' . $fila, $rows['DescripcionProducto']);
    $hojaActiva->getColumnDimension('V')->setWidth(20);
    $hojaActiva->setCellValue('V' . $fila, $rows['FraccionArancelaria']);
    $hojaActiva->getColumnDimension('W')->setWidth(20);
    $hojaActiva->setCellValue('W' . $fila, $rows['UnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('X')->setWidth(20);
    $hojaActiva->setCellValue('X' . $fila, $rows['UnidadMedidaTIGIE']);
    $hojaActiva->getColumnDimension('Y')->setWidth(20);
    $hojaActiva->setCellValue('Y' . $fila, $rows['CantidadE']);
    $hojaActiva->getColumnDimension('Z')->setWidth(20);
    $hojaActiva->setCellValue('Z' . $fila, $rows['UnidadMedidaComercializacionE']);
    $hojaActiva->getColumnDimension('AA')->setWidth(20);
    $hojaActiva->setCellValue('AA' . $fila, $rows['MontoDolaresE']);
    $hojaActiva->getColumnDimension('AB')->setWidth(20);
    $hojaActiva->setCellValue('AB' . $fila, $rows['FechaReciboEntrada']);
    $hojaActiva->getColumnDimension('AC')->setWidth(20);
    $hojaActiva->setCellValue('AC' . $fila, $rows['NumFacturaControlReciboE']);
    $hojaActiva->getColumnDimension('AD')->setWidth(20);
    $hojaActiva->setCellValue('AD' . $fila, $rows['OrdenCompraE']);
    $hojaActiva->getColumnDimension('AE')->setWidth(20);
    $hojaActiva->setCellValue('AE' . $fila, $rows['IdentificadorSistemaCorporativoE']);
    $hojaActiva->getColumnDimension('AF')->setWidth(20);
    $hojaActiva->setCellValue('AF' . $fila, $rows['CantidadS']);
    $hojaActiva->getColumnDimension('AG')->setWidth(20);
    $hojaActiva->setCellValue('AG' . $fila, $rows['UnidadMedidaComercializacionS']);
    $hojaActiva->getColumnDimension('AH')->setWidth(20);
    $hojaActiva->setCellValue('AH' . $fila, $rows['MontoDolaresS']);
    $hojaActiva->getColumnDimension('AI')->setWidth(20);
    $hojaActiva->setCellValue('AI' . $fila, $rows['FechaReciboS']);
    $hojaActiva->getColumnDimension('AJ')->setWidth(20);
    $hojaActiva->setCellValue('AJ' . $fila, $rows['NumFacturaControlReciboS']);
    $hojaActiva->getColumnDimension('AK')->setWidth(20);
    $hojaActiva->setCellValue('AK' . $fila, $rows['OrdenCompraS']);
    $hojaActiva->getColumnDimension('AL')->setWidth(20);
    $hojaActiva->setCellValue('AL' . $fila, $rows['IdentificadorSistemaCorporativoS']);
    $hojaActiva->getColumnDimension('AM')->setWidth(20);
    $hojaActiva->setCellValue('AM' . $fila, $rows['DenominacionRazonSocial']);
    $hojaActiva->getColumnDimension('AN')->setWidth(20);
    $hojaActiva->setCellValue('AN' . $fila, $rows['ClaveRFC']);
    $hojaActiva->getColumnDimension('AO')->setWidth(20);
    $hojaActiva->setCellValue('AO' . $fila, $rows['NumProgramaIMMEX']);
    $hojaActiva->getColumnDimension('AP')->setWidth(20);
    $hojaActiva->setCellValue('AP' . $fila, $rows['TipoDomicilio']);
    $hojaActiva->getColumnDimension('AQ')->setWidth(20);
    $hojaActiva->setCellValue('AQ' . $fila, $rows['CallePlanta']);
    $hojaActiva->getColumnDimension('AR')->setWidth(20);
    $hojaActiva->setCellValue('AR' . $fila, $rows['NumeroPlanta']);
    $hojaActiva->getColumnDimension('AS')->setWidth(20);
    $hojaActiva->setCellValue('AS' . $fila, $rows['CodigoPostal']);
    $hojaActiva->getColumnDimension('AT')->setWidth(20);
    $hojaActiva->setCellValue('AT' . $fila, $rows['ColoniaPlanta']);
    $hojaActiva->getColumnDimension('AU')->setWidth(20);
    $hojaActiva->setCellValue('AU' . $fila, $rows['EntidadFederativa']);


    // Continúa con el resto de las columnas según tus necesidades
    $fila++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte-de-Descargos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
