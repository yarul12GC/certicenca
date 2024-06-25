<?php
include 'startSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/media/icon.png" type="image/x-icon" />

    <title>P DE MOVIMIENTOS</title>
</head>
<body>
    <header>
    <?php include 'vistas/cabeza.php'; ?>
    </header>

    <section class="contenedor">
        <h3><strong>Proceso de movimiento.</strong></h3>
        <br>
        <a href='excelmovimientos.php' class='nuevo'>
            <i class='fas fa-file-excel mr-1'></i> Generar Excel
        </a>
        <br>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre del Material</th>
                    <th>Consolidado Movimientos</th>
                    <th>Cantidad de Entrada</th>
                    <th>Cantidad de Salida</th>
                    <th>Faltantes</th>
                    <th>Sobrantes</th>
                    <th>Consumo Real</th>
                    <th>Monto en Dólares</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conexion.php');
                $consulta = "SELECT 
                    'interfasemovimientos' AS Tabla,
                    im.*,
                    ie.Cantidad AS CantidadEntrada,
                    isal.Cantidad AS CantidadSalida,
                    mat.*,
                    prod.*,
                    cont.DenominacionRazonSocial AS nombrecontribuyente
                FROM 
                    interfasemovimientos AS im
                LEFT JOIN 
                    interfaseentradas AS ie ON im.InterfaseEntradaID = ie.InterfaseEntradaID
                LEFT JOIN 
                    interfasesalidas AS isal ON im.InterfaseSalidaID = isal.InterfaseSalidaID
                LEFT JOIN 
                    materiales AS mat ON im.MaterialID = mat.MaterialID
                LEFT JOIN 
                    productos AS prod ON im.ProductoID = prod.ProductoID
                LEFT JOIN 
                    contribuyente AS cont ON im.ContribuyenteID = cont.ContribuyenteID";
                $resultado = mysqli_query($conn, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                        <td><?= $fila['DescripcionMaterial'] ?></td>
                        <td><?= $fila['ConsolidadoMovimientos'] ?></td>
                        <td><?= $fila['CantidadEntrada'] ?></td>
                        <td><?= $fila['CantidadSalida'] ?></td>
                        <td><?= $fila['Faltantes'] ?></td>
                        <td><?= $fila['Sobrantes'] ?></td>
                        <td><?= $fila['ConsumoReal'] ?></td>
                        <td><?= $fila['MontoTotalDolares'] ?></td>
                        <td>
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase_<?= $fila["InterfaseEntradaID"] ?>'>Ver Detalles</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <?php include 'vistas/footer.php'; ?>
    </footer>

    <!-- Modales -->
    <?php
    // Volvemos a obtener los resultados para poder crear los modales
    mysqli_data_seek($resultado, 0);
    while ($fila = mysqli_fetch_assoc($resultado)) : ?>
        <div class='modal fade' id='modal_interfase_<?= $fila["InterfaseEntradaID"] ?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered modal-lg' style='max-width: 90%;'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='exampleModalLabel'>Proceso de movimiento</h1>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Consolidado:</label>
                                    <div><?php echo $fila['ConsolidadoMovimientos']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Producto Elaborado</label>
                                    <div><?php echo $fila['DescripcionProducto']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Material:</label>
                                    <div><?php echo $fila['DescripcionMaterial']; ?></div>
                                </div>
                               
                                <div class="form-group">
                                    <label>Cantidad de Entrada:</label>
                                    <div><?php echo $fila['CantidadEntrada']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad de Salida:</label>
                                    <div><?php echo $fila['CantidadSalida']; ?></div>
                                </div>
                                
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cantidad producto Elaborado:</label>
                                    <div><?php echo $fila['CantidadMercancia']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>DescripcionMercancia:</label>
                                    <div><?php echo $fila['DescripcionMercancia']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>UnidadMedida:</label>
                                    <div><?php echo $fila['UnidadMedida']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Faltantes:</label>
                                    <div><?php echo $fila['Faltantes']; ?></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sobrantes:</label>
                                    <div><?php echo $fila['Sobrantes']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Mermas:</label>
                                    <div><?php echo $fila['Mermas']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>ConsumoReal:</label>
                                    <div><?php echo $fila['ConsumoReal']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>ValorUnitarioDolares:</label>
                                    <div><?php echo $fila['ValorUnitarioDolares']; ?></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>MontoTotalDolares:</label>
                                    <div><?php echo $fila['MontoTotalDolares']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>FechaRecuperacion:</label>
                                    <div><?php echo $fila['FechaRecuperacion']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Identificador Sistema Corporativo:</label>
                                    <div><?php echo $fila['IdentificadorSistemaCorporativo']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Contribuyente:</label>
                                    <div><?php echo $fila['nombrecontribuyente']; ?></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='button' class='btn btn-primary'>Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
