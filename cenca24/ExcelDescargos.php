<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex = "SELECT 
                           'interfasemovimientos' AS Tabla,
                            im.*,
                            im.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoMovi,
                            ife.*,
                            ifs.*,
                            ifs.Cantidad AS CantidadSalidad,
                            ife.FechaRecibo As FechaReciboEntrada,
                            ife.Cantidad AS CantidadEntrada,
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
$hojaActiva->setTitle("Preceso-de-Descargos");

$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'Material');
$hojaActiva->setCellValue('C1', 'Producto');
$hojaActiva->setCellValue('D1', 'Cantidad de entrada');
$hojaActiva->setCellValue('E1', 'Cantidad de Salida');
$hojaActiva->setCellValue('F1', 'Consumo real');
$hojaActiva->setCellValue('G1', 'Faltantes');
$hojaActiva->setCellValue('H1', 'Sobrantes');
$hojaActiva->setCellValue('I1', 'Mermas');
$hojaActiva->setCellValue('J1', 'Descripción del Mercancia');
$hojaActiva->setCellValue('K1', 'Unidad de medida:');
$hojaActiva->setCellValue('L1', 'Cantidad de Mercancia');
$hojaActiva->setCellValue('M1', 'Valor unitario en dolares');
$hojaActiva->setCellValue('N1', 'Monto Total en Dolares');
$hojaActiva->setCellValue('O1', 'Fecha de Recuperacion');
$hojaActiva->setCellValue('P1', 'Identificador del Sistema');
$hojaActiva->setCellValue('Q1', 'Contribuyente');
$hojaActiva->setCellValue('R1', 'RFC del Contribuyente');

// Puedes continuar agregando más columnas según tus necesidades

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->setCellValue('B' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C' . $fila, $rows['DescripcionProducto']);
    $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D' . $fila, $rows['CantidadEntrada']);
    $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E' . $fila, $rows['CantidadSalidad']);
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F' . $fila, $rows['ConsumoReal']);
    $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G' . $fila, $rows['Faltantes']);
    $hojaActiva->getColumnDimension('H')->setWidth(20);
    $hojaActiva->setCellValue('H' . $fila, $rows['Sobrantes']);
    $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I' . $fila, $rows['Mermas']);
    $hojaActiva->getColumnDimension('J')->setWidth(100);
    $hojaActiva->setCellValue('J' . $fila, $rows['DescripcionMercancia']);
    $hojaActiva->getColumnDimension('K')->setWidth(10);
    $hojaActiva->setCellValue('K' . $fila, $rows['UnidadMedida']);
    $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L' . $fila, $rows['CantidadMercancia']);
    $hojaActiva->getColumnDimension('M')->setWidth(50);
    $hojaActiva->setCellValue('M' . $fila, $rows['ValorUnitarioDolares']);
    $hojaActiva->getColumnDimension('N')->setWidth(50);
    $hojaActiva->setCellValue('N' . $fila, $rows['MontoTotalDolares']);
    $hojaActiva->getColumnDimension('O')->setWidth(20);
    $hojaActiva->setCellValue('O' . $fila, $rows['FechaRecuperacion']);
    $hojaActiva->getColumnDimension('P')->setWidth(20);
    $hojaActiva->setCellValue('P' . $fila, $rows['IdentificadorSistemaCorporativoMovi']);
    $hojaActiva->getColumnDimension('Q')->setWidth(30);
    $hojaActiva->setCellValue('Q' . $fila, $rows['DenominacionRazonSocial']);
    $hojaActiva->getColumnDimension('R')->setWidth(20);
    $hojaActiva->setCellValue('R' . $fila, $rows['ClaveRFC']);


    // Continúa con el resto de las columnas según tus necesidades
    $fila++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Preceso-de-Descargos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
