<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex = "SELECT 
            'Interfaseentradas' AS Tabla,
                ie.*,
                m.*,
                p.*,
                c.DenominacionRazonSocial AS Contribuyente,
                cl.NombreRazonSocial AS Cliente,
                pv.NombreRazonSocial AS Proveedor
            FROM 
                interfaseentradas AS ie
            LEFT JOIN 
                materiales AS m ON ie.MaterialID = m.MaterialID
            LEFT JOIN 
                productos AS p ON ie.ProductoID = p.ProductoID
            LEFT JOIN 
                contribuyente AS c ON ie.ContribuyenteID = c.ContribuyenteID
            LEFT JOIN 
                clientes AS cl ON ie.ClienteID = cl.ClienteID
            LEFT JOIN 
                proveedores AS pv ON ie.ProveedorID = pv.ProveedorID";

$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Informe-Interfas-entradas");

$hojaActiva->setCellValue('A1', 'Material');
$hojaActiva->setCellValue('B1', 'Producto');
$hojaActiva->setCellValue('C1', 'Cantidad');
$hojaActiva->setCellValue('D1', 'Unidad Medida');
$hojaActiva->setCellValue('E1', 'Monto Dolares');
$hojaActiva->setCellValue('F1', 'Fecha Recibo');
$hojaActiva->setCellValue('G1', 'Proveedor');
$hojaActiva->setCellValue('H1', 'Contribuyente');
$hojaActiva->setCellValue('I1', 'Cliente ID');
$hojaActiva->setCellValue('J1', 'Número Factura');
$hojaActiva->setCellValue('K1', 'Orden Compra');
$hojaActiva->setCellValue('L1', 'Identificador de Sistema');

$fila = 2;

while($rows = $resultado->fetch_assoc()){
        $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A'.$fila, $rows['DescripcionMaterial']);
        $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->setCellValue('B'.$fila, $rows['DescripcionProducto']);
        $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C'.$fila, $rows['Cantidad']);
        $hojaActiva->getColumnDimension('D')->setWidth(15);
    $hojaActiva->setCellValue('D'.$fila, $rows['UnidadMedidaComercializacion']);
        $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E'.$fila, $rows['MontoDolares']);
        $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue('F'.$fila, $rows['FechaRecibo']);
        $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G'.$fila, $rows['Proveedor']);
        $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue('H'.$fila, $rows['Contribuyente']); 
        $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I'.$fila, $rows['Cliente']);
        $hojaActiva->getColumnDimension('J')->setWidth(15);
    $hojaActiva->setCellValue('J'.$fila, $rows['NumFacturaControlRecibo']);
        $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K'.$fila, $rows['OrdenCompra']);
        $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L'.$fila, $rows['IdentificadorSistemaCorporativo']);
    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Informe-Interfas-entrada.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
