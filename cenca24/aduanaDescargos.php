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
    <title>Proceso de Descargos</title>
    <?php
    include 'vistas/cabeza.php';
    ?>

</head>

<body>
    <section class="contenedor">
        <h3><strong>Proceso de Descargos</strong></h3><br>


        <div id="tabla_interfase">

            <?php
            $sql_movimientos = "SELECT 
                            'Manufactura y Ajustes' AS Tabla,
                            im.*,
                            im.IdentificadorSistemaCorporativo AS IdentificadorSistemaCorporativoMovi,
                            ife.*,
                            ifs.*,
                            ifs.Cantidad AS CantidadSalidad,
                            ife.FechaRecibo As FechaReciboEntrada,
                            ife.Cantidad AS CantidadEntrada,
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
                       
                            <a href='ExcelDescargos.php' class='nuevo'>
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
                            <td>" . $row["CantidadEntrada"] . "</td>
                            <td>" . $row["CantidadSalidad"] . "</td>
                            <td>" . $row["ConsumoReal"] . "</td> <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase" . $row["InterfaseEntradaID"] . "'>Ver Detalles</button></td>
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
                                                <label>Unidad de medida:</label>
                                                <div>" . $row["UnidadMedida"] . "</div>
                                            </div>

                                            <div class='form-group'>
                                                <label>Producto:</label>
                                                <div>" . $row["DescripcionProducto"] . "</div>
                                            </div>
                                        
                                        </div>

                                        <div class='col-md-4'>
                                            <div class='form-group'>
                                                <label>Cantidad de entrada:</label>
                                                <div>" . $row["CantidadEntrada"] . "</div>
                                            </div>
                                             <div class='form-group'>
                                                <label>Cantidad de Salida:</label>
                                                <div>" . $row["CantidadSalidad"] . "</div>
                                            </div>
                                            <div class='form-group'>
                                                <label>Consumo real:</label>
                                                <div>" . $row["ConsumoReal"] . "</div>
                                            </div>
                                        
                                        </div>

                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <label>Faltantes</label>
                                        <div>" . $row["Faltantes"] . "</div>
                                     </div>
                                    <div class='form-group'>
                                        <label>Sobrantes:</label>
                                        <div>" . $row["Sobrantes"] . "</div>
                                    </div>
                                    <div class='form-group'>
                                        <label>Mermas:</label>
                                        <div>" . $row["Mermas"] . "</div>
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