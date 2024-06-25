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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Reportes Entradas</title>
    <?php
    include 'vistas/cabeza.php';
    ?>
   
</head>

<body>
    <section class="contenedor">
            <h3><strong>Reportes de Entradas</strong></h3>
            <br>
            <button type="button" class="btn btn-success" onclick="mostrarInterfazEntrada()">Interfaz Entrada</button>
            <button type="button" class="btn btn-success" onclick="mostrarEntradaAduana()">Entrada Aduana</button>
            <br>
            <div id="tabla_interfase">

            <?php
            $sql_interfase = "SELECT 
                'Interfaseentradas' AS Tabla,
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
                cl.NumClaveIdentificacion AS  NumClaveIdentificacionCL, 	
                cl.NombreRazonSocial AS  NombreRazonSocialCL,	
                cl.Nacionalidad AS 	NacionalidadCL,
                cl.NumProgramaIMMEX AS 	NumProgramaIMMEXCL,
                cl.ECEX AS 	ECEXCL,
                cl.EmpresaIndustrial AS EmpresaIndustrialCL,	
                cl.RecintoFiscalizado AS RecintoFiscalizadoCL,	
                cl.ClaveIdentificacionFiscal AS laveIdentificacionFiscalCL,	
                cl.Calle AS CalleCL,	
                cl.Numero AS NumeroCL,	
                cl.CodigoPostal AS 	CodigoPostalCL,
                cl.Colonia AS ColoniaCL,	
                cl.EntidadFederativa AS EntidadFederativaCL,	
                cl.Pais AS PaisCL,

                pv.NombreRazonSocial AS Proveedor,
                pv.NumClaveIdentificacionEmpresa AS NumClaveIdentificacionEmpresaPV,	
                pv.Nacionalidad	AS NacionalidadPV,
                pv.NumProgramaIMMEX	AS NumProgramaIMMEXPV,
                pv.RecintoFiscalizado AS RecintoFiscalizadoPV,
                pv.ClaveIdentificacionFiscal AS ClaveIdentificacionFiscalPV,
                pv.Calle AS CallePV,
                pv.Numero AS NumeroPV,
                pv.CodigoPostal	AS CodigoPostalPV,
                pv.Colonia	AS ColoniaPV,
                pv.EntidadFederativa AS EntidadFederativaPV,
                pv.Pais	AS PaisPV 
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

            $result_interfase = $conn->query($sql_interfase);

            $interfase_entries = array();
            while ($row = $result_interfase->fetch_assoc()) {
                $interfase_entries[] = $row;
            }

            if (count($interfase_entries) > 0) {
                echo "<div>
                        <br>
                        <h4>Tabla Interfase Entradas</h4>
                        <br>
                    <a href='excelINEntradas.php' class='nuevo'>
                        <i class='fas fa-file-excel mr-1'></i> Generar Reporte
                    </a>
                        <br>
                        <table  class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    <th>Entrada ID</th>
                                    <th>Material</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Unidad Medida Comercializacion</th>
                                    <th>Monto Dolares</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>";

                foreach ($interfase_entries as $row) {
                    echo "<tr>
                            <td>" . $row["Tabla"] . "</td>
                            <td>" . $row["InterfaseEntradaID"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["DescripcionProductoP"] . "</td>
                            <td>" . $row["Cantidad"] . "</td>
                            <td>" . $row["UnidadMedidaComercializacion"] . "</td>
                            <td>" . $row["MontoDolares"] . "</td>
                            <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase" . $row["InterfaseEntradaID"] . "'>Ver Detalles</button></td>
                        </tr>";


                        echo "<div class='modal fade' id='modal_interfase" . $row["InterfaseEntradaID"] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered modal-lg' style='max-width: 90%;'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalLabel'>Detalles de la Entrada</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body row'>
                                    <div class='row'>
                                    <hr><h5><strong>Descripcipcion de Entradas</strong></h5><hr>
                                        
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Interfase Entrada ID:</label>
                                                <div>" . $row["InterfaseEntradaID"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Producto:</label>
                                                <div>" . $row["DescripcionProductoP"] . "</div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Cantidad:</label>
                                                <div>" . $row["Cantidad"] . "</div>
                                            </div> 
                                            <div class='form-group'>
                                                <label>Unidad Medida Comercializacion:</label>
                                                <div>" . $row["UnidadMedidaComercializacion"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Monto Dolares:</label>
                                                <div>" . $row["MontoDolares"] . "</div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Fecha Recibo:</label>
                                                <div>" . $row["FechaRecibo"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Proveedor:</label>
                                                <div>" . $row["Proveedor"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Cliente ID:</label>
                                                <div>" . $row["Cliente"] . "</div>
                                            </div>
                                        </div>

                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Número Factura Control Recibo:</label>
                                                <div>" . $row["NumFacturaControlRecibo"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Orden Compra:</label>
                                                <div>" . $row["OrdenCompra"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Identificador Sistema Corporativo:</label>
                                                <div>" . $row["IdentificadorSistemaCorporativo"] . "</div>
                                            </div>
                                     </div>
                                    </div>
                                    <div class='row'>
                                    <hr><h5><strong>Descripcipcion del Material</strong></h5><hr>

                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>NumParte</label>
                                                <div>" . $row["NumParte"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>FraccionArancelaria:</label>
                                                <div>" . $row["FraccionArancelaria"] . "</div>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Unidad Medida Comercializacion:</label>
                                                <div>" . $row["UnidadMedidaComercializacion"] . "</div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>UnidadMedidaTIGIE:</label>
                                                <div>" . $row["UnidadMedidaTIGIE"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>TipoMaterial:</label>
                                                <div>" . $row["TipoMaterial"] . "</div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Proveedor:</label>
                                                <div>" . $row["Proveedor"] . "</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                    <hr><h5><strong>Producto:</strong></h5><hr>
                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>NumParteP:</label>
                                                <div>" . $row["NumParteP"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Descripcion de Producto:</label>
                                                <div>" . $row["DescripcionProductoP"] . "</div>
                                        </div>
    
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Fraccion Arancelaria:</label>
                                                <div>" . $row["FraccionArancelariaP"] . "</div>
                                        </div>
                                        
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Unidad de Medida:</label>
                                                <div>" . $row["UnidadMedidaComercializacionP"] . "</div>
                                        </div>
                                        
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Unidad Medida TIGIEP:</label>
                                                <div>" . $row["UnidadMedidaTIGIEP"] . "</div>
                                        </div>
                                        </div>
                                    </div>

                                    <div class='row'>
                                    <hr><h5><strong>Contribuyente</strong></h5><hr>
                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Contribuyente:</label>
                                                <div>" . $row["Contribuyente"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Clave RFC:</label>
                                                <div>" . $row["ClaveRFCc"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>NumProgramaIMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEXC"] . "</div>
                                        </div>
                                         
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>TipoDomicilio:</label>
                                                <div>" . $row["TipoDomicilioC"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Calle :</label>
                                                <div>" . $row["CallePlantaC"] . "</div>
                                        </div>
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Numero Planta:</label>
                                                <div>" . $row["NumeroPlantaC"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Codigo Postal:</label>
                                                <div>" . $row["CodigoPostalC"] . "</div>
                                        </div>
                                         
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Colonia Planta:</label>
                                                <div>" . $row["ColoniaPlantaC"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Entidad Federativa:</label>
                                                <div>" . $row["EntidadFederativaC"] . "</div>
                                        </div>
                                        
                                        </div>
                                    </div>

                                    <div class='row'>
                                    <hr><h5><strong>Datos del Cliente</strong></h5><hr>
                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Cliente:</label>
                                                <div>" . $row["Cliente"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>NumClave Identificacion</label>
                                                <div>" . $row["NumClaveIdentificacionCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Nacionalidad:</label>
                                                <div>" . $row["NacionalidadCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Programa IMMEX:</label>
                                                <div>" . $row["NumProgramaIMMEXCL"] . "</div>
                                        </div>
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>ECEX:</label>
                                                <div>" . $row["ECEXCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Empresa Industrial:</label>
                                                <div>" . $row["EmpresaIndustrialCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Recinto Fiscalizado:</label>
                                                <div>" . $row["RecintoFiscalizadoCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Clave Identificacion Fiscal:</label>
                                                <div>" . $row["laveIdentificacionFiscalCL"] . "</div>
                                        </div>
                                        </div>


                                        <div class='col-md-3'>
                                        <div class='form-group'>
                                                <label>Calle:</label>
                                                <div>" . $row["CalleCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Numero:</label>
                                                <div>" . $row["NumeroCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Codigo Postal:</label>
                                                <div>" . $row["CodigoPostalCL"] . "</div>
                                        </div>
                                         <div class='form-group'>
                                                <label>Colonia:</label>
                                                <div>" . $row["ColoniaCL"] . "</div>
                                        </div>
                                        </div>


                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                    <label>Entidad Federativa:</label>
                                                    <div>" . $row["EntidadFederativaCL"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                    <label>Pais:</label>
                                                    <div>" . $row["PaisCL"] . "</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                    <hr><h5><strong>Datos del Proveedor</strong></h5><hr>

                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                        <label>Proveedor:</label>
                                                        <div>" . $row["Proveedor"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>Clave Identificacion:</label>
                                                        <div>" . $row["NumClaveIdentificacionEmpresaPV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>Nacionalidad:</label>
                                                        <div>" . $row["NacionalidadPV"] . "</div>
                                                </div>
                                            </div>


                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                        <label>Programa IMMEX:</label>
                                                        <div>" . $row["NumProgramaIMMEXPV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>Recinto Fiscalizado:</label>
                                                        <div>" . $row["RecintoFiscalizadoPV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>Clave Identificacion:</label>
                                                        <div>" . $row["ClaveIdentificacionFiscalPV"] . "</div>
                                                </div>
                                            </div>

                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                        <label>Calle:</label>
                                                        <div>" . $row["CallePV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>Numero:</label>
                                                        <div>" . $row["NumeroPV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>CodigoPostal:</label>
                                                        <div>" . $row["CodigoPostalPV"] . "</div>
                                                </div>
                                            </div>

                                            <div class='col-md-3'>
                                                <div class='form-group'>
                                                        <label>Colonia:</label>
                                                        <div>" . $row["ColoniaPV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>Entidad Federativa:</label>
                                                        <div>" . $row["EntidadFederativaPV"] . "</div>
                                                </div>
                                                <div class='form-group'>
                                                        <label>PaisP:</label>
                                                        <div>" . $row["PaisPV"] . "</div>
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

            // Consulta SQL para obtener los datos de aduanaEntradas y sus detalles
            $sql_aduana = "SELECT 
            'AduanaEntradas' AS Tabla,
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
            productos pr ON ae.ProductoID = pr.ProductoID; ";

            $result_aduana = $conn->query($sql_aduana);

            $aduana_entries = array();
            while ($row = $result_aduana->fetch_assoc()) {
                $aduana_entries[] = $row;
            }

            if (count($aduana_entries) > 0) {
                echo "<div>
                        <br>
                        <h4>Tabla Aduana Entradas</h4>
                        <br>
                        <a href='Excelentradasadn.php' class='nuevo'>
                            <i class='fas fa-file-excel mr-1'></i> Generar Reporte
                        </a>
                            <br>
                        <table class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    <th>Material</th>
                                    <th>Pedimento</th>
                                    <th>ClaveAduana</th>
                                    <th>patente</th>
                                    <th>ClavePedimento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>";

                foreach ($aduana_entries as $row) {
                    echo "<tr>
                            <td>" . $row["Tabla"] . "</td>
                            <td>" . $row["m_DescripcionMaterial"] . "</td>
                            <td>" . $row["ae_NumeroPedimento"] . "</td>
                            <td>" . $row["ae_ClaveAduana"] . "</td>
                            <td>" . $row["ae_patente"] . "</td>
                            <td>" . $row["ae_ClavePedimento"] . "</td>
                            <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_aduana" . $row["ae_AduanaEntradaID"] . "'>Ver Detalles</button></td>
                        </tr>";

                        echo "<div class='modal fade' id='modal_aduana" . $row["ae_AduanaEntradaID"] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered modal-lg' style='max-width: 90%;'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='modalLabel'>Detalles de la Entrada</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body row'>
                                <div class='row'>
                                <hr>
                                <h5><strong>Datos de Entrada</strong></h5>
                                <hr>
                            
                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label>AduanaEntradaID</label>
                                        <div>" . $row["ae_AduanaEntradaID"] . "</div>
                                    </div>
                                    <div class='form-group'>
                                        <label>DescripcionMaterial</label>
                                        <div>" . $row["m_DescripcionMaterial"] . "</div>
                                    </div>
                                    <div class='form-group'>
                                        <label>DescripcionProducto</label>
                                        <div>" . $row["pr_DescripcionProducto"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>NumeroPedimento</label>
                                        <div>" . $row["ae_NumeroPedimento"] . "</div>
                                    </div>
                            
                                   
                                </div>
                            
                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label>NumeroDoc</label>
                                        <div>" . $row["ae_NumeroDoc"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>ClavePedimento</label>
                                        <div>" . $row["ae_ClavePedimento"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>FechaPedimento</label>
                                        <div>" . $row["ae_FechaPedimento"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>CantidadEntradaAduana</label>
                                        <div>" . $row["ae_CantidadEntradaAduana"] . "</div>
                                    </div>
                                </div>
                            
                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label>PaisOrigenMercancia</label>
                                        <div>" . $row["ae_PaisOrigenMercancia"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>tipoImpuesto</label>
                                        <div>" . $row["ae_tipoImpuesto"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>TasaDeImpuesto</label>
                                        <div>" . $row["ae_TasaDeImpuesto"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>FacturaComercial</label>
                                        <div>" . $row["ae_FacturaComercial"] . "</div>
                                    </div>
                                </div>
                            
                                <div class='col-md-3'>
                                    <div class='form-group'>
                                        <label>AvisoElectronico</label>
                                        <div>" . $row["ae_AvisoElectronico"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>FechaCruce</label>
                                        <div>" . $row["ae_FechaCruce"] . "</div>
                                    </div>
                                    <div class='form-group'>
                                        <label>ClaveAduana</label>
                                        <div>" . $row["ae_ClaveAduana"] . "</div>
                                    </div>
                            
                                    <div class='form-group'>
                                        <label>patente</label>
                                        <div>" . $row["ae_patente"] . "</div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class='row'>
                            <hr>
                            <h5><strong>Datos de Material</strong></h5>
                            <hr>
                        
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label>MaterialID</label>
                                    <div>" . $row["m_MaterialID"] . "</div>
                                </div>
                        
                                <div class='form-group'>
                                    <label>NumParte</label>
                                    <div>" . $row["m_NumParte"] . "</div>
                                </div>
                            </div>
                        
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label>DescripcionMaterial</label>
                                    <div>" . $row["m_DescripcionMaterial"] . "</div>
                                </div>
                        
                                <div class='form-group'>
                                    <label>FraccionArancelaria</label>
                                    <div>" . $row["m_FraccionArancelaria"] . "</div>
                                </div>
                            </div>
                        
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label>UnidadMedidaComercializacion</label>
                                    <div>" . $row["m_UnidadMedidaComercializacion"] . "</div>
                                </div>
                        
                                <div class='form-group'>
                                    <label>UnidadMedidaTIGIE</label>
                                    <div>" . $row["m_UnidadMedidaTIGIE"] . "</div>
                                </div>
                            </div>
                        
                            <div class='col-md-3'>
                                <div class='form-group'>
                                    <label>TipoMaterial</label>
                                    <div>" . $row["m_TipoMaterial"] . "</div>
                                </div>
                            </div>
                        </div>
                        

                        <div class='row'>
                        <hr>
                        <h5><strong>Datos del Producto</strong></h5>
                        <hr>
                    
                        <div class='col-md-3'>
                           
                    
                            <div class='form-group'>
                                <label>NumParte</label>
                                <div>" . $row["pr_NumParte"] . "</div>
                            </div>

                            <div class='form-group'>
                                <label>DescripcionProducto</label>
                                <div>" . $row["pr_DescripcionProducto"] . "</div>
                            </div>
                        </div>
                    
                        <div class='col-md-3'>
                            
                    
                            <div class='form-group'>
                                <label>FraccionArancelaria</label>
                                <div>" . $row["pr_FraccionArancelaria"] . "</div>
                            </div>
                        </div>
                    
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>UnidadMedidaComercializacion</label>
                                <div>" . $row["pr_UnidadMedidaComercializacion"] . "</div>
                            </div>
                    
                        </div>

                        <div class='col-md-3'>
                     
                        <div class='form-group'>
                            <label>UnidadMedidaTIGIE</label>
                            <div>" . $row["pr_UnidadMedidaTIGIE"] . "</div>
                        </div>
                    </div>         
                    </div>
                    


                        <div class='row'>
                        <hr>
                        <h5><strong>Datos de Proveedores</strong></h5>
                        <hr>
                    
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>ProveedorID</label>
                                <div>" . $row["p_ProveedorID"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>NumClaveIdentificacionEmpresa</label>
                                <div>" . $row["p_NumClaveIdentificacionEmpresa"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>NombreRazonSocial</label>
                                <div>" . $row["p_NombreRazonSocial"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>Nacionalidad</label>
                                <div>" . $row["p_Nacionalidad"] . "</div>
                            </div>
                        </div>
                    
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>NumProgramaIMMEX</label>
                                <div>" . $row["p_NumProgramaIMMEX"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>RecintoFiscalizado</label>
                                <div>" . $row["p_RecintoFiscalizado"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>ClaveIdentificacionFiscal</label>
                                <div>" . $row["p_ClaveIdentificacionFiscal"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>Calle</label>
                                <div>" . $row["p_Calle"] . "</div>
                            </div>
                        </div>
                    
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>Numero</label>
                                <div>" . $row["p_Numero"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>CodigoPostal</label>
                                <div>" . $row["p_CodigoPostal"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>Colonia</label>
                                <div>" . $row["p_Colonia"] . "</div>
                            </div>
                    
                            <div class='form-group'>
                                <label>EntidadFederativa</label>
                                <div>" . $row["p_EntidadFederativa"] . "</div>
                            </div>
                        </div>
                    
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>Pais</label>
                                <div>" . $row["p_Pais"] . "</div>
                            </div>
                        </div>
                    </div>


                    <div class='row'>
                    <hr>
                    <h5><strong>Datos de Submanufactura</strong></h5>
                    <hr>
                
                    <div class='col-md-3'>
                        <div class='form-group'>
                            <label>SubmanufacturaID</label>
                            <div>" . $row["sm_SubmanufacturaID"] . "</div>
                        </div>
                
                        <div class='form-group'>
                            <label>NumClaveIdentificacion</label>
                            <div>" . $row["sm_NumClaveIdentificacion"] . "</div>
                        </div>

                        <div class='form-group'>
                            <label>NombreRazonSocial</label>
                            <div>" . $row["sm_NombreRazonSocial"] . "</div>
                        </div>
                    </div>
                
                    <div class='col-md-3'>
                        
                
                        <div class='form-group'>
                            <label>NumAutorizacionSE</label>
                            <div>" . $row["sm_NumAutorizacionSE"] . "</div>
                        </div>

                        <div class='form-group'>
                            <label>FechaAutorizacion</label>
                            <div>" . $row["sm_FechaAutorizacion"] . "</div>
                        </div>
                
                        <div class='form-group'>
                            <label>Calle</label>
                            <div>" . $row["sm_Calle"] . "</div>
                        </div>
                    </div>
                
                    <div class='col-md-3'>
                        
                        <div class='form-group'>
                            <label>Numero</label>
                            <div>" . $row["sm_Numero"] . "</div>
                        </div>
                        <div class='form-group'>
                            <label>CodigoPostal</label>
                            <div>" . $row["sm_CodigoPostal"] . "</div>
                        </div>

                        <div class='form-group'>
                            <label>Colonia</label>
                            <div>" . $row["sm_Colonia"] . "</div>
                        </div>
                    </div>
                
                    <div class='col-md-3'>
                
                        <div class='form-group'>
                            <label>EntidadFederativa</label>
                            <div>" . $row["sm_EntidadFederativa"] . "</div>
                        </div>
                
                        <div class='form-group'>
                            <label>Pais</label>
                            <div>" . $row["sm_Pais"] . "</div>
                        </div>
                    </div>
                </div>



                <div class='row'>
                <hr>
                <h5><strong>Datos de Cliente</strong></h5>
                <hr>
            
                <div class='col-md-3'>
                    <div class='form-group'>
                        <label>ClienteID</label>
                        <div>" . $row["c_ClienteID"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>NumClaveIdentificacion</label>
                        <div>" . $row["c_NumClaveIdentificacion"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>NombreRazonSocial</label>
                        <div>" . $row["c_NombreRazonSocial"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>Nacionalidad</label>
                        <div>" . $row["c_Nacionalidad"] . "</div>
                    </div>
                </div>
            
                <div class='col-md-3'>
                    <div class='form-group'>
                        <label>NumProgramaIMMEX</label>
                        <div>" . $row["c_NumProgramaIMMEX"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>ECEX</label>
                        <div>" . $row["c_ECEX"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>EmpresaIndustrial</label>
                        <div>" . $row["c_EmpresaIndustrial"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>RecintoFiscalizado</label>
                        <div>" . $row["c_RecintoFiscalizado"] . "</div>
                    </div>
                </div>
            
                <div class='col-md-3'>
                    <div class='form-group'>
                        <label>ClaveIdentificacionFiscal</label>
                        <div>" . $row["c_ClaveIdentificacionFiscal"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>Calle</label>
                        <div>" . $row["c_Calle"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>Numero</label>
                        <div>" . $row["c_Numero"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>CodigoPostal</label>
                        <div>" . $row["c_CodigoPostal"] . "</div>
                    </div>
                </div>
            
                <div class='col-md-3'>
                    <div class='form-group'>
                        <label>Colonia</label>
                        <div>" . $row["c_Colonia"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>EntidadFederativa</label>
                        <div>" . $row["c_EntidadFederativa"] . "</div>
                    </div>
            
                    <div class='form-group'>
                        <label>Pais</label>
                        <div>" . $row["c_Pais"] . "</div>
                    </div>
                </div>
            </div>

            <div class='row'>
            <hr>
            <h5><strong>Datos del Agente Aduanal</strong></h5>
            <hr>
        
            <div class='col-md-3'>
                <div class='form-group'>
                    <label>AgenteAduanalID</label>
                    <div>" . $row["ag_AgenteAduanalID"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>TipoAgente</label>
                    <div>" . $row["ag_TipoAgente"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>NumPatenteAutorizacion</label>
                    <div>" . $row["ag_NumPatenteAutorizacion"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>NombreAgenteAduanal</label>
                    <div>" . $row["ag_NombreAgenteAduanal"] . "</div>
                </div>
            </div>
        
            <div class='col-md-3'>
                <div class='form-group'>
                    <label>ApellidoPaterno</label>
                    <div>" . $row["ag_ApellidoPaterno"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>ApellidoMaterno</label>
                    <div>" . $row["ag_ApellidoMaterno"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>RFC</label>
                    <div>" . $row["ag_RFC"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>CURP</label>
                    <div>" . $row["ag_CURP"] . "</div>
                </div>
            </div>
        
            <div class='col-md-3'>
                <div class='form-group'>
                    <label>RazonSocial</label>
                    <div>" . $row["ag_RazonSocial"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>Calle</label>
                    <div>" . $row["ag_Calle"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>Numero</label>
                    <div>" . $row["ag_Numero"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>CodigoPostal</label>
                    <div>" . $row["ag_CodigoPostal"] . "</div>
                </div>
            </div>
        
            <div class='col-md-3'>
                <div class='form-group'>
                    <label>Colonia</label>
                    <div>" . $row["ag_Colonia"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>EntidadFederativa</label>
                    <div>" . $row["ag_EntidadFederativa"] . "</div>
                </div>
        
                <div class='form-group'>
                    <label>Pais</label>
                    <div>" . $row["ag_Pais"] . "</div>
                </div>
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
    function mostrarInterfazEntrada() {
        document.getElementById("tabla_interfase").style.display = "block";
        document.getElementById("tabla_aduana").style.display = "none";
    }

    function mostrarEntradaAduana() {
        document.getElementById("tabla_interfase").style.display = "none";
        document.getElementById("tabla_aduana").style.display = "block";
    }
</script>
