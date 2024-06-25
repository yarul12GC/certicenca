<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex =

    "SELECT      'aduanasalidas' AS Tabla,
                            asal.AduanaSalidaID,
                            asal.NumeroPedimento AS NumeroPedimentoAS,
                            asal.ClavePedimento AS ClavePedimentoAS,
                            asal.FechaPedimento AS FechaPedimentoAS,
                            asal.CantidadSalidaAd,
                            asal.PaisOrigenMercancia AS PaisOrigenMercanciaAS,
                            asal.tipoImpuesto AS tipoImpuestoAS,
                            asal.TasaDeImpuesto AS TasaDeImpuestoAS,
                            asal.FacturaComercial AS FacturaComercialAS,
                            asal.AvisoElectronico AS AvisoElectronicoAS,
                            asal.FechaCruce AS FechaCruceAS,
                            c.NumClaveIdentificacion AS clienteCa,
                            c.NombreRazonSocial AS NombreRazonSocialCa,
                            c.Nacionalidad AS NacionalidadCa,
                            c.NumProgramaIMMEX AS NumProgramaIMMEXCa,
                            c.ECEX AS ECEXCa,
                            c.EmpresaIndustrial AS EmpresaIndustrialCa,
                            c.RecintoFiscalizado AS RecintoFiscalizadoCa,
                            c.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalCa,
                            c.Calle AS CalleCa,
                            c.Numero AS NumeroCa,
                            c.CodigoPostal AS CodigoPostalCa,
                            c.Colonia AS ColoniaCa,
                            c.EntidadFederativa AS EntidadFederativaCa,
                            c.Pais AS PaisCa,
                            ct.*,
                            pd.*,
                            aent.AduanaEntradaID,
                            aent.NumeroPedimento AS NumeroPedimentoAE,
                            aent.ClaveAduana AS ClaveAduanaAE,
                            aent.patente AS patenteAE,
                            aent.NumeroDoc AS NumeroDocAE,
                            aent.ClavePedimento AS ClavePedimentoAE,
                            aent.FechaPedimento AS FechaPedimentoAE,
                            aent.CantidadEntradaAduana AS CantidadEntradaAduanaAE,
                            aent.PaisOrigenMercancia AS PaisOrigenMercanciaAE,
                            aent.tipoImpuesto AS tipoImpuestoAE,
                            aent.TasaDeImpuesto AS TasaDeImpuestoAE,
                            aent.FacturaComercial AS FacturaComercialAE,
                            aent.AvisoElectronico AS AvisoElectronicoAE,
                            aent.FechaCruce AS FechaCruceAE,
                            pro.ProveedorID,
                            pro.NumClaveIdentificacionEmpresa AS NumClaveIdentificacionEmpresaProb,
                            pro.NombreRazonSocial AS NombreRazonSocialProb,
                            pro.Nacionalidad AS NacionalidadProb,
                            pro.NumProgramaIMMEX AS NumProgramaIMMEXProb,
                            pro.RecintoFiscalizado AS RecintoFiscalizadoProb,                         
                            pro.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalProb,
                            pro.Calle AS CalleProb,
                            pro.Numero AS NumeroProb,
                            pro.CodigoPostal AS CodigoPostalProb,
                            pro.Colonia AS ColoniaProb,
                            pro.EntidadFederativa AS EntidadFederativaProb,
                            pro.Pais AS PaisProb,
                            m.MaterialID, 
                            m.NumParte AS MaterialNumParte,
                            m.DescripcionMaterial,
                            m.FraccionArancelaria AS MaterialFraccionArancelaria,
                            m.UnidadMedidaComercializacion AS MaterialUnidadMedidaComercializacion,
                            m.UnidadMedidaTIGIE AS MaterialUnidadMedidaTIGIE,
                            m.TipoMaterial,
                            sm.SubmanufacturaID,
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
                            aduanasalidas asal
                        LEFT JOIN 
                            aduanaentradas aent ON asal.AduanaEntradaID = aent.AduanaEntradaID
                        LEFT JOIN 
                            materiales m ON asal.MaterialID = m.MaterialID
                        LEFT JOIN 
                            clientes c ON  asal.ClienteID = c.ClienteID
                        LEFT JOIN 
                            proveedores pro ON asal.ProveedorID = pro.ProveedorID
                        LEFT JOIN 
                            contribuyente ct ON asal.ContribuyenteID = ct.ContribuyenteID
                        LEFT JOIN
                            productos pd ON  asal.ProductoID = pd.ProductoID
                        LEFT JOIN 
                            submanufactura sm ON asal.SubmanufacturaID = sm.SubmanufacturaID";

$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Reporte-Aduana-salidas");

$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'Número Pedimento');
$hojaActiva->setCellValue('C1', 'Clave de Pedimento');
$hojaActiva->setCellValue('D1', 'Fecha de Pedimento');
$hojaActiva->setCellValue('E1', 'Cantidad de Salida');
$hojaActiva->setCellValue('F1', 'Pais de Origen de la Mercancia');
$hojaActiva->setCellValue('G1', 'Tipo de Impuesto');
$hojaActiva->setCellValue('H1', 'Tasa de Impuesto');
$hojaActiva->setCellValue('I1', 'Factura Comercial');
$hojaActiva->setCellValue('J1', 'Aviso Electronico');
$hojaActiva->setCellValue('K1', 'Fecha de Cruce');
$hojaActiva->setCellValue('L1', 'Número Pedimento de la Entrada');
$hojaActiva->setCellValue('M1', 'Clave de Aduana');
$hojaActiva->setCellValue('N1', 'Patente');
$hojaActiva->setCellValue('O1', 'Número de Documento');
$hojaActiva->setCellValue('P1', 'Clave de Pedimento');
$hojaActiva->setCellValue('Q1', 'Fecha de Pedimento');
$hojaActiva->setCellValue('R1', 'Cantidad de Entrada');
$hojaActiva->setCellValue('S1', 'Pais de Origen de la Mercancia');
$hojaActiva->setCellValue('T1', 'Tipo de Impuesto');
$hojaActiva->setCellValue('U1', 'Tasa de Impuesto');
$hojaActiva->setCellValue('V1', 'Factura Comercial');
$hojaActiva->setCellValue('W1', 'Aviso Electronico');
$hojaActiva->setCellValue('X1', 'Fecha de Cruce');
$hojaActiva->setCellValue('Y1', 'Cliente: Número o clave de identificación');
$hojaActiva->setCellValue('Z1', 'Nombre, denominación o razón social');
$hojaActiva->setCellValue('AA1', 'Nacionalidad');
$hojaActiva->setCellValue('AB1', 'rograma IMMEX');
$hojaActiva->setCellValue('AC1', 'ECEX');
$hojaActiva->setCellValue('AD1', 'Empresa de la industria automotriz');
$hojaActiva->setCellValue('AE1', 'Recinto Fiscalizado');
$hojaActiva->setCellValue('AF1', 'Clave de Identificación Fiscal');
$hojaActiva->setCellValue('AG1', 'Calle');
$hojaActiva->setCellValue('AH1', 'Numero');
$hojaActiva->setCellValue('AI1', 'Codigo Postal');
$hojaActiva->setCellValue('AJ1', 'Colonia');
$hojaActiva->setCellValue('AK1', 'Entidad Federativa');
$hojaActiva->setCellValue('AL1', 'Pais');
$hojaActiva->setCellValue('AM1', 'Material: Número o clave de identificación');
$hojaActiva->setCellValue('AN1', 'Descripción del material');
$hojaActiva->setCellValue('AO1', 'Fracción arancelaria');
$hojaActiva->setCellValue('AP1', 'Unidad de medida de comercialización');
$hojaActiva->setCellValue('AQ1', 'Unidad de medida de la TIGIE');
$hojaActiva->setCellValue('AR1', 'Tipo de material');
$hojaActiva->setCellValue('AS1', 'Producto: Número o clave de identificación');
$hojaActiva->setCellValue('AT1', 'Descripción del producto');
$hojaActiva->setCellValue('AU1', 'Fracción arancelaria');
$hojaActiva->setCellValue('AV1', 'Unidad de medida de comercialización');
$hojaActiva->setCellValue('AW1', 'Unidad de Medida TIGIE');
$hojaActiva->setCellValue('AX1', 'Proveedor:Número o Clave de Identificación');
$hojaActiva->setCellValue('AY1', 'Nombre o Razón Social');
$hojaActiva->setCellValue('AZ1', 'Nacionalidad');
$hojaActiva->setCellValue('BA1', 'Número de Programa IMMEX');
$hojaActiva->setCellValue('BB1', 'Recinto Fiscalizado');
$hojaActiva->setCellValue('BC1', 'Clave de Identificación Fiscal');
$hojaActiva->setCellValue('BD1', 'Calle');
$hojaActiva->setCellValue('BE1', 'Numero');
$hojaActiva->setCellValue('BF1', 'Codigo Postal');
$hojaActiva->setCellValue('BG1', 'Colonia');
$hojaActiva->setCellValue('BH1', 'Entidad Federativa');
$hojaActiva->setCellValue('BI1', 'Pais');
$hojaActiva->setCellValue('BJ1', 'Submanufactura:Número o Clave');
$hojaActiva->setCellValue('BK1', 'Nombre o Razón Social');
$hojaActiva->setCellValue('BL1', 'Número de Autorización');
$hojaActiva->setCellValue('BM1', 'Fecha de Autorización');
$hojaActiva->setCellValue('BN1', 'Calle');
$hojaActiva->setCellValue('BO1', 'Numero');
$hojaActiva->setCellValue('BP1', 'Codigo Postal');
$hojaActiva->setCellValue('BQ1', 'Colonia');
$hojaActiva->setCellValue('BR1', 'Entidad Federativa');
$hojaActiva->setCellValue('BS1', 'Pais');
$hojaActiva->setCellValue('BT1', 'contribuyente:Denominación o Razón Social');
$hojaActiva->setCellValue('BU1', 'Clave RFC:');
$hojaActiva->setCellValue('BV1', 'Número de Programa IMMEX');
$hojaActiva->setCellValue('BW1', 'Tipo de Domicilio');
$hojaActiva->setCellValue('BX1', 'Calle');
$hojaActiva->setCellValue('BY1', 'Numero');
$hojaActiva->setCellValue('BZ1', 'Codigo Postal');
$hojaActiva->setCellValue('CA1', 'Colonia');
$hojaActiva->setCellValue('CB1', 'Entidad Federativa');


// Puedes continuar agregando más columnas según tus necesidades

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->getColumnDimension('B')->setWidth(20);
    $hojaActiva->setCellValue('B' . $fila, $rows['NumeroPedimentoAS']);
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C' . $fila, $rows['ClavePedimentoAS']);
    $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D' . $fila, $rows['FechaPedimentoAS']);
    $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E' . $fila, $rows['CantidadSalidaAd']);
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F' . $fila, $rows['PaisOrigenMercanciaAS']);
    $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G' . $fila, $rows['tipoImpuestoAS']);
    $hojaActiva->getColumnDimension('H')->setWidth(20);
    $hojaActiva->setCellValue('H' . $fila, $rows['TasaDeImpuestoAS']);
    $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I' . $fila, $rows['FacturaComercialAS']);
    $hojaActiva->getColumnDimension('J')->setWidth(20);
    $hojaActiva->setCellValue('J' . $fila, $rows['AvisoElectronicoAS']);
    $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K' . $fila, $rows['FacturaComercialAS']);
    $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L' . $fila, $rows['NumeroPedimentoAE']);
    $hojaActiva->getColumnDimension('M')->setWidth(20);
    $hojaActiva->setCellValue('M' . $fila, $rows['ClaveAduanaAE']);
    $hojaActiva->getColumnDimension('N')->setWidth(20);
    $hojaActiva->setCellValue('N' . $fila, $rows['patenteAE']);
    $hojaActiva->getColumnDimension('O')->setWidth(20);
    $hojaActiva->setCellValue('O' . $fila, $rows['NumeroDocAE']);
    $hojaActiva->getColumnDimension('P')->setWidth(20);
    $hojaActiva->setCellValue('P' . $fila, $rows['ClavePedimentoAE']);
    $hojaActiva->getColumnDimension('Q')->setWidth(30);
    $hojaActiva->setCellValue('Q' . $fila, $rows['FechaPedimentoAE']);
    $hojaActiva->getColumnDimension('R')->setWidth(20);
    $hojaActiva->setCellValue('R' . $fila, $rows['CantidadEntradaAduanaAE']);
    $hojaActiva->getColumnDimension('S')->setWidth(20);
    $hojaActiva->setCellValue('S' . $fila, $rows['PaisOrigenMercanciaAE']);
    $hojaActiva->getColumnDimension('T')->setWidth(20);
    $hojaActiva->setCellValue('T' . $fila, $rows['tipoImpuestoAE']);
    $hojaActiva->getColumnDimension('U')->setWidth(20);
    $hojaActiva->setCellValue('U' . $fila, $rows['TasaDeImpuestoAE']);
    $hojaActiva->getColumnDimension('V')->setWidth(20);
    $hojaActiva->setCellValue('V' . $fila, $rows['FacturaComercialAE']);
    $hojaActiva->getColumnDimension('W')->setWidth(20);
    $hojaActiva->setCellValue('W' . $fila, $rows['AvisoElectronicoAE']);
    $hojaActiva->getColumnDimension('X')->setWidth(20);
    $hojaActiva->setCellValue('X' . $fila, $rows['FechaCruceAE']);
    $hojaActiva->getColumnDimension('Y')->setWidth(20);
    $hojaActiva->setCellValue('Y' . $fila, $rows['clienteCa']);
    $hojaActiva->getColumnDimension('Z')->setWidth(20);
    $hojaActiva->setCellValue('Z' . $fila, $rows['NombreRazonSocialCa']);
    $hojaActiva->getColumnDimension('AA')->setWidth(20);
    $hojaActiva->setCellValue('AA' . $fila, $rows['NacionalidadCa']);
    $hojaActiva->getColumnDimension('AB')->setWidth(20);
    $hojaActiva->setCellValue('AB' . $fila, $rows['NumProgramaIMMEXCa']);
    $hojaActiva->getColumnDimension('AC')->setWidth(20);
    $hojaActiva->setCellValue('AC' . $fila, $rows['ECEXCa']);
    $hojaActiva->getColumnDimension('AD')->setWidth(20);
    $hojaActiva->setCellValue('AD' . $fila, $rows['EmpresaIndustrialCa']);
    $hojaActiva->getColumnDimension('AE')->setWidth(20);
    $hojaActiva->setCellValue('AE' . $fila, $rows['RecintoFiscalizadoCa']);
    $hojaActiva->getColumnDimension('AF')->setWidth(20);
    $hojaActiva->setCellValue('AF' . $fila, $rows['ClaveIdentificacionFiscalCa']);
    $hojaActiva->getColumnDimension('AG')->setWidth(20);
    $hojaActiva->setCellValue('AG' . $fila, $rows['CalleCa']);
    $hojaActiva->getColumnDimension('AH')->setWidth(20);
    $hojaActiva->setCellValue('AH' . $fila, $rows['NumeroCa']);
    $hojaActiva->getColumnDimension('AI')->setWidth(20);
    $hojaActiva->setCellValue('AI' . $fila, $rows['CodigoPostalCa']);
    $hojaActiva->getColumnDimension('AJ')->setWidth(20);
    $hojaActiva->setCellValue('AJ' . $fila, $rows['ColoniaCa']);
    $hojaActiva->getColumnDimension('AK')->setWidth(20);
    $hojaActiva->setCellValue('AK' . $fila, $rows['EntidadFederativaCa']);
    $hojaActiva->getColumnDimension('AL')->setWidth(20);
    $hojaActiva->setCellValue('AL' . $fila, $rows['PaisCa']);
    $hojaActiva->getColumnDimension('AM')->setWidth(20);
    $hojaActiva->setCellValue('AM' . $fila, $rows['MaterialNumParte']);
    $hojaActiva->getColumnDimension('AN')->setWidth(50);
    $hojaActiva->setCellValue('AN' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->getColumnDimension('AO')->setWidth(20);
    $hojaActiva->setCellValue('AO' . $fila, $rows['MaterialFraccionArancelaria']);
    $hojaActiva->getColumnDimension('AP')->setWidth(20);
    $hojaActiva->setCellValue('AP' . $fila, $rows['MaterialUnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('AQ')->setWidth(20);
    $hojaActiva->setCellValue('AQ' . $fila, $rows['MaterialUnidadMedidaTIGIE']);
    $hojaActiva->getColumnDimension('AR')->setWidth(20);
    $hojaActiva->setCellValue('AR' . $fila, $rows['TipoMaterial']);
    $hojaActiva->getColumnDimension('AS')->setWidth(20);
    $hojaActiva->setCellValue('AS' . $fila, $rows['NumParte']);
    $hojaActiva->getColumnDimension('AT')->setWidth(20);
    $hojaActiva->setCellValue('AT' . $fila, $rows['DescripcionProducto']);
    $hojaActiva->getColumnDimension('AU')->setWidth(20);
    $hojaActiva->setCellValue('AU' . $fila, $rows['FraccionArancelaria']);
    $hojaActiva->getColumnDimension('AV')->setWidth(20);
    $hojaActiva->setCellValue('AV' . $fila, $rows['UnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('AW')->setWidth(20);
    $hojaActiva->setCellValue('AW' . $fila, $rows['UnidadMedidaTIGIE']);
    $hojaActiva->getColumnDimension('AX')->setWidth(20);
    $hojaActiva->setCellValue('AX' . $fila, $rows['NumClaveIdentificacionEmpresaProb']);
    $hojaActiva->getColumnDimension('AY')->setWidth(20);
    $hojaActiva->setCellValue('AY' . $fila, $rows['NombreRazonSocialProb']);
    $hojaActiva->getColumnDimension('AZ')->setWidth(20);
    $hojaActiva->setCellValue('AZ' . $fila, $rows['NacionalidadProb']);
    $hojaActiva->getColumnDimension('BA')->setWidth(20);
    $hojaActiva->setCellValue('BA' . $fila, $rows['NumProgramaIMMEXProb']);
    $hojaActiva->getColumnDimension('BB')->setWidth(20);
    $hojaActiva->setCellValue('BB' . $fila, $rows['RecintoFiscalizadoProb']);
    $hojaActiva->getColumnDimension('BC')->setWidth(20);
    $hojaActiva->setCellValue('BC' . $fila, $rows['ClaveIdentificacionFiscalProb']);
    $hojaActiva->getColumnDimension('BD')->setWidth(20);
    $hojaActiva->setCellValue('BD' . $fila, $rows['CalleProb']);
    $hojaActiva->getColumnDimension('BE')->setWidth(20);
    $hojaActiva->setCellValue('BE' . $fila, $rows['NumeroProb']);
    $hojaActiva->getColumnDimension('BF')->setWidth(20);
    $hojaActiva->setCellValue('BF' . $fila, $rows['CodigoPostalProb']);
    $hojaActiva->getColumnDimension('BG')->setWidth(20);
    $hojaActiva->setCellValue('BG' . $fila, $rows['ColoniaProb']);
    $hojaActiva->getColumnDimension('BH')->setWidth(20);
    $hojaActiva->setCellValue('BH' . $fila, $rows['EntidadFederativaProb']);
    $hojaActiva->getColumnDimension('BI')->setWidth(20);
    $hojaActiva->setCellValue('BI' . $fila, $rows['PaisProb']);
    $hojaActiva->getColumnDimension('BJ')->setWidth(20);
    $hojaActiva->setCellValue('BJ' . $fila, $rows['NumClaveIdentificacionSub']);
    $hojaActiva->getColumnDimension('BK')->setWidth(20);
    $hojaActiva->setCellValue('BK' . $fila, $rows['NombreRazonSocialSub']);
    $hojaActiva->getColumnDimension('BL')->setWidth(20);
    $hojaActiva->setCellValue('BL' . $fila, $rows['NumAutorizacionSESub']);
    $hojaActiva->getColumnDimension('BM')->setWidth(20);
    $hojaActiva->setCellValue('BM' . $fila, $rows['FechaAutorizacionSub']);
    $hojaActiva->getColumnDimension('BN')->setWidth(20);
    $hojaActiva->setCellValue('BN' . $fila, $rows['CalleSub']);
    $hojaActiva->getColumnDimension('BO')->setWidth(20);
    $hojaActiva->setCellValue('BO' . $fila, $rows['NumeroSub']);
    $hojaActiva->getColumnDimension('BP')->setWidth(20);
    $hojaActiva->setCellValue('BP' . $fila, $rows['CodigoPostalSub']);
    $hojaActiva->getColumnDimension('BQ')->setWidth(20);
    $hojaActiva->setCellValue('BQ' . $fila, $rows['ColoniaSub']);
    $hojaActiva->getColumnDimension('BR')->setWidth(20);
    $hojaActiva->setCellValue('BR' . $fila, $rows['EntidadFederativaSub']);
    $hojaActiva->getColumnDimension('BS')->setWidth(20);
    $hojaActiva->setCellValue('BS' . $fila, $rows['PaisSub']);
    $hojaActiva->getColumnDimension('BT')->setWidth(20);
    $hojaActiva->setCellValue('BT' . $fila, $rows['DenominacionRazonSocial']);
    $hojaActiva->getColumnDimension('BU')->setWidth(20);
    $hojaActiva->setCellValue('BU' . $fila, $rows['ClaveRFC']);
    $hojaActiva->getColumnDimension('BV')->setWidth(20);
    $hojaActiva->setCellValue('BV' . $fila, $rows['NumProgramaIMMEX']);
    $hojaActiva->getColumnDimension('BW')->setWidth(20);
    $hojaActiva->setCellValue('BW' . $fila, $rows['TipoDomicilio']);
    $hojaActiva->getColumnDimension('BX')->setWidth(20);
    $hojaActiva->setCellValue('BX' . $fila, $rows['CallePlanta']);
    $hojaActiva->getColumnDimension('BY')->setWidth(20);
    $hojaActiva->setCellValue('BY' . $fila, $rows['NumeroPlanta']);
    $hojaActiva->getColumnDimension('BZ')->setWidth(20);
    $hojaActiva->setCellValue('BZ' . $fila, $rows['CodigoPostal']);
    $hojaActiva->getColumnDimension('CA')->setWidth(20);
    $hojaActiva->setCellValue('CA' . $fila, $rows['ColoniaPlanta']);
    $hojaActiva->getColumnDimension('CB')->setWidth(20);
    $hojaActiva->setCellValue('CB' . $fila, $rows['EntidadFederativa']);

    // Continúa con el resto de las columnas según tus necesidades
    $fila++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte-Aduana-salida.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
