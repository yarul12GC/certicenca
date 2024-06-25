<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex = "SELECT 
                            'aduanaSalidas' AS Tabla,
                            asal.*,
                            aent.*,
                            ct.*,
                            pro.*,
                            pro.NombreRazonSocial AS NombreRazonSocialProb,
                            pro.NumProgramaIMMEX AS NumProgramaIMMEXProb,
                            pro.RecintoFiscalizado AS RecintoFiscalizadoProb,
                            pro.Nacionalidad AS NacionalidadProb,
                            pro.NombreRazonSocial AS NombreProveedorb,
                            pro.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalProb,
                            pro.Calle AS CalleProb,
                            pro.Numero AS NumeroProb,
                            pro.CodigoPostal AS CodigoPostalProb,
                            pro.Colonia AS ColoniaProb,
                            pro.EntidadFederativa AS EntidadFederativaProb,
                            pro.Pais AS PaisProb,
                            m.NumParte AS MaterialNumParte,
                            m.DescripcionMaterial,
                            m.FraccionArancelaria AS MaterialFraccionArancelaria,
                            m.UnidadMedidaComercializacion AS MaterialUnidadMedidaComercializacion,
                            m.UnidadMedidaTIGIE AS MaterialUnidadMedidaTIGIE,
                            m.TipoMaterial,
                            sm.NumClaveIdentificacion AS NumClaveIdentificacionSub,
                            sm.NombreRazonSocial AS NombreRazonSocialSub,
                            sm.NumAutorizacionSE AS NumAutorizacionSESub,
                            sm.FechaAutorizacion AS FechaAutorizacionSub,
                            sm.Calle AS CalleSub,
                            sm.Numero AS NumeroSub,
                            sm.CodigoPostal AS CodigoPostalSub,
                            sm.Colonia AS ColoniaSub,
                            sm.EntidadFederativa AS EntidadFederativaSub,
                            sm.Pais AS PaisSub
                        FROM 
                            aduanaealidas asal
                        LEFT JOIN 
                            aduanaentradas aent ON asal.AduanaEntradaID = aent.AduanaEntradaID
                        LEFT JOIN 
                            materiales m ON asal.MaterialID = m.MaterialID
                        LEFT JOIN 
                            proveedores pro ON asal.ProveedorID = pro.ProveedorID
                        LEFT JOIN 
                            contribuyente ct ON asal.ContribuyenteID = ct.ContribuyenteID
                        LEFT JOIN 
                            submanufactura sm ON asal.SubmanufacturaID = sm.SubmanufacturaID";

$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Informe-Aduana-Salidas");

$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'NumeroPedimento');
$hojaActiva->setCellValue('C1', 'ClaveAduana');
$hojaActiva->setCellValue('D1', 'Contribuyente');
$hojaActiva->setCellValue('E1', 'Proveedor');
$hojaActiva->setCellValue('F1', 'Material');
$hojaActiva->setCellValue('G1', 'Descripción Material');
$hojaActiva->setCellValue('H1', 'Fracción Arancelaria');
$hojaActiva->setCellValue('I1', 'Unidad de Medida (Comercialización)');
$hojaActiva->setCellValue('J1', 'Unidad de Medida (TIGIE)');
$hojaActiva->setCellValue('K1', 'Tipo de Material');
$hojaActiva->setCellValue('L1', 'Submanufactura');

// Puedes continuar agregando más columnas según tus necesidades

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->getColumnDimension('B')->setWidth(15);
    $hojaActiva->setCellValue('B' . $fila, $rows['NumeroPedimento']);
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C' . $fila, $rows['ClaveAduana']);
    $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D' . $fila, $rows['NombreRazonSocial']);
    $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E' . $fila, $rows['NombreProveedorb']);
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F' . $fila, $rows['MaterialNumParte']);
    $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->getColumnDimension('H')->setWidth(20);
    $hojaActiva->setCellValue('H' . $fila, $rows['MaterialFraccionArancelaria']);
    $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I' . $fila, $rows['MaterialUnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('J')->setWidth(20);
    $hojaActiva->setCellValue('J' . $fila, $rows['MaterialUnidadMedidaTIGIE']);
    $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K' . $fila, $rows['TipoMaterial']);
    $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L' . $fila, $rows['NumClaveIdentificacionSub']);


    // Continúa con el resto de las columnas según tus necesidades
    $fila++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Informe-Aduana-Salida.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
