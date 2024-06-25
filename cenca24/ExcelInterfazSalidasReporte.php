<?php
include 'startSession.php';
require 'vendor/autoload.php';
require 'conexion.php';

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};

$sql_interfaseex =

    "SELECT 
                             'interfasesalidas' AS Tabla,
                        ifs.*,
                        ifs.NumParte AS NumParteS,                      
                        ifs.Cantidad AS CantidadS,    
                        ifs.UnidadMedidaComercializacion AS UnidadMedidaComercializacionS,
                        ifs.MontoDolares AS MontoDolaresS,
                        ifs.FechaRecibo As FechaReciboS,
                        ifs.NumFacturaControlRecibo AS NumFacturaControlReciboS,
                        ifs.OrdenCompra AS OrdenCompraS,
                        ifs.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoS,
                        ife.Cantidad AS CantidadE,                                              
                        ife.UnidadMedidaComercializacion AS UnidadMedidaComercializacionE,
                        ife.MontoDolares AS MontoDolaresE,
                        ife.FechaRecibo As FechaReciboEntrada,
                        ife.NumFacturaControlRecibo AS NumFacturaControlReciboE,
                        ife.OrdenCompra AS OrdenCompraE,
                        ife.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoE,
                        c.NumClaveIdentificacion AS clienteC,
                        c.NombreRazonSocial AS NombreRazonSocialC,
                        c.Nacionalidad AS NacionalidadC,
                        c.NumProgramaIMMEX AS NumProgramaIMMEXC,
                        c.ECEX AS ECEXC,
                        c.EmpresaIndustrial AS EmpresaIndustrialC,
                        c.RecintoFiscalizado AS RecintoFiscalizadoC,
                        c.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalC,
                        c.Calle AS CalleC,
                        c.Numero AS NumeroC,
                        c.CodigoPostal AS CodigoPostalC,
                        c.Colonia AS ColoniaC,
                        c.EntidadFederativa AS EntidadFederativaC,
                        c.Pais AS PaisC,
                        m.NumParte AS MaterialNumParte,
                        m.DescripcionMaterial,
                        m.FraccionArancelaria AS MaterialFraccionArancelaria,
                        m.UnidadMedidaComercializacion AS MaterialUnidadMedidaComercializacion,
                        m.UnidadMedidaTIGIE AS MaterialUnidadMedidaTIGIE,
                        m.TipoMaterial,
                        pd.*,
                        ct.*,
                        pr.NumClaveIdentificacionEmpresa AS NumClaveIdentificacionEmpresaPro,
                        pr.NombreRazonSocial AS NombreRazonSocialPro,
                        pr.Nacionalidad AS NacionalidadPro,
                        pr.NumProgramaIMMEX AS NumProgramaIMMEXPro,
                        pr.RecintoFiscalizado AS RecintoFiscalizadoPro,
                        pr.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalPro,
                        pr.Calle AS CallePro,
                        pr.Numero AS NumeroPro,
                        pr.CodigoPostal AS CodigoPostalPro,
                        pr.Colonia AS ColoniaPro,
                        pr.EntidadFederativa AS EntidadFederativaPro,
                        pr.Pais AS PaisPro
                    FROM 
                    interfasesalidas  ifs
                    LEFT JOIN 
                        interfaseentradas ife ON  ifs.InterfaseEntradaID = ife.InterfaseEntradaID
                    LEFT JOIN 
                        clientes c ON  ifs.ClienteID = c.ClienteID
                    LEFT JOIN 
                        materiales m ON  ifs.MaterialID = m.MaterialID
                    LEFT JOIN 
                        contribuyente ct ON  ifs.ContribuyenteID = ct.ContribuyenteID
                    LEFT JOIN 
                        proveedores pr ON  ifs.ProveedorID = pr.ProveedorID
                    LEFT JOIN
                        productos pd ON  ifs.ProductoID = pd.ProductoID";

$resultado = $conn->query($sql_interfaseex);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Reporte-Interfas-salidas");

$hojaActiva->setCellValue('A1', 'Tabla');
$hojaActiva->setCellValue('B1', 'Número de parte');
$hojaActiva->setCellValue('C1', 'Cantidad de Salida');
$hojaActiva->setCellValue('D1', 'Unidad de Medida de Comercialización');
$hojaActiva->setCellValue('E1', 'Monto en Dolares');
$hojaActiva->setCellValue('F1', 'Fecha de Recibo');
$hojaActiva->setCellValue('G1', 'Numero de Factura Control');
$hojaActiva->setCellValue('H1', 'Orden de Compra');
$hojaActiva->setCellValue('I1', 'Identificador del SistemaCorporativo');

$hojaActiva->setCellValue('J1', 'Cantidad de la entrada');
$hojaActiva->setCellValue('K1', 'Unidad de Medida de Comercialización');
$hojaActiva->setCellValue('L1', 'Monto en Dolares');
$hojaActiva->setCellValue('M1', 'Fecha de Recibo');
$hojaActiva->setCellValue('N1', 'Numero de Factura Control');
$hojaActiva->setCellValue('O1', 'Orden de Compra');
$hojaActiva->setCellValue('P1', 'Identificador del SistemaCorporativo');

$hojaActiva->setCellValue('Q1', 'Cliente: Número o clave de identificación');
$hojaActiva->setCellValue('R1', 'Nombre, denominación o razón social');
$hojaActiva->setCellValue('S1', 'Nacionalidad');
$hojaActiva->setCellValue('T1', 'Programa IMMEX');
$hojaActiva->setCellValue('U1', 'ECEX');
$hojaActiva->setCellValue('V1', 'Empresa de la industria automotriz');
$hojaActiva->setCellValue('W1', 'Recinto Fiscalizado');
$hojaActiva->setCellValue('X1', 'Clave de Identificación Fiscal');
$hojaActiva->setCellValue('Y1', 'Calle');
$hojaActiva->setCellValue('Z1', 'Numero');
$hojaActiva->setCellValue('AA1', 'Codigo Postal');
$hojaActiva->setCellValue('AB1', 'Colonia');
$hojaActiva->setCellValue('AC1', 'Entidad Federativa');
$hojaActiva->setCellValue('AD1', 'Pais');


$hojaActiva->setCellValue('AE1', 'Material: Número o clave de identificación');
$hojaActiva->setCellValue('AF1', 'Descripción del material');
$hojaActiva->setCellValue('AG1', 'Fracción arancelaria');
$hojaActiva->setCellValue('AH1', 'Unidad de medida de comercialización');
$hojaActiva->setCellValue('AI1', 'Unidad de medida de la TIGIE');
$hojaActiva->setCellValue('AJ1', 'Tipo de material');


$hojaActiva->setCellValue('AK1', 'Producto: Número o clave de identificación');
$hojaActiva->setCellValue('AL1', 'Descripción del producto');
$hojaActiva->setCellValue('AM1', 'Fracción arancelaria');
$hojaActiva->setCellValue('AN1', 'Unidad de medida de comercialización');
$hojaActiva->setCellValue('AO1', 'Unidad de Medida TIGIE');

$hojaActiva->setCellValue('AP1', 'Proveedor: Número o Clave de Identificación');
$hojaActiva->setCellValue('AQ1', 'Nombre o Razón Social');
$hojaActiva->setCellValue('AR1', 'Nacionalidad');
$hojaActiva->setCellValue('AS1', 'Número de Programa IMMEX');
$hojaActiva->setCellValue('AT1', 'Recinto Fiscalizado');
$hojaActiva->setCellValue('AU1', 'Clave de Identificación Fiscal');
$hojaActiva->setCellValue('AV1', 'Calle');
$hojaActiva->setCellValue('AW1', 'Numero');
$hojaActiva->setCellValue('AX1', 'Codigo Postal');
$hojaActiva->setCellValue('AY1', 'Colonia');
$hojaActiva->setCellValue('AZ1', 'Entidad Federativa');
$hojaActiva->setCellValue('BA1', 'Pais');

$hojaActiva->setCellValue('BB1', 'Contribuyente: Denominación o Razón Social');
$hojaActiva->setCellValue('BC1', 'Clave RFC');
$hojaActiva->setCellValue('BD1', 'Número de Programa IMMEX');
$hojaActiva->setCellValue('BE1', 'Tipo de Domicilio');
$hojaActiva->setCellValue('BF1', 'Calle');
$hojaActiva->setCellValue('BG1', 'Numero');
$hojaActiva->setCellValue('BH1', 'Codigo Postal');
$hojaActiva->setCellValue('BI1', 'Colonia');
$hojaActiva->setCellValue('BJ1', 'Entidad Federativa');





// Puedes continuar agregando más columnas según tus necesidades

$fila = 2;

while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->getColumnDimension('A')->setWidth(20);
    $hojaActiva->setCellValue('A' . $fila, $rows['Tabla']);
    $hojaActiva->getColumnDimension('B')->setWidth(20);
    $hojaActiva->setCellValue('B' . $fila, $rows['NumParteS']);
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C' . $fila, $rows['CantidadS']);
    $hojaActiva->getColumnDimension('D')->setWidth(20);
    $hojaActiva->setCellValue('D' . $fila, $rows['UnidadMedidaComercializacionS']);
    $hojaActiva->getColumnDimension('E')->setWidth(20);
    $hojaActiva->setCellValue('E' . $fila, $rows['MontoDolaresS']);
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F' . $fila, $rows['FechaReciboS']);
    $hojaActiva->getColumnDimension('G')->setWidth(20);
    $hojaActiva->setCellValue('G' . $fila, $rows['NumFacturaControlReciboS']);
    $hojaActiva->getColumnDimension('H')->setWidth(20);
    $hojaActiva->setCellValue('H' . $fila, $rows['OrdenCompraS']);
    $hojaActiva->getColumnDimension('I')->setWidth(20);
    $hojaActiva->setCellValue('I' . $fila, $rows['IdentificadorSistemaCorporativoS']);



    $hojaActiva->getColumnDimension('J')->setWidth(20);
    $hojaActiva->setCellValue('J' . $fila, $rows['CantidadE']);
    $hojaActiva->getColumnDimension('K')->setWidth(20);
    $hojaActiva->setCellValue('K' . $fila, $rows['UnidadMedidaComercializacionE']);
    $hojaActiva->getColumnDimension('L')->setWidth(20);
    $hojaActiva->setCellValue('L' . $fila, $rows['MontoDolaresE']);
    $hojaActiva->getColumnDimension('M')->setWidth(20);
    $hojaActiva->setCellValue('M' . $fila, $rows['FechaReciboEntrada']);
    $hojaActiva->getColumnDimension('N')->setWidth(20);
    $hojaActiva->setCellValue('N' . $fila, $rows['NumFacturaControlReciboE']);
    $hojaActiva->getColumnDimension('O')->setWidth(20);
    $hojaActiva->setCellValue('O' . $fila, $rows['OrdenCompraE']);
    $hojaActiva->getColumnDimension('P')->setWidth(20);
    $hojaActiva->setCellValue('P' . $fila, $rows['IdentificadorSistemaCorporativoE']);


    $hojaActiva->getColumnDimension('Q')->setWidth(20);
    $hojaActiva->setCellValue('Q' . $fila, $rows['clienteC']);
    $hojaActiva->getColumnDimension('R')->setWidth(20);
    $hojaActiva->setCellValue('R' . $fila, $rows['NombreRazonSocialC']);
    $hojaActiva->getColumnDimension('S')->setWidth(20);
    $hojaActiva->setCellValue('S' . $fila, $rows['NacionalidadC']);
    $hojaActiva->getColumnDimension('T')->setWidth(20);
    $hojaActiva->setCellValue('T' . $fila, $rows['NumProgramaIMMEXC']);
    $hojaActiva->getColumnDimension('U')->setWidth(20);
    $hojaActiva->setCellValue('U' . $fila, $rows['ECEXC']);
    $hojaActiva->getColumnDimension('V')->setWidth(20);
    $hojaActiva->setCellValue('V' . $fila, $rows['EmpresaIndustrialC']);
    $hojaActiva->getColumnDimension('W')->setWidth(20);
    $hojaActiva->setCellValue('W' . $fila, $rows['RecintoFiscalizadoC']);
    $hojaActiva->getColumnDimension('X')->setWidth(20);
    $hojaActiva->setCellValue('X' . $fila, $rows['ClaveIdentificacionFiscalC']);
    $hojaActiva->getColumnDimension('Y')->setWidth(20);
    $hojaActiva->setCellValue('Y' . $fila, $rows['CalleC']);
    $hojaActiva->getColumnDimension('Z')->setWidth(20);
    $hojaActiva->setCellValue('Z' . $fila, $rows['NumeroC']);
    $hojaActiva->getColumnDimension('AA')->setWidth(20);
    $hojaActiva->setCellValue('AA' . $fila, $rows['CodigoPostalC']);
    $hojaActiva->getColumnDimension('AB')->setWidth(20);
    $hojaActiva->setCellValue('AB' . $fila, $rows['ColoniaC']);
    $hojaActiva->getColumnDimension('AC')->setWidth(20);
    $hojaActiva->setCellValue('AC' . $fila, $rows['EntidadFederativaC']);
    $hojaActiva->getColumnDimension('AD')->setWidth(20);
    $hojaActiva->setCellValue('AD' . $fila, $rows['PaisC']);

    $hojaActiva->getColumnDimension('AE')->setWidth(20);
    $hojaActiva->setCellValue('AE' . $fila, $rows['MaterialNumParte']);
    $hojaActiva->getColumnDimension('AF')->setWidth(50);
    $hojaActiva->setCellValue('AF' . $fila, $rows['DescripcionMaterial']);
    $hojaActiva->getColumnDimension('AG')->setWidth(20);
    $hojaActiva->setCellValue('AG' . $fila, $rows['MaterialFraccionArancelaria']);
    $hojaActiva->getColumnDimension('AH')->setWidth(20);
    $hojaActiva->setCellValue('AH' . $fila, $rows['MaterialUnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('AI')->setWidth(20);
    $hojaActiva->setCellValue('AI' . $fila, $rows['MaterialUnidadMedidaTIGIE']);
    $hojaActiva->getColumnDimension('AJ')->setWidth(20);
    $hojaActiva->setCellValue('AJ' . $fila, $rows['TipoMaterial']);

    $hojaActiva->getColumnDimension('AK')->setWidth(20);
    $hojaActiva->setCellValue('AK' . $fila, $rows['NumParte']);
    $hojaActiva->getColumnDimension('AL')->setWidth(20);
    $hojaActiva->setCellValue('AL' . $fila, $rows['DescripcionProducto']);
    $hojaActiva->getColumnDimension('AM')->setWidth(20);
    $hojaActiva->setCellValue('AM' . $fila, $rows['FraccionArancelaria']);
    $hojaActiva->getColumnDimension('AN')->setWidth(20);
    $hojaActiva->setCellValue('AN' . $fila, $rows['UnidadMedidaComercializacion']);
    $hojaActiva->getColumnDimension('AO')->setWidth(20);
    $hojaActiva->setCellValue('AO' . $fila, $rows['UnidadMedidaTIGIE']);

    $hojaActiva->getColumnDimension('AP')->setWidth(20);
    $hojaActiva->setCellValue('AP' . $fila, $rows['NumClaveIdentificacionEmpresaPro']);
    $hojaActiva->getColumnDimension('AQ')->setWidth(20);
    $hojaActiva->setCellValue('AQ' . $fila, $rows['NombreRazonSocialPro']);
    $hojaActiva->getColumnDimension('AR')->setWidth(20);
    $hojaActiva->setCellValue('AR' . $fila, $rows['NacionalidadPro']);
    $hojaActiva->getColumnDimension('AS')->setWidth(20);
    $hojaActiva->setCellValue('AS' . $fila, $rows['NumProgramaIMMEXPro']);
    $hojaActiva->getColumnDimension('AT')->setWidth(20);
    $hojaActiva->setCellValue('AT' . $fila, $rows['RecintoFiscalizadoPro']);
    $hojaActiva->getColumnDimension('AU')->setWidth(20);
    $hojaActiva->setCellValue('AU' . $fila, $rows['ClaveIdentificacionFiscalPro']);
    $hojaActiva->getColumnDimension('AV')->setWidth(20);
    $hojaActiva->setCellValue('AV' . $fila, $rows['CallePro']);
    $hojaActiva->getColumnDimension('AW')->setWidth(20);
    $hojaActiva->setCellValue('AW' . $fila, $rows['NumeroPro']);
    $hojaActiva->getColumnDimension('AX')->setWidth(20);
    $hojaActiva->setCellValue('AX' . $fila, $rows['CodigoPostalPro']);
    $hojaActiva->getColumnDimension('AY')->setWidth(20);
    $hojaActiva->setCellValue('AY' . $fila, $rows['ColoniaPro']);
    $hojaActiva->getColumnDimension('AZ')->setWidth(20);
    $hojaActiva->setCellValue('AZ' . $fila, $rows['EntidadFederativaPro']);
    $hojaActiva->getColumnDimension('BA')->setWidth(20);
    $hojaActiva->setCellValue('BA' . $fila, $rows['PaisPro']);

    $hojaActiva->getColumnDimension('BB')->setWidth(20);
    $hojaActiva->setCellValue('BB' . $fila, $rows['DenominacionRazonSocial']);
    $hojaActiva->getColumnDimension('BC')->setWidth(20);
    $hojaActiva->setCellValue('BC' . $fila, $rows['ClaveRFC']);
    $hojaActiva->getColumnDimension('BD')->setWidth(20);
    $hojaActiva->setCellValue('BD' . $fila, $rows['NumProgramaIMMEX']);
    $hojaActiva->getColumnDimension('BE')->setWidth(20);
    $hojaActiva->setCellValue('BE' . $fila, $rows['TipoDomicilio']);
    $hojaActiva->getColumnDimension('BF')->setWidth(20);
    $hojaActiva->setCellValue('BF' . $fila, $rows['CallePlanta']);
    $hojaActiva->getColumnDimension('BG')->setWidth(20);
    $hojaActiva->setCellValue('BG' . $fila, $rows['NumeroPlanta']);
    $hojaActiva->getColumnDimension('BH')->setWidth(20);
    $hojaActiva->setCellValue('BH' . $fila, $rows['CodigoPostal']);
    $hojaActiva->getColumnDimension('BI')->setWidth(20);
    $hojaActiva->setCellValue('BI' . $fila, $rows['ColoniaPlanta']);
    $hojaActiva->getColumnDimension('BJ')->setWidth(20);
    $hojaActiva->setCellValue('BJ' . $fila, $rows['EntidadFederativa']);





    // Continúa con el resto de las columnas según tus necesidades
    $fila++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte-Interfas-salida.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = IOFactory::createWriter($excel, 'Xlsx'); // 'xlsx' cambió a 'Xlsx'
$objWriter->save('php://output');

exit;
