<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_movimieex = "SELECT 
        'interfasemovimientos' AS Tabla,
        im.*,
        ie.Cantidad AS CantidadEntrada,
        isal.Cantidad AS CantidadSalida,
        mat.*,
        prod.*,
        cont.DenominacionRazonSocial AS nombrecontribuyente
        FROM 
        interfasemovimientos AS im
        LEFT JOIN 
        interfaseentradas AS ie ON im.InterfaseEntradaID = ie.InterfaseEntradaID
        LEFT JOIN 
        interfasesalidas AS isal ON im.InterfaseSalidaID = isal.InterfaseSalidaID
        LEFT JOIN 
        materiales AS mat ON im.MaterialID = mat.MaterialID
        LEFT JOIN 
        productos AS prod ON im.ProductoID = prod.ProductoID
        LEFT JOIN 
        contribuyente AS cont ON im.ContribuyenteID = cont.ContribuyenteID";

$resultado = $conn->query($sql_movimieex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("proceso-Movimientos");

$hojaActiva->setCellValue('A1', 'Consolidado');
$hojaActiva->setCellValue('B1', 'Material');
$hojaActiva->setCellValue('C1', 'Producto');
$hojaActiva->setCellValue('D1', 'Cantidad Entrada');
$hojaActiva->setCellValue('E1', 'Cantidad Salida');
$hojaActiva->setCellValue('F1', 'Descripcion');
$hojaActiva->setCellValue('G1', 'UnidadMedida');
$hojaActiva->setCellValue('H1', 'Faltantes');
$hojaActiva->setCellValue('I1', 'Sobrantes');
$hojaActiva->setCellValue('J1', 'Mermas');
$hojaActiva->setCellValue('K1', 'ConsumoReal');
$hojaActiva->setCellValue('L1', 'Valor Unitario $');
$hojaActiva->setCellValue('M1', 'Monto Total $');
$hojaActiva->setCellValue('N1', 'FechaRecuperacion');
$hojaActiva->setCellValue('O1', 'Identificador');
$hojaActiva->setCellValue('P1', 'contribuyente');

$fila = 2;

while($rows = $resultado->fetch_assoc()){
        $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A'.$fila, $rows['ConsolidadoMovimientos']);
        $hojaActiva->getColumnDimension('B')->setWidth(20);
    $hojaActiva->setCellValue('B'.$fila, $rows['DescripcionMaterial']);
        $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C'.$fila, $rows['DescripcionProducto']);
        $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D'.$fila, $rows['CantidadEntrada']);
        $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E'.$fila, $rows['CantidadSalida']);
        $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue('F'.$fila, $rows['DescripcionMercancia']);
        $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G'.$fila, $rows['UnidadMedida']);
        $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue('H'.$fila, $rows['Faltantes']); 
        $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I'.$fila, $rows['Sobrantes']);
        $hojaActiva->getColumnDimension('J')->setWidth(15);
    $hojaActiva->setCellValue('J'.$fila, $rows['Mermas']);
        $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K'.$fila, $rows['ConsumoReal']);
        $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L'.$fila, $rows['ValorUnitarioDolares']);
        $hojaActiva->getColumnDimension('M')->setWidth(20);
    $hojaActiva->setCellValue('M'.$fila, $rows['MontoTotalDolares']);
        $hojaActiva->getColumnDimension('N')->setWidth(20);
    $hojaActiva->setCellValue('N'.$fila, $rows['FechaRecuperacion']);
        $hojaActiva->getColumnDimension('O')->setWidth(20);
    $hojaActiva->setCellValue('O'.$fila, $rows['IdentificadorSistemaCorporativo']);
        $hojaActiva->getColumnDimension('P')->setWidth(20);
    $hojaActiva->setCellValue('P'.$fila, $rows['nombrecontribuyente']);
    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="proceso-Movimientos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
