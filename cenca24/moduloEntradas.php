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

    <title>Consulta de Entradas</title>
    <?php
    include 'vistas/cabeza.php';
    ?>

</head>

<body>
    <section class="contenedor">
        <h3><strong>Proceso de Entradas</strong></h3>
        <br>

        <button type="button" class="btn btn-success" onclick="mostrarInterfazEntrada()">Interfaz Entrada</button>
        <button type="button" class="btn btn-success" onclick="mostrarEntradaAduana()">Entrada Aduana</button>
        <br><br>

        <div id="tabla_interfase">
            <?php
            // Consulta SQL para obtener los datos de Interfase Entradas
            $sql_interfase = "SELECT 
                'interfaseentradas' AS Tabla,
                ie.*,
                m.*,
                p.*,
                c.DenominacionRazonSocial AS Contribuyente,
                cl.NombreRazonSocial AS Cliente,
                pv.NombreRazonSocial AS Proveedor
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

                <h4>Tabla Interfase Entradas</h4>
                <br>
                <a href='PHPExcel.php' class='nuevo'>
                <i class='fas fa-file-excel mr-1'></i> Generar Excel
              </a>
                <br>
                <table class='table table-bordered table-hover'>
                    <thead class='table-dark'>
                        <tr>
                            <th>Tabla</th>
                            <th>Entrada ID</th>
                            <th>Material</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Unidad de Medida</th>
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
                    <td>" . $row["DescripcionProducto"] . "</td>
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
                                    <label>Cantidad:</label>
                                    <div>" . $row["Cantidad"] . "</div>
                                </div>
                                <div class='form-group'>
                                    <label>Unidad Medida Comercializacion:</label>
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
                                    <div>" . $row["Proveedor"] . "</div>
                                </div>
                                <div class='form-group'>
                                    <label>Contribuyente:</label>
                                    <div>" . $row["Contribuyente"] . "</div>
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label>Cliente:</label>
                                    <div>" . $row["Cliente"] . "</div>
                                </div>
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

            // Consulta SQL para obtener los datos de aduanaEntradas y sus detalles
            $sql_aduana = "SELECT 
            'AduanaEntradas' AS Tabla,
            ae.*,
            m.*,
            p.NombreRazonSocial AS nombreprovedor,
            sm.NombreRazonSocial AS razonSocial,
            c.DenominacionRazonSocial AS nombrecontribuyente,
            ag.*
        FROM 
            aduanaentradas ae
        LEFT JOIN 
            materiales m ON ae.MaterialID = m.MaterialID
        LEFT JOIN 
            proveedores p ON ae.ProveedorID = p.ProveedorID
        LEFT JOIN 
            submanufactura sm ON ae.SubmanufacturaID = sm.SubmanufacturaID
        LEFT JOIN 
            contribuyente c ON ae.ContribuyenteID = c.ContribuyenteID
        LEFT JOIN 
            agentesaduanales ag ON ae.AgenteAduanalID = ag.AgenteAduanalID;";


            $result_aduana = $conn->query($sql_aduana);

            $aduana_entries = array();
            while ($row = $result_aduana->fetch_assoc()) {
                $aduana_entries[] = $row;
            }

            if (count($aduana_entries) > 0) {
                echo "<div>
                        <h4>Tabla Aduana Entradas</h4>
                        <br>
                        <a href='execeladuanas.php' class='nuevo'>
                            <i class='fas fa-file-excel mr-1'></i> Generar Excel
                        </a>
                        <br>
                        <table class='table table-bordered table-hover'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>Tabla</th>
                                    <th>Proveedor</th>
                                    <th>Material</th>
                                    <th>Pedimento</th>
                                    <th>Clave Aduana</th>
                                    <th>patente</th>
                                    <th>Tipo de Impuesto</th>
                                    <th>Tasa De Impuesto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>";

                foreach ($aduana_entries as $row) {
                    echo "<tr>
                            <td>" . $row["Tabla"] . "</td>
                            <td>" . $row["nombreprovedor"] . "</td>
                            <td>" . $row["DescripcionMaterial"] . "</td>
                            <td>" . $row["NumeroPedimento"] . "</td>
                            <td>" . $row["ClaveAduana"] . "</td>
                            <td>" . $row["patente"] . "</td>
                            <td>" . $row["tipoImpuesto"] . "</td>
                            <td>" . $row["TasaDeImpuesto"] . "</td>
                            <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_aduana" . $row["AduanaEntradaID"] . "'>Ver Detalles</button></td>
                        </tr>";

                        echo "<div class='modal fade' id='modal_aduana" . $row["AduanaEntradaID"] . "' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
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


                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Numero Pedimento:</label>
                                                <div>" . $row["NumeroPedimento"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Clave de Aduana:</label>
                                                <div>" . $row["ClaveAduana"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Patente:</label>
                                                <div>" . $row["patente"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Numero Doc:</label>
                                                <div>" . $row["NumeroDoc"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>contribuyente:</label>
                                                <div>" . $row["nombrecontribuyente"] . "</div>
                                            </div>
                                        </div>


                                        <div class='col-md-3'>                                         
                                            <div class='form-group'>
                                                <label>Clave Pedimento:</label>
                                                <div>" . $row["ClavePedimento"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Fecha Pedimento:</label>
                                                <div>" . $row["FechaPedimento"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Material:</label>
                                                <div>" . $row["DescripcionMaterial"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Proveedor:</label>
                                                <div>" . $row["nombreprovedor"] . "</div>
                                            </div>
                                            
                                        </div>


                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Pais de Origen Mercancia:</label>
                                                <div>" . $row["PaisOrigenMercancia"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tipo Impuesto:</label>
                                                <div>" . $row["tipoImpuesto"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Tasa De Impuesto:</label>
                                                <div>" . $row["TasaDeImpuesto"] . "</div>
                                            </div>

                                            <div class='form-group'>
                                            <label>Factura Comercial:</label>
                                            <div>" . $row["FacturaComercial"] . "</div>
                                            </div>
                                        </div>


                                        <div class='col-md-3'>
                                            <div class='form-group'>
                                                <label>Aviso Electronico:</label>
                                                <div>" . $row["AvisoElectronico"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Fecha de Cruce:</label>
                                                <div>" . $row["FechaCruce"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Submanufactura:</label>
                                                <div>" . $row["razonSocial"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Agente Aduanal:</label>
                                                <div>" . $row["NombreAgenteAduanal"] . "</div>
                                            </div>
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
    function mostrarInterfazEntrada() {
        document.getElementById("tabla_interfase").style.display = "block";
        document.getElementById("tabla_aduana").style.display = "none";
    }

    function mostrarEntradaAduana() {
        document.getElementById("tabla_interfase").style.display = "none";
        document.getElementById("tabla_aduana").style.display = "block";
    }
</script>
