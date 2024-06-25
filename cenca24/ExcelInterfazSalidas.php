<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex = "SELECT 
                        'interfasesalidas' AS Tabla,
                        ie.*,
                        c.NumClaveIdentificacion AS clienteSalida,
                        c.NombreRazonSocial AS NombreRazonSocialSalida,
                        c.Nacionalidad AS NacionalidadSalida,
                        c.NumProgramaIMMEX AS NumProgramaIMMEXSalida,
                        c.NumClaveIdentificacion AS ECEXSalida,
                        c.EmpresaIndustrial AS EmpresaIndustrialSalida,
                        c.RecintoFiscalizado AS RecintoFiscalizadoSalida,
                        c.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalSalida,
                        c.Calle AS CalleSalida,
                        c.Numero AS NumeroSalida,
                        pd.*,
                        m.NumParte AS Material_NumParte,
                        m.DescripcionMaterial,
                        m.FraccionArancelaria AS Material_FraccionArancelaria,
                        m.UnidadMedidaComercializacion AS Material_UnidadMedidaComercializacion,
                        m.UnidadMedidaTIGIE AS Material_UnidadMedidaTIGIE,
                        m.TipoMaterial,
                        ct.*,
                        pr.*,
                        pr.NumProgramaIMMEX AS NumProgramaIMMEXPro,
                        pr.RecintoFiscalizado AS RecintoFiscalizadoPro,
                        pr.Nacionalidad AS NacionalidadPro,
                        pr.NombreRazonSocial AS NombreProveedor,
                        pr.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalPro,
                        pr.Calle AS CallePro,
                        pr.Numero AS NumeroPro,
                        pr.CodigoPostal AS CodigoPostalPro,
                        pr.Colonia AS ColoniaPro,
                        pr.EntidadFederativa AS EntidadFederativaPro,
                        pr.Pais AS PaisPro
                    FROM 
                        interfasesalidas ie
                    LEFT JOIN 
                        interfaseentradas ae ON ie.InterfaseEntradaID = ae.InterfaseEntradaID
                    LEFT JOIN 
                        clientes c ON ie.ClienteID = c.ClienteID
                    LEFT JOIN 
                        materiales m ON ie.MaterialID = m.MaterialID
                
                    LEFT JOIN 
                        contribuyente ct ON ie.ContribuyenteID = ct.ContribuyenteID
                    LEFT JOIN 
                        proveedores pr ON ie.ProveedorID = pr.ProveedorID
                    LEFT JOIN
                        productos pd ON ie.ProductoID = pd.ProductoID";

$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Informe-Interfas-salidas");

$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'Cliente ID');
$hojaActiva->setCellValue('C1', 'Nombre Razón Social Salida');
$hojaActiva->setCellValue('D1', 'Nacionalidad Salida');
$hojaActiva->setCellValue('E1', 'Num Programa IMMEX Salida');
$hojaActiva->setCellValue('F1', 'ECEX Salida');
$hojaActiva->setCellValue('G1', 'Empresa Industrial Salida');
$hojaActiva->setCellValue('H1', 'Recinto Fiscalizado Salida');
$hojaActiva->setCellValue('I1', 'Clave Identificacion Fiscal Salida');
$hojaActiva->setCellValue('J1', 'Calle Salida');
$hojaActiva->setCellValue('K1', 'Numero Salida');
// Continuar con las demás columnas según sea necesario

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {

    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->setCellValue('B' . $fila, $rows['ClienteID']);
    $hojaActiva->setCellValue('C' . $fila, $rows['NombreRazonSocialSalida']);
    $hojaActiva->setCellValue('D' . $fila, $rows['NacionalidadSalida']);
    $hojaActiva->setCellValue('E' . $fila, $rows['NumProgramaIMMEXSalida']);
    $hojaActiva->setCellValue('F' . $fila, $rows['ECEXSalida']);
    $hojaActiva->setCellValue('G' . $fila, $rows['EmpresaIndustrialSalida']);
    $hojaActiva->setCellValue('H' . $fila, $rows['RecintoFiscalizadoSalida']);
    $hojaActiva->setCellValue('I' . $fila, $rows['ClaveIdentificacionFiscalSalida']);
    $hojaActiva->setCellValue('J' . $fila, $rows['CalleSalida']);
    $hojaActiva->setCellValue('K' . $fila, $rows['NumeroSalida']);


    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Informe-Interfas-salida.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
