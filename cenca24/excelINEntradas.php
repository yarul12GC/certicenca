<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql_interfaseex = "SELECT 
        'interfaseentradas' AS Tabla,
        ie.*,

        m.*,

        p.NumParte  AS NumParteP, 
        p.DescripcionProducto AS DescripcionProductoP,	
        p.FraccionArancelaria AS FraccionArancelariaP,	
        p.UnidadMedidaComercializacion AS UnidadMedidaComercializacionP,	
        p.UnidadMedidaTIGIE AS UnidadMedidaTIGIEP,

        c.DenominacionRazonSocial AS Contribuyente,
        c.ClaveRFC AS ClaveRFCc,
        c.NumProgramaIMMEX AS NumProgramaIMMEXC,	
        c.TipoDomicilio AS TipoDomicilioC,	
        c.CallePlanta AS CallePlantaC,	
        c.NumeroPlanta AS NumeroPlantaC,	
        c.CodigoPostal AS CodigoPostalC,	
        c.ColoniaPlanta AS ColoniaPlantaC,	
        c.EntidadFederativa AS EntidadFederativaC,

        cl.NombreRazonSocial AS Cliente,
        cl.NumClaveIdentificacion AS NumClaveIdentificacionCL, 	
        cl.Nacionalidad AS NacionalidadCL,
        cl.NumProgramaIMMEX AS NumProgramaIMMEXCL,
        cl.ECEX AS ECEXCL,
        cl.EmpresaIndustrial AS EmpresaIndustrialCL,	
        cl.RecintoFiscalizado AS RecintoFiscalizadoCL,	
        cl.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalCL,	
        cl.Calle AS CalleCL,	
        cl.Numero AS NumeroCL,	
        cl.CodigoPostal AS CodigoPostalCL,
        cl.Colonia AS ColoniaCL,	
        cl.EntidadFederativa AS EntidadFederativaCL,	
        cl.Pais AS PaisCL,

        pv.NombreRazonSocial AS Proveedor,
        pv.NumClaveIdentificacionEmpresa AS NumClaveIdentificacionEmpresaPV,	
        pv.Nacionalidad AS NacionalidadPV,
        pv.NumProgramaIMMEX AS NumProgramaIMMEXPV,
        pv.RecintoFiscalizado AS RecintoFiscalizadoPV,
        pv.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalPV,
        pv.Calle AS CallePV,
        pv.Numero AS NumeroPV,
        pv.CodigoPostal AS CodigoPostalPV,
        pv.Colonia AS ColoniaPV,
        pv.EntidadFederativa AS EntidadFederativaPV,
        pv.Pais AS PaisPV 
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
$hojaActiva->setTitle("Informe-Interfas-salidas");





$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'Interfase Entrada ID');
$hojaActiva->setCellValue('C1', 'Material');
$hojaActiva->setCellValue('D1', 'Producto');
$hojaActiva->setCellValue('E1', 'Cantidad');
$hojaActiva->setCellValue('F1', 'Unidad Medida Comercializacion');
$hojaActiva->setCellValue('G1', 'Monto Dolares');
$hojaActiva->setCellValue('H1', 'Fecha Recibo');
$hojaActiva->setCellValue('I1', 'Proveedor');
$hojaActiva->setCellValue('J1', 'Cliente ID');
$hojaActiva->setCellValue('K1', 'Número Factura Control Recibo');
$hojaActiva->setCellValue('L1', 'Orden Compra');
$hojaActiva->setCellValue('M1', 'Identificador Sistema Corporativo');

$hojaActiva->setCellValue('N1', 'NumParte');
$hojaActiva->setCellValue('O1', 'DescripcionMaterial');
$hojaActiva->setCellValue('P1', 'FraccionArancelaria');
$hojaActiva->setCellValue('Q1', 'UnidadMedidaTIGIE');
$hojaActiva->setCellValue('R1', 'TipoMaterial');

$hojaActiva->setCellValue('S1', 'Contribuyente');
$hojaActiva->setCellValue('T1', 'ClaveRFCc');
$hojaActiva->setCellValue('U1', 'NumProgramaIMMEXC');
$hojaActiva->setCellValue('V1', 'TipoDomicilioC');
$hojaActiva->setCellValue('W1', 'CallePlantaC');
$hojaActiva->setCellValue('X1', 'NumeroPlantaC');
$hojaActiva->setCellValue('Y1', 'CodigoPostalC');
$hojaActiva->setCellValue('Z1', 'ColoniaPlantaC');
$hojaActiva->setCellValue('AA1', 'EntidadFederativaC');

$hojaActiva->setCellValue('AB1', 'Cliente');
$hojaActiva->setCellValue('AC1', 'NumClaveIdentificacionCL');
$hojaActiva->setCellValue('AD1', 'NacionalidadCL');
$hojaActiva->setCellValue('AE1', 'NumProgramaIMMEXCL');
$hojaActiva->setCellValue('AF1', 'ECEXCL');
$hojaActiva->setCellValue('AG1', 'EmpresaIndustrialCL');
$hojaActiva->setCellValue('AH1', 'RecintoFiscalizadoCL');
$hojaActiva->setCellValue('AI1', 'ClaveIdentificacionFiscalCL');
$hojaActiva->setCellValue('AJ1', 'CalleCL');
$hojaActiva->setCellValue('AK1', 'NumeroCL');
$hojaActiva->setCellValue('AL1', 'CodigoPostalCL');
$hojaActiva->setCellValue('AM1', 'ColoniaCL');
$hojaActiva->setCellValue('AN1', 'EntidadFederativaCL');
$hojaActiva->setCellValue('AO1', 'PaisCL');

$hojaActiva->setCellValue('AP1', 'Proveedor');
$hojaActiva->setCellValue('AQ1', 'NumClaveIdentificacionEmpresaPV');
$hojaActiva->setCellValue('AR1', 'NacionalidadPV');
$hojaActiva->setCellValue('AS1', 'NumProgramaIMMEXPV');
$hojaActiva->setCellValue('AT1', 'RecintoFiscalizadoPV');
$hojaActiva->setCellValue('AU1', 'ClaveIdentificacionFiscalPV');
$hojaActiva->setCellValue('AV1', 'CallePV');
$hojaActiva->setCellValue('AW1', 'NumeroPV');
$hojaActiva->setCellValue('AX1', 'CodigoPostalPV');
$hojaActiva->setCellValue('AY1', 'ColoniaPV');
$hojaActiva->setCellValue('AZ1', 'EntidadFederativaPV');
$hojaActiva->setCellValue('BA1', 'PaisPV');

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->setCellValue('B' . $fila, $rows['InterfaseEntradaID']);
    $hojaActiva->setCellValue('C' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->setCellValue('D' . $fila, $rows['DescripcionProductoP']);
    $hojaActiva->setCellValue('E' . $fila, $rows['Cantidad']);
    $hojaActiva->setCellValue('F' . $fila, $rows['UnidadMedidaComercializacion']);
    $hojaActiva->setCellValue('G' . $fila, $rows['MontoDolares']);
    $hojaActiva->setCellValue('H' . $fila, $rows['FechaRecibo']);
    $hojaActiva->setCellValue('I' . $fila, $rows['Proveedor']);
    $hojaActiva->setCellValue('J' . $fila, $rows['Cliente']);
    $hojaActiva->setCellValue('K' . $fila, $rows['NumFacturaControlRecibo']);
    $hojaActiva->setCellValue('L' . $fila, $rows['OrdenCompra']);
    $hojaActiva->setCellValue('M' . $fila, $rows['IdentificadorSistemaCorporativo']);
    $hojaActiva->setCellValue('N' . $fila, $rows['NumParte']);
    $hojaActiva->setCellValue('O' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->setCellValue('P' . $fila, $rows['FraccionArancelaria']);
    $hojaActiva->setCellValue('Q' . $fila, $rows['UnidadMedidaTIGIE']);
    $hojaActiva->setCellValue('R' . $fila, $rows['TipoMaterial']);
    $hojaActiva->setCellValue('S' . $fila, $rows['Contribuyente']);
    $hojaActiva->setCellValue('T' . $fila, $rows['ClaveRFCc']);
    $hojaActiva->setCellValue('U' . $fila, $rows['NumProgramaIMMEXC']);
    $hojaActiva->setCellValue('V' . $fila, $rows['TipoDomicilioC']);
    $hojaActiva->setCellValue('W' . $fila, $rows['CallePlantaC']);
    $hojaActiva->setCellValue('X' . $fila, $rows['NumeroPlantaC']);
    $hojaActiva->setCellValue('Y' . $fila, $rows['CodigoPostalC']);
    $hojaActiva->setCellValue('Z' . $fila, $rows['ColoniaPlantaC']);
    $hojaActiva->setCellValue('AA' . $fila, $rows['EntidadFederativaC']);
    $hojaActiva->setCellValue('AB' . $fila, $rows['Cliente']);
    $hojaActiva->setCellValue('AC' . $fila, $rows['NumClaveIdentificacionCL']);
    $hojaActiva->setCellValue('AD' . $fila, $rows['NacionalidadCL']);
    $hojaActiva->setCellValue('AE' . $fila, $rows['NumProgramaIMMEXCL']);
    $hojaActiva->setCellValue('AF' . $fila, $rows['ECEXCL']);
    $hojaActiva->setCellValue('AG' . $fila, $rows['EmpresaIndustrialCL']);
    $hojaActiva->setCellValue('AH' . $fila, $rows['RecintoFiscalizadoCL']);
    $hojaActiva->setCellValue('AI' . $fila, $rows['ClaveIdentificacionFiscalCL']);
    $hojaActiva->setCellValue('AJ' . $fila, $rows['CalleCL']);
    $hojaActiva->setCellValue('AK' . $fila, $rows['NumeroCL']);
    $hojaActiva->setCellValue('AL' . $fila, $rows['CodigoPostalCL']);
    $hojaActiva->setCellValue('AM' . $fila, $rows['ColoniaCL']);
    $hojaActiva->setCellValue('AN' . $fila, $rows['EntidadFederativaCL']);
    $hojaActiva->setCellValue('AO' . $fila, $rows['PaisCL']);
    $hojaActiva->setCellValue('AP' . $fila, $rows['Proveedor']);
    $hojaActiva->setCellValue('AQ' . $fila, $rows['NumClaveIdentificacionEmpresaPV']);
    $hojaActiva->setCellValue('AR' . $fila, $rows['NacionalidadPV']);
    $hojaActiva->setCellValue('AS' . $fila, $rows['NumProgramaIMMEXPV']);
    $hojaActiva->setCellValue('AT' . $fila, $rows['RecintoFiscalizadoPV']);
    $hojaActiva->setCellValue('AU' . $fila, $rows['ClaveIdentificacionFiscalPV']);
    $hojaActiva->setCellValue('AV' . $fila, $rows['CallePV']);
    $hojaActiva->setCellValue('AW' . $fila, $rows['NumeroPV']);
    $hojaActiva->setCellValue('AX' . $fila, $rows['CodigoPostalPV']);
    $hojaActiva->setCellValue('AY' . $fila, $rows['ColoniaPV']);
    $hojaActiva->setCellValue('AZ' . $fila, $rows['EntidadFederativaPV']);
    $hojaActiva->setCellValue('BA' . $fila, $rows['PaisPV']);

    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Informe-Interfas-entradas.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx');
$objWriter->save('php://output');

exit;
?>
