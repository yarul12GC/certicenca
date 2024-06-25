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
    <title>R DE MOVIMIENTOS</title>
</head>
<body>
    <header>
    <?php include 'vistas/cabeza.php'; ?>
    </header>

    <section class="contenedor">
        <h3><strong>Reporte de Saldos de mercancia.</strong></h3>
        <br>
        <button type="button" class="btn btn-success" onclick="mostrarInterfazEntrada()">Saldos Interfaz</button>
        <button type="button" class="btn btn-success" onclick="mostrarEntradaAduana()">Saldos Aduana</button>
        <br>
        <div id="tabla_interfase">
        <br>

        <a href='reporte-movimientos.php' class='nuevo'>
        <i class='fas fa-file-excel mr-1'></i> Generar Excel
        </a>
        <br>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre del Material</th>
                    <th>Cantidad de Entrada</th>
                    <th>Cantidad de Salida</th>
                    <th>Faltantes</th>
                    <th>Sobrantes</th>
                    <th>Consumo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conexion.php');
                $consulta = "SELECT 
                    'InterfaseMovimientos' AS Tabla,
                    im.*,
                    ie.Cantidad AS CantidadEntrada,
                    isal.Cantidad AS CantidadSalida,
                    mat.*,
                    prod.*,
                    cont.*
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
                        <td><?= $fila['CantidadEntrada'] ?></td>
                        <td><?= $fila['CantidadSalida'] ?></td>
                        <td><?= $fila['Faltantes'] ?></td>
                        <td><?= $fila['Sobrantes'] ?></td>
                        <td><?= $fila['ConsumoReal'] ?></td>
                        <td>
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal_interfase_<?= $fila["InterfaseEntradaID"] ?>'>Ver Detalles</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <div id="tabla_aduana" style="display: none;">
            <br>
            <a href='saldosreporte.php' class='nuevo'>
                <i class='fas fa-file-excel mr-1'></i> Generar Excel
        </a>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre del Material</th>
                    <th>Cantidad de Entrada</th>
                    <th>Cantidad de Salida</th>
                    <th>Consumo de Mercancia</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conexion.php');
                $consulta2 = "SELECT 
                m.MaterialID,
                m.DescripcionMaterial,
                m.DescripcionMaterial,
                IFNULL(SUM(ae.CantidadEntradaAduana), 0) AS TotalEntradas,
                IFNULL(SUM(asal.CantidadSalidaAd), 0) AS TotalSalidas,
                IFNULL(SUM(ae.CantidadEntradaAduana), 0) - IFNULL(SUM(asal.CantidadSalidaAd), 0) AS SaldoMercancia
            FROM 
                materiales m
            LEFT JOIN 
                aduanaentradas ae ON m.MaterialID = ae.MaterialID
            LEFT JOIN 
                aduanasalidas asal ON m.MaterialID = asal.MaterialID
            GROUP BY 
                m.MaterialID, m.DescripcionMaterial;
            ";
                $resultado2 = mysqli_query($conn, $consulta2);
                while ($fila1 = mysqli_fetch_assoc($resultado2)) : ?>
                    <tr>
                        <td><?= $fila1['DescripcionMaterial'] ?></td>
                        <td><?= $fila1['TotalEntradas'] ?></td>
                        <td><?= $fila1['TotalSalidas'] ?></td>
                        <td><?= $fila1['SaldoMercancia'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
        
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
                        <h1 class='modal-title fs-5' id='exampleModalLabel'>Reporte de saldos de mercancia</h1>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Material:</label>
                                    <div><?php echo $fila['DescripcionMaterial']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>UnidadMedida:</label>
                                    <div><?php echo $fila['UnidadMedida']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad de Entrada:</label>
                                    <div><?php echo $fila['CantidadEntrada']; ?></div>
                                </div>
                                
                                
                            </div>

                            <div class="col-md-3">
                                
                                <div class="form-group">
                                    <label>Cantidad de Salida:</label>
                                    <div><?php echo $fila['CantidadSalida']; ?></div>
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
                                
                            </div>

                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>Consumo:</label>
                                    <div><?php echo $fila['ConsumoReal']; ?></div>
                                </div>

                                <div class="form-group">
                                    <label>Saldo Actual:</label>
                                    <div><?php echo $fila['Sobrantes']; ?></div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
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