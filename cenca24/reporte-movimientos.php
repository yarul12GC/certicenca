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
$hojaActiva->setTitle("saldo-materiales");

$hojaActiva->setCellValue('A1', 'Material');
$hojaActiva->setCellValue('B1', 'UnidadMedida');
$hojaActiva->setCellValue('C1', 'Cantidad de Entrada');
$hojaActiva->setCellValue('D1', 'Cantidad de Salida');
$hojaActiva->setCellValue('E1', 'Faltantes');
$hojaActiva->setCellValue('F1', 'Sobrantes');
$hojaActiva->setCellValue('G1', 'Mermas');
$hojaActiva->setCellValue('H1', 'Consumo Total');
$hojaActiva->setCellValue('I1', 'Saldo Actual');


$fila = 2;

while($rows = $resultado->fetch_assoc()){
        $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A'.$fila, $rows['DescripcionMaterial']);
        $hojaActiva->getColumnDimension('B')->setWidth(20);
    $hojaActiva->setCellValue('B'.$fila, $rows['UnidadMedida']);
        $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C'.$fila, $rows['CantidadEntrada']);
        $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D'.$fila, $rows['CantidadSalida']);
        $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E'.$fila, $rows['Faltantes']);
        $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue('F'.$fila, $rows['Sobrantes']);
        $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G'.$fila, $rows['Mermas']);
        $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue('H'.$fila, $rows['ConsumoReal']); 
        $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I'.$fila, $rows['Sobrantes']);
    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="saldo-materiales.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
