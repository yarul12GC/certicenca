<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql = "SELECT 
            'aduanaentradas' AS Tabla,
            ae.AduanaEntradaID AS ae_AduanaEntradaID,
            ae.NumeroPedimento AS ae_NumeroPedimento,
            ae.ClaveAduana AS ae_ClaveAduana,
            ae.patente AS ae_patente,
            ae.NumeroDoc AS ae_NumeroDoc,
            ae.ClavePedimento AS ae_ClavePedimento,
            ae.FechaPedimento AS ae_FechaPedimento,
            ae.CantidadEntradaAduana AS ae_CantidadEntradaAduana,
            ae.PaisOrigenMercancia AS ae_PaisOrigenMercancia,
            ae.tipoImpuesto AS ae_tipoImpuesto,
            ae.TasaDeImpuesto AS ae_TasaDeImpuesto,
            ae.FacturaComercial AS ae_FacturaComercial,
            ae.AvisoElectronico AS ae_AvisoElectronico,
            ae.FechaCruce AS ae_FechaCruce,
           
            m.MaterialID AS m_MaterialID,
            m.NumParte AS m_NumParte,
            m.DescripcionMaterial AS m_DescripcionMaterial,
            m.FraccionArancelaria AS m_FraccionArancelaria,
            m.UnidadMedidaComercializacion AS m_UnidadMedidaComercializacion,
            m.UnidadMedidaTIGIE AS m_UnidadMedidaTIGIE,
            m.TipoMaterial AS m_TipoMaterial,
           
            p.ProveedorID AS p_ProveedorID,
            p.NumClaveIdentificacionEmpresa AS p_NumClaveIdentificacionEmpresa,
            p.NombreRazonSocial AS p_NombreRazonSocial,
            p.Nacionalidad AS p_Nacionalidad,
            p.NumProgramaIMMEX AS p_NumProgramaIMMEX,
            p.RecintoFiscalizado AS p_RecintoFiscalizado,
            p.ClaveIdentificacionFiscal AS p_ClaveIdentificacionFiscal,
            p.Calle AS p_Calle,
            p.Numero AS p_Numero,
            p.CodigoPostal AS p_CodigoPostal,
            p.Colonia AS p_Colonia,
            p.EntidadFederativa AS p_EntidadFederativa,
            p.Pais AS p_Pais,
            
            sm.SubmanufacturaID AS sm_SubmanufacturaID,
            sm.NumClaveIdentificacion AS sm_NumClaveIdentificacion,
            sm.NombreRazonSocial AS sm_NombreRazonSocial,
            sm.NumAutorizacionSE AS sm_NumAutorizacionSE,
            sm.FechaAutorizacion AS sm_FechaAutorizacion,
            sm.Calle AS sm_Calle,
            sm.Numero AS sm_Numero,
            sm.CodigoPostal AS sm_CodigoPostal,
            sm.Colonia AS sm_Colonia,
            sm.EntidadFederativa AS sm_EntidadFederativa,
            sm.Pais AS sm_Pais,
            
            c.ClienteID AS c_ClienteID,
            c.NumClaveIdentificacion AS c_NumClaveIdentificacion,
            c.NombreRazonSocial AS c_NombreRazonSocial,
            c.Nacionalidad AS c_Nacionalidad,
            c.NumProgramaIMMEX AS c_NumProgramaIMMEX,
            c.ECEX AS c_ECEX,
            c.EmpresaIndustrial AS c_EmpresaIndustrial,
            c.RecintoFiscalizado AS c_RecintoFiscalizado,
            c.ClaveIdentificacionFiscal AS c_ClaveIdentificacionFiscal,
            c.Calle AS c_Calle,
            c.Numero AS c_Numero,
            c.CodigoPostal AS c_CodigoPostal,
            c.Colonia AS c_Colonia,
            c.EntidadFederativa AS c_EntidadFederativa,
            c.Pais AS c_Pais,
           
            ag.AgenteAduanalID AS ag_AgenteAduanalID,
            ag.TipoAgente AS ag_TipoAgente,
            ag.NumPatenteAutorizacion AS ag_NumPatenteAutorizacion,
            ag.NombreAgenteAduanal AS ag_NombreAgenteAduanal,
            ag.ApellidoPaterno AS ag_ApellidoPaterno,
            ag.ApellidoMaterno AS ag_ApellidoMaterno,
            ag.RFC AS ag_RFC,
            ag.CURP AS ag_CURP,
            ag.RazonSocial AS ag_RazonSocial,
            ag.Calle AS ag_Calle,
            ag.Numero AS ag_Numero,
            ag.CodigoPostal AS ag_CodigoPostal,
            ag.Colonia AS ag_Colonia,
            ag.EntidadFederativa AS ag_EntidadFederativa,
            ag.Pais AS ag_Pais,
           
            pr.ProductoID AS pr_ProductoID,
            pr.NumParte AS pr_NumParte,
            pr.DescripcionProducto AS pr_DescripcionProducto,
            pr.FraccionArancelaria AS pr_FraccionArancelaria,
            pr.UnidadMedidaComercializacion AS pr_UnidadMedidaComercializacion,
            pr.UnidadMedidaTIGIE AS pr_UnidadMedidaTIGIE
        FROM 
            aduanaentradas ae
        LEFT JOIN 
            materiales m ON ae.MaterialID = m.MaterialID
        LEFT JOIN 
            proveedores p ON ae.ProveedorID = p.ProveedorID
        LEFT JOIN 
            submanufactura sm ON ae.SubmanufacturaID = sm.SubmanufacturaID
        LEFT JOIN 
            clientes c ON ae.ContribuyenteID = c.ClienteID
        LEFT JOIN 
            agentesaduanales ag ON ae.AgenteAduanalID = ag.AgenteAduanalID
        LEFT JOIN 
            productos pr ON ae.ProductoID = pr.ProductoID";

$resultado = $conn->query($sql);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("AduanaEntradas");

$columnas = array(
    'A' => 'Tabla',
    'B' => 'ae_AduanaEntradaID',
    'C' => 'ae_NumeroPedimento',
    'D' => 'ae_ClaveAduana',
    'E' => 'ae_patente',
    'F' => 'ae_NumeroDoc',
    'G' => 'ae_ClavePedimento',
    'H' => 'ae_FechaPedimento',
    'I' => 'ae_CantidadEntradaAduana',
    'J' => 'ae_PaisOrigenMercancia',
    'K' => 'ae_tipoImpuesto',
    'L' => 'ae_TasaDeImpuesto',
    'M' => 'ae_FacturaComercial',
    'N' => 'ae_AvisoElectronico',
    'O' => 'ae_FechaCruce',
    'P' => 'm_MaterialID',
    'Q' => 'm_NumParte',
    'R' => 'm_DescripcionMaterial',
    'S' => 'm_FraccionArancelaria',
    'T' => 'm_UnidadMedidaComercializacion',
    'U' => 'm_UnidadMedidaTIGIE',
    'V' => 'm_TipoMaterial',
    'W' => 'p_ProveedorID',
    'X' => 'p_NumClaveIdentificacionEmpresa',
    'Y' => 'p_NombreRazonSocial',
    'Z' => 'p_Nacionalidad',
    'AA' => 'p_NumProgramaIMMEX',
    'AB' => 'p_RecintoFiscalizado',
    'AC' => 'p_ClaveIdentificacionFiscal',
    'AD' => 'p_Calle',
    'AE' => 'p_Numero',
    'AF' => 'p_CodigoPostal',
    'AG' => 'p_Colonia',
    'AH' => 'p_EntidadFederativa',
    'AI' => 'p_Pais',
    'AJ' => 'sm_SubmanufacturaID',
    'AK' => 'sm_NumClaveIdentificacion',
    'AL' => 'sm_NombreRazonSocial',
    'AM' => 'sm_NumAutorizacionSE',
    'AN' => 'sm_FechaAutorizacion',
    'AO' => 'sm_Calle',
    'AP' => 'sm_Numero',
    'AQ' => 'sm_CodigoPostal',
    'AR' => 'sm_Colonia',
    'AS' => 'sm_EntidadFederativa',
    'AT' => 'sm_Pais',
    'AU' => 'c_ClienteID',
    'AV' => 'c_NumClaveIdentificacion',
    'AW' => 'c_NombreRazonSocial',
    'AX' => 'c_Nacionalidad',
    'AY' => 'c_NumProgramaIMMEX',
    'AZ' => 'c_ECEX',
    'BA' => 'c_EmpresaIndustrial',
    'BB' => 'c_RecintoFiscalizado',
    'BC' => 'c_ClaveIdentificacionFiscal',
    'BD' => 'c_Calle',
    'BE' => 'c_Numero',
    'BF' => 'c_CodigoPostal',
    'BG' => 'c_Colonia',
    'BH' => 'c_EntidadFederativa',
    'BI' => 'c_Pais',
    'BJ' => 'ag_AgenteAduanalID',
    'BK' => 'ag_TipoAgente',
    'BL' => 'ag_NumPatenteAutorizacion',
    'BM' => 'ag_NombreAgenteAduanal',
    'BN' => 'ag_ApellidoPaterno',
    'BO' => 'ag_ApellidoMaterno',
    'BP' => 'ag_RFC',
    'BQ' => 'ag_CURP',
    'BR' => 'ag_RazonSocial',
    'BS' => 'ag_Calle',
    'BT' => 'ag_Numero',
    'BU' => 'ag_CodigoPostal',
    'BV' => 'ag_Colonia',
    'BW' => 'ag_EntidadFederativa',
    'BX' => 'ag_Pais',
    'BY' => 'pr_ProductoID',
    'BZ' => 'pr_NumParte',
    'CA' => 'pr_DescripcionProducto',
    'CB' => 'pr_FraccionArancelaria',
    'CC' => 'pr_UnidadMedidaComercializacion',
    'CD' => 'pr_UnidadMedidaTIGIE'
);

foreach ($columnas as $key => $value) {
    $hojaActiva->setCellValue($key . '1', $value);
    $hojaActiva->getColumnDimension($key)->setWidth(20);
}

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    foreach ($columnas as $key => $value) {
        $hojaActiva->setCellValue($key . $fila, $rows[$value]);
    }
    $fila++;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="aduanaentradas.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = IOFactory::createWriter($excel, 'Xlsx');
$objWriter->save('php://output');

exit;
?>
