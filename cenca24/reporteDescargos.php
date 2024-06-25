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
    <title>Reporte de Descargos de Materiales</title>
    <?php
    include 'vistas/cabeza.php';
    ?>

</head>

<body>
    <section class="contenedor">
        <h3><strong>Reporte de Descargos de Materiales</strong></h3><br>


        <div id="tabla_interfase">

            <?php
            $sql_movimientos = "SELECT 
                            'Descargo de materiales' AS Tabla,
                            im.*,
                            im.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoMovi,  
                            ife.Cantidad AS CantidadE,                                              
                            ife.UnidadMedidaComercializacion AS UnidadMedidaComercializacionE,
                            ife.MontoDolares AS MontoDolaresE,
                            ife.FechaRecibo As FechaReciboEntrada,
                            ife.NumFacturaControlRecibo AS NumFacturaControlReciboE,
                            ife.OrdenCompra AS OrdenCompraE,
                            ife.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoE,
                            ifs.Cantidad AS CantidadS,    
                            ifs.UnidadMedidaComercializacion AS UnidadMedidaComercializacionS,
                            ifs.MontoDolares AS MontoDolaresS,
                            ifs.FechaRecibo As FechaReciboS,
                            ifs.NumFacturaControlRecibo AS NumFacturaControlReciboS,
                            ifs.OrdenCompra AS OrdenCompraS,
                            ifs.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoS,
                            ct.*,
                            p.*,
                            m.NumParte AS MaterialNumParte,
                            m.DescripcionMaterial,
                            m.FraccionArancelaria AS MaterialFraccionArancelaria,
                            m.UnidadMedidaComercializacion AS MaterialUnidadMedidaComercializacion,
                            m.UnidadMedidaTIGIE AS MaterialUnidadMedidaTIGIE,
                            m.TipoMaterial
                        FROM 
                            interfasemovimientos im
                        LEFT JOIN 
                            interfaseentradas ife ON im.InterfaseEntradaID = ife.InterfaseEntradaID
                        LEFT JOIN 
                            interfasesalidas ifs ON im.InterfaseSalidaID = ifs.InterfaseSalidaID
                        LEFT JOIN 
                            materiales m ON im.MaterialID = m.MaterialID
                        LEFT JOIN 
                            productos p ON im.ProductoID = p.ProductoID
                        LEFT JOIN 
                            contribuyente ct ON im.ContribuyenteID = ct.ContribuyenteID";



            $result_movimientos = $conn->query($sql_movimientos);

            $interfase_movimientos = array();
            while ($row = $result_movimientos->fetch_assoc()) {
                $interfase_movimientos[] = $row;
            }

            if (count($interfase_movimientos) > 0) {
                echo "<div><br>
                       
                            <a href='ExcelReporteDescargos.php' class='nuevo'>
                            <i class='fas fa-file-excel mr-1'></i> Generar Excel
                            </a>
                            <br>
                        <table  class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    
                                    <th>Material</th>
                                    <th>Producto</th>
                                    <th>Cantidad Entrada</th>
                                    <th>Cantidad Salida</th>
                                    <th>Consumo Real</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>";

                foreach ($interfase_movimientos as $row) {
                    echo "<tr>
                            <td>" . $row["Tabla"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["DescripcionProducto"] . "</td>
                            <td>" . $row["CantidadE"] . "</td>
                            <td>" . $row["CantidadS"] . "</td>
                            <td>" . $row["ConsumoReal"] . "</td> <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase" . $row["InterfaseMovimientoID"] . "'>Ver Detalles</button></td>
                        </tr>";

                    echo "<div class='modal fade' id='modal_interfase" . $row["InterfaseMovimientoID"] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered modal-lg' style='max-width: 90%;'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='modalLabel'>Detalles del Descargo</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body row'>
                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Consolidado de Movimientos:</label>
                                                <div>" . $row["ConsolidadoMovimientos"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Consumo real:</label>
                                                <div>" . $row["ConsumoReal"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Faltantes</label>
                                                <div>" . $row["Faltantes"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Sobrantes:</label>
                                                <div>" . $row["Sobrantes"] . "</div>
                                            </div>
                                        </div>

                                        <div class='col-md-4'>
                                            
                                            <div class='form-group'>
                                                <label>Mermas:</label>
                                                <div>" . $row["Mermas"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Descripción del Mercancia:</label>
                                                <div>" . $row["DescripcionMercancia"] . "</div>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Unidad de medida:</label>
                                                <div>" . $row["UnidadMedida"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Cantidad de Mercancia:</label>
                                                <div>" . $row["CantidadMercancia"] . "</div>
                                            </div>                                
                                        </div>

                                        <div class='col-md-4'>
                                           <div class='form-group'>
                                                <label>Valor unitario en dolares:</label>
                                                <div>" . $row["ValorUnitarioDolares"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Monto Total en Dolares:</label>
                                                <div>" . $row["MontoTotalDolares"] . "</div>
                                            </div>
                                               <div class='form-group'>
                                                <label>Fecha de Recuperacion:</label>
                                                <div>" . $row["FechaRecuperacion"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Identificador del Sistema:</label>
                                                <div>" . $row["IdentificadorSistemaCorporativoMovi"] . "</div>
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
                                      <h5> <strong>Descripción de la salida</strong></h5><hr>
                                         <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Cantidad Salida:</label>
                                                <div>" . $row["CantidadS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad de Medida de Comercialización:</label>
                                                <div>" . $row["UnidadMedidaComercializacionS"] . "</div>
                                            </div>    
                                            <div class='form-group'>
                                                <label>Monto en Dolares:</label>
                                                <div>" . $row["MontoDolaresS"] . "</div>
                                            </div>                                                                            
                                        </div>

                                        <div class='col-md-4'>
                                            
                                            <div class='form-group'>
                                                <label>Fecha de Recibo:</label>
                                                <div>" . $row["FechaReciboS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Numero de Factura Control:</label>
                                                <div>" . $row["NumFacturaControlReciboS"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Orden de Compra:</label>
                                                <div>" . $row["OrdenCompraS"] . "</div>
                                            </div>                        
                                        </div>
                                        <div class='col-md-4'>
                                           <div class='form-group'>
                                                <label>Identificador del SistemaCorporativo:</label>
                                                <div>" . $row["IdentificadorSistemaCorporativoS"] . "</div>
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