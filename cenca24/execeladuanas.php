<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfasadu = "SELECT
 
            'aduanaentradas' AS Tabla,
            ae.*,
            m.*,
            p.NombreRazonSocial AS nombreprovedor,
            sm.NombreRazonSocial AS razonSocial,
            c.DenominacionRazonSocial AS nombrecontribuyente,
            ag.*
        FROM 
            aduanaentradas ae
        LEFT JOIN 
            materiales m ON ae.MaterialID = m.MaterialID
        LEFT JOIN 
            proveedores p ON ae.ProveedorID = p.ProveedorID
        LEFT JOIN 
            submanufactura sm ON ae.SubmanufacturaID = sm.SubmanufacturaID
        LEFT JOIN 
            contribuyente c ON ae.ContribuyenteID = c.ContribuyenteID
        LEFT JOIN 
            agentesaduanales ag ON ae.AgenteAduanalID = ag.AgenteAduanalID;";

$resultado = $conn->query($sql_interfasadu);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Informe-Aduana-Entradas");

$hojaActiva->setCellValue('A1', 'Numero Pedimento');
$hojaActiva->setCellValue('B1', 'ClaveAduana');
$hojaActiva->setCellValue('C1', 'patente');
$hojaActiva->setCellValue('D1', 'Numero Doc');
$hojaActiva->setCellValue('E1', 'Clave Pedimento');
$hojaActiva->setCellValue('F1', 'Fecha Pedimento');
$hojaActiva->setCellValue('G1', 'Material');
$hojaActiva->setCellValue('H1', 'Proveedor');
$hojaActiva->setCellValue('I1', 'Origen Mercancia');
$hojaActiva->setCellValue('J1', 'Tipo Impuesto');
$hojaActiva->setCellValue('K1', 'Tasa De Impuesto');
$hojaActiva->setCellValue('L1', 'Factura Comercial');
$hojaActiva->setCellValue('M1', 'Aviso Electronico');
$hojaActiva->setCellValue('N1', 'FechaCruce');
$hojaActiva->setCellValue('O1', 'Submanufactura');
$hojaActiva->setCellValue('P1', 'AgenteAduanal');
$hojaActiva->setCellValue('Q1', 'Contribuyente');




$fila = 2;

while($rows = $resultado->fetch_assoc()){
        $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A'.$fila, $rows['NumeroPedimento']);
        $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->setCellValue('B'.$fila, $rows['ClaveAduana']);
        $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C'.$fila, $rows['patente']);
        $hojaActiva->getColumnDimension('D')->setWidth(15);
    $hojaActiva->setCellValue('D'.$fila, $rows['NumeroDoc']);
        $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E'.$fila, $rows['ClavePedimento']);
        $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue('F'.$fila, $rows['FechaPedimento']);
        $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G'.$fila, $rows['DescripcionMaterial']);
        $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue('H'.$fila, $rows['nombreprovedor']); 
        $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I'.$fila, $rows['PaisOrigenMercancia']);
        $hojaActiva->getColumnDimension('J')->setWidth(15);
    $hojaActiva->setCellValue('J'.$fila, $rows['tipoImpuesto']);
        $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K'.$fila, $rows['TasaDeImpuesto']);
        $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L'.$fila, $rows['FacturaComercial']);
        $hojaActiva->getColumnDimension('M')->setWidth(20);
    $hojaActiva->setCellValue('M'.$fila, $rows['AvisoElectronico']);
        $hojaActiva->getColumnDimension('N')->setWidth(20);
    $hojaActiva->setCellValue('N'.$fila, $rows['FechaCruce']);
        $hojaActiva->getColumnDimension('O')->setWidth(20);
    $hojaActiva->setCellValue('O'.$fila, $rows['razonSocial']);
        $hojaActiva->getColumnDimension('P')->setWidth(20);
    $hojaActiva->setCellValue('P'.$fila, $rows['NombreAgenteAduanal']);
        $hojaActiva->getColumnDimension('Q')->setWidth(20);
    $hojaActiva->setCellValue('Q'.$fila, $rows['nombrecontribuyente']);
    
    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Informe-Interfas-entrada.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
