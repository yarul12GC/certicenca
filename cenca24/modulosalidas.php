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
        <h3><strong>Proceso de Salidas y Aduanas</strong></h3><br>

        <button type="button" class="btn btn-success" onclick="mostrarInterfazSalida()">Interfaz Salida</button>
        <button type="button" class="btn btn-success" onclick="mostrarAduanaSalida()">Entrada Salida</button><br>
        <div id="tabla_interfase">

            <?php
            $sql_interfase = "SELECT 
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


            $result_interfase = $conn->query($sql_interfase);

            $interfase_salidas = array();
            while ($row = $result_interfase->fetch_assoc()) {
                $interfase_salidas[] = $row;
            }

            if (count($interfase_salidas) > 0) {
                echo "<div><br>
                        <h4>Tabla Interfase Salidas</h4>
                          <br>
                            <a href='ExcelInterfazSalidas.php' class='nuevo'>
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
                            <td>" . $row["InterfaseSalidaID"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["DescripcionProducto"] . "</td>
                            <td>" . $row["MontoDolares"] . "</td>
                            <td>" . $row["FechaRecibo"] . "</td> <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase" . $row["InterfaseEntradaID"] . "'>Ver Detalles</button></td>
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
                                                <label>Material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Producto:</label>
                                                <div>" . $row["DescripcionProducto"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Cantidad Material:</label>
                                                <div>" . $row["Cantidad"] . "</div>
                                            </div>

                                            <div class='form-group'>
                                                <label>Unidad Medida Comercializacion Material:</label>
                                                <div>" . $row["Material_UnidadMedidaComercializacion"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad Medida Comercializacion Producto:</label>
                                                <div>" . $row["UnidadMedidaComercializacion"] . "</div>
                                            </div>
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Monto Dolares:</label>
                                                <div>" . $row["MontoDolares"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Fecha Recibo:</label>
                                                <div>" . $row["FechaRecibo"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Proveedor:</label>
                                                <div>" . $row["NombreProveedor"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Contribuyente:</label>
                                                <div>" . '<b>Denominación o razón social:</b><br> ' . $row["DenominacionRazonSocial"] . "</div>
                                                <div>" . '<b>RFC:</b> ' . $row["ClaveRFC"] . "</div>
                                            </div>
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Cliente:</label>
                                                <div>" . $row["clienteSalida"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Fecha de recibo:</label>
                                                <div>" . $row["FechaRecibo"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Orden Compra:</label>
                                                <div>" . $row["OrdenCompra"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Número de Factura Control:</label>
                                                <div>" . $row["NumFacturaControlRecibo"] . "</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
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
                            'aduanasalidas' AS Tabla,
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
                            aduanasalidas asal
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

            $result_aduana = $conn->query($sql_aduana);

            $aduana_entries = array();
            while ($row = $result_aduana->fetch_assoc()) {
                $aduana_entries[] = $row;
            }

            if (count($aduana_entries) > 0) {
                echo "<div> <br>
                        <h4>Tabla Aduana Salidas</h4>
                          <br>
                            <a href='ExcelAduanasSalidas.php' class='nuevo'>
                            <i class='fas fa-file-excel mr-1'></i> Generar Excel
                            </a>
                            <br>
                        <table class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    <th>Entrada ID</th>
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
                            <td>" . $row["AduanaEntradaID"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["NumeroPedimento"] . "</td>
                            <td>" . $row["ClaveAduana"] . "</td>
                            <td>" . $row["patente"] . "</td>
                            <td>" . $row["ClavePedimento"] . "</td>
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
                                                <label>Numero De Pedimento:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>
                                             <div class='form-group'>
                                                <label>Clave del pedimento:</label>
                                                <div>" . $row["ClavePedimento"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>
                                           

                                            <div class='form-group'>
                                                <label>Unidad Medida Comercializacion Material:</label>
                                                <div>" . $row["MaterialUnidadMedidaComercializacion"] . "</div>
                                            </div>
                                          
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Fecha del pedimento:</label>
                                                <div>" . $row["FechaPedimento"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Proveedor:</label>
                                                <div>" . $row["NombreRazonSocialProb"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Contribuyente:</label>
                                                <div>" . '<b>Denominación o razón social:</b><br> ' . $row["DenominacionRazonSocial"] . "</div>
                                                <div>" . '<b>RFC:</b> ' . $row["ClaveRFC"] . "</div>
                                            </div>
                                        </div>

                                         </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
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