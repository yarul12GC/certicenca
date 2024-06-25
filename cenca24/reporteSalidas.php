<?php
include 'startSession.php';
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Consulta de Salidas y Aduanas</title>
    <?php
    include 'vistas/cabeza.php';
    ?>

</head>

<body>
    <section class="contenedor">
        <h3><strong>Reporte de Salidas y Aduanas</strong></h3><br>

        <button type="button" class="btn btn-success" onclick="mostrarInterfazSalida()">Interfaz Salida</button>
        <button type="button" class="btn btn-success" onclick="mostrarAduanaSalida()">Aduana Salida</button><br>
        <div id="tabla_interfase">

            <?php
            $sql_interfase = "SELECT 
                        'Interfasesalidas' AS Tabla,
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


            $result_interfase = $conn->query($sql_interfase);

            $interfase_salidas = array();
            while ($row = $result_interfase->fetch_assoc()) {
                $interfase_salidas[] = $row;
            }

            if (count($interfase_salidas) > 0) {
                echo "<div><br>
                        <h4>Reporte Interfase Salidas</h4><br>
                         <a href='ExcelInterfazSalidasReporte.php' class='nuevo'>
                            <i class='fas fa-file-excel mr-1'></i> Generar Excel
                            </a>
                            <br>
                        <table  class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    <th>Salida ID</th>
                                    <th>Material</th>
                                    <th>Producto</th>
                                    <th>Monto Dolares</th>
                                    <th>Fecha del Recibo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        <tbody>";

                foreach ($interfase_salidas as $row) {
                    echo "<tr>
                            <td>" . $row["Tabla"] . "</td>
                            <td>" . $row["NumParteS"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["DescripcionProducto"] . "</td>
                            <td>" . $row["MontoDolaresS"] . "</td>
                            <td>" . $row["FechaReciboS"] . "</td> <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase" . $row["InterfaseSalidaID"] . "'>Ver Detalles</button></td>
                        </tr>";

                    echo "<div class='modal fade' id='modal_interfase" . $row["InterfaseSalidaID"] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered modal-lg' style='max-width: 90%;'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalLabel'>Detalles de la Salida</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                      <div class='modal-body row'>
                                         <div class='col-md-4'>
                                         <div class='form-group'>
                                                <label>Número de parte:</label>
                                                <div>" . $row["NumParteS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Cantidad Salida:</label>
                                                <div>" . $row["CantidadS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de Medida de Comercialización:</label>
                                                <div>" . $row["UnidadMedidaComercializacionS"] . "</div>
                                            </div>    
                                                                                                                       
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Monto en Dolares:</label>
                                                <div>" . $row["MontoDolaresS"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Fecha de Recibo:</label>
                                                <div>" . $row["FechaReciboS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Numero de Factura Control:</label>
                                                <div>" . $row["NumFacturaControlReciboS"] . "</div>
                                            </div>
                                                                  
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Orden de Compra:</label>
                                                <div>" . $row["OrdenCompraS"] . "</div>
                                            </div>  
                                           <div class='form-group'>
                                                <label>Identificador del SistemaCorporativo:</label>
                                                <div>" . $row["IdentificadorSistemaCorporativoS"] . "</div>
                                            </div>                                         
                                        </div>
                                    </div> 
                                    <div class='modal-body row'><hr>
                                      <h5> <strong>Descripción de la entrada</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Cantidad:</label>
                                                <div>" . $row["CantidadE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de Medida de Comercialización:</label>
                                                <div>" . $row["UnidadMedidaComercializacionE"] . "</div>
                                            </div>    
                                            <div class='form-group'>
                                                <label>Monto en Dolares:</label>
                                                <div>" . $row["MontoDolaresE"] . "</div>
                                            </div>                                                                            
                                        </div>

                                        <div class='col-md-4'>
                                            
                                            <div class='form-group'>
                                                <label>Fecha de Recibo:</label>
                                                <div>" . $row["FechaReciboEntrada"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Numero de Factura Control:</label>
                                                <div>" . $row["NumFacturaControlReciboE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Orden de Compra:</label>
                                                <div>" . $row["OrdenCompraE"] . "</div>
                                            </div>                        
                                        </div>
                                        <div class='col-md-4'>
                                           <div class='form-group'>
                                                <label>Identificador del SistemaCorporativo:</label>
                                                <div>" . $row["IdentificadorSistemaCorporativoE"] . "</div>
                                            </div>                                         
                                        </div>
                                    </div>

                                     <div class='modal-body row'><hr>
                                      <h5> <strong>Cliente</strong></h5><hr>
                                        <div class='col-md-4'>
                                        
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["clienteC"] . "</div>
                                            </div>
                                              <div class='form-group'>
                                                <label>Nombre, denominación o razón social.:</label>
                                                <div>" . $row["NombreRazonSocialC"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Nacionalidad:</label>
                                                <div>" . $row["NacionalidadC"] . "</div>
                                            </div>                                                                                                              
                                        </div>

                                        <div class='col-md-4'>
                                               <div class='form-group'>
                                                <label>Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEXC"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>ECEX:</label>
                                                <div>" . $row["ECEXC"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Empresa de la industria automotriz:</label>
                                                <div>" . $row["EmpresaIndustrialC"] . "</div>
                                            </div>                                                                                                                          
                                        </div>
                                        <div class='col-md-4'>
                                          <div class='form-group'>
                                                <label>Recinto Fiscalizado:</label>
                                                <div>" . $row["RecintoFiscalizadoC"] . "</div>
                                            </div>
                                              <div class='form-group'>
                                                <label>Clave de Identificación Fiscal:</label>
                                                <div>" . $row["ClaveIdentificacionFiscalC"] . "</div>
                                            </div>
                                            
                                             <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CalleC"] . ', ' . $row["NumeroC"] . ', ' . $row["CodigoPostalC"] . ', ' . $row["ColoniaC"] . ', ' . $row["EntidadFederativaC"] . ', ' . $row["PaisC"] . "</div>
                                            </div> 
                                        </div>
                                    </div>
                                      <div class='modal-body row'><hr>
                                      <h5> <strong>Materiales</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["MaterialNumParte"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Descripción del material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>                                                                                
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Fracción arancelaria:</label>
                                                <div>" . $row["MaterialFraccionArancelaria"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de medida de comercialización:</label>
                                                <div>" . $row["MaterialUnidadMedidaComercializacion"] . "</div>
                                            </div>
                                                                          
                                        </div>
                                        <div class='col-md-4'>
                                           <div class='form-group'>
                                                <label>Unidad de medida de la TIGIE:</label>
                                                <div>" . $row["MaterialUnidadMedidaTIGIE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tipo de material:</label>
                                                <div>" . $row["TipoMaterial"] . "</div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class='modal-body row'><hr>
                                      <h5> <strong>Productos</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["NumParte"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Descripción del producto:</label>
                                                <div>" . $row["DescripcionProducto"] . "</div>
                                            </div>                                                                                
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Fracción arancelaria:</label>
                                                <div>" . $row["FraccionArancelaria"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de medida de comercialización:</label>
                                                <div>" . $row["UnidadMedidaComercializacion"] . "</div>
                                            </div>
                                                                          
                                        </div>
                                         <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Unidad de Medida TIGIE:</label>
                                                <div>" . $row["UnidadMedidaTIGIE"] . "</div>
                                            </div>                                
                                        </div>
                                    </div>

                                    
                                     <div class='modal-body row'><hr>
                                      <h5> <strong>Proveedor</strong></h5><hr>
                                        <div class='col-md-4'>
                                        
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["NumClaveIdentificacionEmpresaPro"] . "</div>
                                            </div>
                                              <div class='form-group'>
                                                <label>Nombre, denominación o razón social.:</label>
                                                <div>" . $row["NombreRazonSocialPro"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Nacionalidad:</label>
                                                <div>" . $row["NacionalidadPro"] . "</div>
                                            </div>                                                                                                              
                                        </div>

                                        <div class='col-md-4'>
                                               <div class='form-group'>
                                                <label>Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEXPro"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Recinto Fiscalizado:</label>
                                                <div>" . $row["RecintoFiscalizadoPro"] . "</div>
                                            </div>
                                              <div class='form-group'>
                                                <label>Clave de Identificación Fiscal:</label>
                                                <div>" . $row["ClaveIdentificacionFiscalPro"] . "</div>
                                            </div>                                                                                                             
                                        </div>
                                        <div class='col-md-4'>                                                                                  
                                             <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CallePro"] . ', ' . $row["NumeroPro"] . ', ' . $row["CodigoPostalPro"] . ', ' . $row["ColoniaPro"] . ', ' . $row["EntidadFederativaPro"] . ', ' . $row["PaisPro"] . "</div>
                                            </div> 
                                        </div>
                                    </div>

                                     
                                    <div class='modal-body row'><hr>
                                      <h5><strong>Contribuyente</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Denominación o Razón Social:</label>
                                                <div>" . $row["DenominacionRazonSocial"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Clave RFC:</label>
                                                <div>" . $row["ClaveRFC"] . "</div>
                                            </div>                                                                                
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Número de Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEX"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tipo de Domicilio:</label>
                                                <div>" . $row["TipoDomicilio"] . "</div>
                                            </div>
                                                                          
                                        </div>
                                         <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CallePlanta"] . ', ' . $row["NumeroPlanta"] . ', ' . $row["CodigoPostal"] . ', ' . $row["ColoniaPlanta"] . ', ' . $row["EntidadFederativa"] . "</div>
                                            </div>                               
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "No se encontraron resultados para Interfase Entradas";
            }
            ?>
        </div>

        <div id="tabla_aduana" style="display: none;">

            <?php

            // Consulta SQL para obtener los datos de aduanaSalidas y sus detalles
            $sql_aduana = "SELECT 
                            'Aduana Salidas' AS Tabla,
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

            $result_aduana = $conn->query($sql_aduana);

            $aduana_entries = array();
            while ($row = $result_aduana->fetch_assoc()) {
                $aduana_entries[] = $row;
            }

            if (count($aduana_entries) > 0) {
                echo "<div><br>
                        <h4>Reporte Aduana Salidas</h4><br>
                         <a href='ExcelAduanSalidasReporte.php' class='nuevo'>
                            <i class='fas fa-file-excel mr-1'></i> Generar Excel
                            </a>
                            <br>
                        <table class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    <th>SalidaID ID</th>
                                    <th>Material</th>
                                    <th>No. Pedimento</th>
                                    <th>Clave de pedimento</th>                                 
                                    <th>FechaPedimento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>";

                foreach ($aduana_entries as $row) {
                    echo "<tr>
                            <td>" . $row["Tabla"] . "</td>
                            <td>" . $row["AduanaSalidaID"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["NumeroPedimentoAS"] . "</td>
                            <td>" . $row["ClavePedimentoAS"] . "</td>
                            <td>" . $row["FechaPedimentoAS"] . "</td>
                            <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_aduana" . $row["AduanaSalidaID"] . "'>Ver Detalles</button></td>
                        </tr>";


                    echo "<div class='modal fade' id='modal_aduana" . $row["AduanaSalidaID"] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered modal-lg' style='max-width: 90%;'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalLabel'>Detalles Aduanas Salidas</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body row'>
                                       <div class='col-md-4'>
                                         <div class='form-group'>
                                                <label>Número Pedimento:</label>
                                                <div>" . $row["NumeroPedimentoAS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Clave de Pedimento:</label>
                                                <div>" . $row["ClavePedimentoAS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Fecha de Pedimento:</label>
                                                <div>" . $row["FechaPedimentoAS"] . "</div>
                                            </div>    
                                            <div class='form-group'>
                                                <label>Cantidad de Salida:</label>
                                                <div>" . $row["CantidadSalidaAd"] . "</div>
                                            </div>                                                                       
                                        </div>

                                        <div class='col-md-4'>                                     
                                            <div class='form-group'>
                                                <label>Pais de Origen de la Mercancia:</label>
                                                <div>" . $row["PaisOrigenMercanciaAS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tipo de Impuesto:</label>
                                                <div>" . $row["tipoImpuestoAS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tasa de Impuesto:</label>
                                                <div>" . $row["TasaDeImpuestoAS"] . "</div>
                                            </div>  
                                           <div class='form-group'>
                                                <label>Factura Comercial:</label>
                                                <div>" . $row["FacturaComercialAS"] . "</div>
                                            </div>                  
                                        </div>
                                        <div class='col-md-4'>
                                            
                                            <div class='form-group'>
                                                <label>Aviso Electronico:</label>
                                                <div>" . $row["AvisoElectronicoAS"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Fecha de Cruce:</label>
                                                <div>" . $row["FacturaComercialAS"] . "</div>
                                            </div>                                        
                                        </div>
                                    </div> 


                                    <div class='modal-body row'><hr>
                                      <h5> <strong>Descripción de la entrada</strong></h5><hr>
                                          <div class='col-md-4'>
                                         <div class='form-group'>
                                                <label>Número Pedimento:</label>
                                                <div>" . $row["NumeroPedimentoAE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Clave de Aduana:</label>
                                                <div>" . $row["ClaveAduanaAE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Patente:</label>
                                                <div>" . $row["patenteAE"] . "</div>
                                            </div>    
                                            <div class='form-group'>
                                                <label>Número de Documento:</label>
                                                <div>" . $row["NumeroDocAE"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Clave de Pedimento:</label>
                                                <div>" . $row["ClavePedimentoAE"] . "</div>
                                            </div>                                                                      
                                        </div>

                                        <div class='col-md-4'>                                     
                                            
                                            <div class='form-group'>
                                                <label>Fecha de Pedimento:</label>
                                                <div>" . $row["FechaPedimentoAE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Cantidad de Entrada:</label>
                                                <div>" . $row["CantidadEntradaAduanaAE"] . "</div>
                                            </div>  
                                           <div class='form-group'>
                                                <label>Pais de Origen de la Mercancia:</label>
                                                <div>" . $row["PaisOrigenMercanciaAE"] . "</div>
                                            </div>    
                                            <div class='form-group'>
                                                <label>Tipo de Impuesto:</label>
                                                <div>" . $row["tipoImpuestoAE"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Tasa de Impuesto:</label>
                                                <div>" . $row["TasaDeImpuestoAE"] . "</div>
                                            </div>                
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Factura Comercial:</label>
                                                <div>" . $row["FacturaComercialAE"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Aviso Electronico:</label>
                                                <div>" . $row["AvisoElectronicoAE"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Fecha de Cruce:</label>
                                                <div>" . $row["FechaCruceAE"] . "</div>
                                            </div>                                        
                                        </div>
                                    </div>
                                     <div class='modal-body row'><hr>
                                      <h5> <strong>Cliente</strong></h5><hr>
                                        <div class='col-md-4'>
                                        
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["clienteCa"] . "</div>
                                            </div>
                                              <div class='form-group'>
                                                <label>Nombre, denominación o razón social:</label>
                                                <div>" . $row["NombreRazonSocialCa"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Nacionalidad:</label>
                                                <div>" . $row["NacionalidadCa"] . "</div>
                                            </div>                                                                                                              
                                        </div>

                                        <div class='col-md-4'>
                                               <div class='form-group'>
                                                <label>Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEXCa"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>ECEX:</label>
                                                <div>" . $row["ECEXCa"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Empresa de la industria automotriz:</label>
                                                <div>" . $row["EmpresaIndustrialCa"] . "</div>
                                            </div>                                                                                                                          
                                        </div>
                                        <div class='col-md-4'>
                                          <div class='form-group'>
                                                <label>Recinto Fiscalizado:</label>
                                                <div>" . $row["RecintoFiscalizadoCa"] . "</div>
                                            </div>
                                              <div class='form-group'>
                                                <label>Clave de Identificación Fiscal:</label>
                                                <div>" . $row["ClaveIdentificacionFiscalCa"] . "</div>
                                            </div>
                                            
                                             <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CalleCa"] . ', ' . $row["NumeroCa"] . ', ' . $row["CodigoPostalCa"] . ', ' . $row["ColoniaCa"] . ', ' . $row["EntidadFederativaCa"] . ', ' . $row["PaisCa"] . "</div>
                                            </div> 
                                        </div>
                                    </div>
                                      <div class='modal-body row'><hr>
                                      <h5> <strong>Materiales</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["MaterialNumParte"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Descripción del material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>                                                                                
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Fracción arancelaria:</label>
                                                <div>" . $row["MaterialFraccionArancelaria"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de medida de comercialización:</label>
                                                <div>" . $row["MaterialUnidadMedidaComercializacion"] . "</div>
                                            </div>
                                                                          
                                        </div>
                                        <div class='col-md-4'>
                                           <div class='form-group'>
                                                <label>Unidad de medida de la TIGIE:</label>
                                                <div>" . $row["MaterialUnidadMedidaTIGIE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tipo de material:</label>
                                                <div>" . $row["TipoMaterial"] . "</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-body row'><hr>
                                      <h5> <strong>Productos</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Número o clave de identificación:</label>
                                                <div>" . $row["NumParte"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Descripción del producto:</label>
                                                <div>" . $row["DescripcionProducto"] . "</div>
                                            </div>                                                                                
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Fracción arancelaria:</label>
                                                <div>" . $row["FraccionArancelaria"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de medida de comercialización:</label>
                                                <div>" . $row["UnidadMedidaComercializacion"] . "</div>
                                            </div>
                                                                          
                                        </div>
                                         <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Unidad de Medida TIGIE:</label>
                                                <div>" . $row["UnidadMedidaTIGIE"] . "</div>
                                            </div>                                
                                        </div>
                                    </div>
                                    <div class='modal-body row'><hr>
                                      <h5> <strong>Proveedor</strong></h5><hr>
                                          <div class='col-md-4'>
                                         <div class='form-group'>
                                                <label>Número o Clave de Identificación:</label>
                                                <div>" . $row["NumClaveIdentificacionEmpresaProb"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Nombre o Razón Social:</label>
                                                <div>" . $row["NombreRazonSocialProb"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Nacionalidad:</label>
                                                <div>" . $row["NacionalidadProb"] . "</div>
                                            </div>    
                                                                                                             
                                        </div>

                                        <div class='col-md-4'>                                     
                                              <div class='form-group'>
                                                <label>Número de Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEXProb"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Recinto Fiscalizado:</label>
                                                <div>" . $row["RecintoFiscalizadoProb"] . "</div>
                                            </div>   
                                            <div class='form-group'>
                                                <label>Clave de Identificación Fiscal:</label>
                                                <div>" . $row["ClaveIdentificacionFiscalProb"] . "</div>
                                            </div> 
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CalleProb"] . ', ' . $row["NumeroProb"] . ', ' . $row["CodigoPostalProb"] . ', ' . $row["ColoniaProb"] . ', ' . $row["EntidadFederativaProb"] . ', ' . $row["PaisProb"] . "</div>
                                            </div>                                  
                                        </div>
                                    </div>
                                        <div class='modal-body row'><hr>
                                      <h5> <strong>Submanufactura o Submaquila</strong></h5><hr>
                                          <div class='col-md-4'>
                                         <div class='form-group'>
                                                <label>Número o Clave de Identificación:</label>
                                                <div>" . $row["NumClaveIdentificacionSub"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Nombre o Razón Social:</label>
                                                <div>" . $row["NombreRazonSocialSub"] . "</div>
                                            </div>
                                             
                                                                                                             
                                        </div>

                                        <div class='col-md-4'> 
                                            <div class='form-group'>
                                                <label>Número de Autorización:</label>
                                                <div>" . $row["NumAutorizacionSESub"] . "</div>
                                            </div>                                       
                                              <div class='form-group'>
                                                <label>Fecha de Autorización:</label>
                                                <div>" . $row["FechaAutorizacionSub"] . "</div>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CalleSub"] . ', ' . $row["NumeroSub"] . ', ' . $row["CodigoPostalSub"] . ', ' . $row["ColoniaSub"] . ', ' . $row["EntidadFederativaSub"] . ', ' . $row["PaisSub"] . "</div>
                                            </div>                                  
                                        </div>
                                    </div>
                                          <div class='modal-body row'><hr>
                                      <h5><strong>Contribuyente</strong></h5><hr>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Denominación o Razón Social:</label>
                                                <div>" . $row["DenominacionRazonSocial"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Clave RFC:</label>
                                                <div>" . $row["ClaveRFC"] . "</div>
                                            </div>                                                                                
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Número de Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEX"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tipo de Domicilio:</label>
                                                <div>" . $row["TipoDomicilio"] . "</div>
                                            </div>
                                                                          
                                        </div>
                                         <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Dirección:</label>
                                                 <div>" . $row["CallePlanta"] . ', ' . $row["NumeroPlanta"] . ', ' . $row["CodigoPostal"] . ', ' . $row["ColoniaPlanta"] . ', ' . $row["EntidadFederativa"] . "</div>
                                            </div>                               
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "No se encontraron resultados para Aduana Entradas";
            }
            ?>

        </div>
    </section>

    <footer>
        <?php
        include 'vistas/footer.php';
        ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
<script>
    function mostrarInterfazSalida() {
        document.getElementById("tabla_interfase").style.display = "block";
        document.getElementById("tabla_aduana").style.display = "none";
    }

    function mostrarAduanaSalida() {
        document.getElementById("tabla_interfase").style.display = "none";
        document.getElementById("tabla_aduana").style.display = "block";
    }
</script>