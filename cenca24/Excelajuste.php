<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_movimieex = "SELECT
        m.DescripcionMaterial,
        m.FraccionArancelaria,
        ie.Cantidad AS CantidadEntrada,
        isal.Cantidad AS CantidadSalida,
        im.Faltantes,
        im.Mermas,
        im.ConsumoReal,
        CASE
            WHEN im.Faltantes > 0 THEN 'Ajuste por Faltantes'
            WHEN im.Mermas > 0 THEN 'Ajuste por Mermas'
            ELSE 'Sin ajuste'
        END AS TipoAjuste
        FROM
        interfasemovimientos im
        LEFT JOIN
        materiales m ON im.MaterialID = m.MaterialID
        LEFT JOIN
        interfaseentradas ie ON im.InterfaseEntradaID = ie.InterfaseEntradaID
        LEFT JOIN
        interfasesalidas isal ON im.InterfaseSalidaID = isal.InterfaseSalidaID
        GROUP BY
        m.MaterialID;";

$resultado = $conn->query($sql_movimieex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Reporte-ajustes");

$hojaActiva->setCellValue('A1', 'TipoAjuste');
$hojaActiva->setCellValue('B1', 'Nombre del Material');
$hojaActiva->setCellValue('C1', 'Fraccion Arancelaria');
$hojaActiva->setCellValue('D1', 'Cantidad de Entrada');
$hojaActiva->setCellValue('E1', 'Cantidad de Salida');
$hojaActiva->setCellValue('F1', 'Faltantes');
$hojaActiva->setCellValue('G1', 'Mermas');
$hojaActiva->setCellValue('H1', 'Consumo Total con Ajuste');


$fila = 2;

while($rows = $resultado->fetch_assoc()){
        $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A'.$fila, $rows['TipoAjuste']);
        $hojaActiva->getColumnDimension('B')->setWidth(20);
    $hojaActiva->setCellValue('B'.$fila, $rows['DescripcionMaterial']);
        $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C'.$fila, $rows['FraccionArancelaria']);
        $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D'.$fila, $rows['CantidadEntrada']);
        $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E'.$fila, $rows['CantidadSalida']);
        $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue('F'.$fila, $rows['Faltantes']);
        $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G'.$fila, $rows['Mermas']);
        $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue('H'.$fila, $rows['ConsumoReal']); 
        
    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte-ajustes.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
