<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex = "SELECT 
        m.DescripcionMaterial,
        m.FraccionArancelaria,
        m.UnidadMedidaComercializacion,
        IFNULL(SUM(ae.CantidadEntradaAduana), 0) AS TotalEntradas,
        IFNULL(SUM(asal.CantidadSalidaAd), 0) AS TotalSalidas,
        IFNULL(SUM(ae.CantidadEntradaAduana), 0) - IFNULL(SUM(asal.CantidadSalidaAd), 0) AS ConsumoTotal,
        IFNULL(SUM(asal.CantidadSalidaAd), 0) AS Sobrantes,
        IFNULL(SUM(ae.CantidadEntradaAduana), 0) - IFNULL(SUM(asal.CantidadSalidaAd), 0) AS SaldoMercancia
        FROM 
        materiales m
        LEFT JOIN 
        aduanaentradas ae ON m.MaterialID = ae.MaterialID
        LEFT JOIN 
        aduanasalidas asal ON m.MaterialID = asal.MaterialID
        GROUP BY 
        m.MaterialID, m.DescripcionMaterial, m.FraccionArancelaria, m.UnidadMedidaComercializacion;";


$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("saldo-de-Msaldo-de-M");

$hojaActiva->setCellValue('A1', 'DescripcionMaterial');
$hojaActiva->setCellValue('B1', 'FraccionArancelaria');
$hojaActiva->setCellValue('C1', 'Unidad de Medida');
$hojaActiva->setCellValue('D1', 'TotalEntradas');
$hojaActiva->setCellValue('E1', 'TotalSalidas');
$hojaActiva->setCellValue('F1', 'ConsumoTotal');
$hojaActiva->setCellValue('G1', 'Sobrantes');

// Puedes continuar agregando más columnas según tus necesidades

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->setCellValue('B' . $fila, $rows['FraccionArancelaria']);
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C' . $fila, $rows['UnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D' . $fila, $rows['TotalEntradas']);
    $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E' . $fila, $rows['TotalSalidas']);
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F' . $fila, $rows['ConsumoTotal']);
    $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G' . $fila, $rows['Sobrantes']);
    
    // Continúa con el resto de las columnas según tus necesidades
    $fila++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="saldo-de-M.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
