<?php
include 'startSession.php';
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>Módulo de Activo Fijo</title>
    <?php
    // Incluir el archivo cabeza.php 
    include 'vistas/cabeza.php';
    ?>
</head>

<body>
    < <section class="contenedor">
        <?php
        $consultar = "SELECT * FROM aduanaactivosfijos ORDER BY IdActivoFijo ASC";
        $query = mysqli_query($conn, $consultar);
        $cantidad = mysqli_num_rows($query);
        //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>El activo se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el activo.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>La nueva entrada se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el activo.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('mensaje').style.display = 'none';
                    }, 2000);
                </script>";
        }
        ?>

        <h3><strong>Módulo de Activo Fijo</strong></h3>
        <!-- Button trigger modal -->
        <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#registrarEntrada">
            Registrar Nuevo Activo
        </button>
        <br><br>

        <div>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Número de pedimento</th>
                        <th>Clave del pedimento</th>
                        <th>Fecha de entrada declarada en el pedimento</th>
                        <th>País de origen de la mercancía</th>
                        <th>Tasa del impuesto</th>
                        <th>Factura comercial</th>
                        <th>Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['NumeroPedimento']; ?></td>
                            <td><?php echo $row['ClaveAduana']; ?></td>
                            <td><?php echo $row['FechaPedimento']; ?></td>
                            <td><?php echo $row['PaisOrigen']; ?></td>
                            <td><?php echo $row['TasaDeImpuesto']; ?></td>
                            <td><?php echo $row['FacturaComercial']; ?></td>

                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['IdActivoFijo']; ?>">
                                    <img src="assets/media/editar.png" width="15px" height="15px">
                                </button>

                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['IdActivoFijo']; ?>)">
                                    <img src="assets/media/eliminar.png" width="15px" height="15px">
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </section>

        <footer>
            <?php
            // Incluir el archivo ´pie.php
            include 'vistas/footer.php';
            ?>
        </footer>


        <!-- Modal de registro de cliente -->
        <div class="modal fade" id="registrarEntrada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Nuevo Activo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form action="procesarAduanaActivo.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="NumeroPedimento" class="form-label">Número de Pedimento:</label>
                                            <input type="text" class="form-control" id="NumeroPedimento" name="NumeroPedimento" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ClaveAduana" class="form-label">Clave de Aduana:</label>
                                            <input type="text" class="form-control" id="ClaveAduana" name="ClaveAduana" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="patente" class="form-label">Patente:</label>
                                            <input type="text" class="form-control" id="patente" name="patente" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="NumeroDoc" class="form-label">Número de Documento:</label>
                                            <input type="number" class="form-control" id="NumeroDoc" name="NumeroDoc" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="FechaPedimento" class="form-label">Fecha de Pedimento:</label>
                                            <input type="date" class="form-control" id="FechaPedimento" name="FechaPedimento" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ClavePedimento" class="form-label">Clave de Pedimento:</label>
                                            <input type="text" class="form-control" id="ClavePedimento" name="ClavePedimento" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="PaisOrigen" class="form-label">País de Origen de la Mercancía:</label>
                                            <input type="text" class="form-control" id="PaisOrigen" name="PaisOrigen" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ActivoFijoID" class="form-label">Descripcion de la mercancia:</label>
                                            <select name="ActivoFijoID" class="form-select">
                                                <option value="" disabled selected style="text-align: center;">-- Seleccionar --</option>
                                                <?php
                                                $activoF = mysqli_query($conn, "SELECT ActivoFijoID, OrdenCompra, DescripcionMercancia FROM activofijo");

                                                while ($datos = mysqli_fetch_array($activoF)) {
                                                ?>
                                                    <option value="<?php echo $datos['ActivoFijoID']; ?>">
                                                        <?php echo $datos['OrdenCompra'] . ' - ' . $datos['DescripcionMercancia']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="TipoImpuesto" class="form-label">Tipo de Impuesto:</label>
                                            <select name="TipoImpuesto" class="form-select" required>
                                                <option value="" disabled selected style="text-align: center;">----Seleccionar----</option>
                                                <option value="TIGIE">Tasa general de la TIGIE</option>
                                                <option value="Tasa preferencial">Tasa preferencial conforme algún tratado</option>
                                                <option value="PROSEC">Tasa prevista en los PROSEC</option>
                                                <option value="Regla 8a">Tasa aplicable conforme a la Regla 8a</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="TasaDeImpuesto" class="form-label">Tasa de Impuesto:</label>
                                            <input type="number" step="0.01" class="form-control" id="TasaDeImpuesto" name="TasaDeImpuesto" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="GuiaAereaConocimientoEmbarque" class="form-label">Guía aérea o conocimiento de embarque:</label>
                                            <input type="text" class="form-control" id="GuiaAereaConocimientoEmbarque" name="GuiaAereaConocimientoEmbarque" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="FacturaComercial" class="form-label">Aviso Factura comercial o CDFI:</label>
                                            <input type="text" class="form-control" id="FacturaComercial" name="FacturaComercial" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ContribuyenteID" class="form-label">Contribuyente:</label>
                                            <select name="ContribuyenteID" class="form-select" required>
                                                <option value="" disabled selected style="text-align: center;">-- Selecciona un contribuyente --</option>
                                                <?php
                                                $contrib = mysqli_query($conn, "SELECT ContribuyenteID, DenominacionRazonSocial, ClaveRFC FROM contribuyente");

                                                while ($datos = mysqli_fetch_array($contrib)) {
                                                ?>
                                                    <option value="<?php echo $datos['ContribuyenteID']; ?>">
                                                        <?php echo $datos['DenominacionRazonSocial'] . ' - RFC: ' . $datos['ClaveRFC']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="Tipopedimeto" class="form-label">¿Es pedimento consolidado?</label>
                                            <select class="form-select" id="Tipopedimeto" onchange="mostrarCamposTipoPedimento()">
                                                <option value="" disabled selected style="text-align: center;">--Seleccionar--</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div id="camposConsolidado" style="display: none;">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="AvisoElectronicoImportacionExportacion" class="form-label">Aviso electrónico de importación y de exportación:</label>
                                                    <input type="text" class="form-control" id="AvisoElectronicoImportacionExportacion" name="AvisoElectronicoImportacionExportacion">
                                                </div>
                                                <div class="form-group">
                                                    <label for="FechaCruceAviso" class="form-label">Fecha de cruce del “Aviso electrónico de importación y de exportación”</label>
                                                    <input type="date" class="form-control" id="FechaCruceAviso" name="FechaCruceAviso">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Registrar Activo</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales de edición  -->
        <?php
        $query = mysqli_query($conn, $consultar);
        while ($row = mysqli_fetch_array($query)) {
        ?>
            <div class="modal fade" id="editarModal<?php echo $row['IdActivoFijo']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Activo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="procesarEditarActivoAduana.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="NumeroPedimento" class="form-label">Número de Pedimento:</label>
                                            <input type="text" class="form-control" id="NumeroPedimento" name="NumeroPedimento" value="<?php echo $row['NumeroPedimento']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ClaveAduana" class="form-label">Clave de Aduana:</label>
                                            <input type="text" class="form-control" id="ClaveAduana" name="ClaveAduana" value="<?php echo $row['ClaveAduana']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="patente" class="form-label">Patente:</label>
                                            <input type="text" class="form-control" id="patente" name="patente" value="<?php echo $row['patente']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="NumeroDoc" class="form-label">Número de Documento:</label>
                                            <input type="number" class="form-control" id="NumeroDoc" name="NumeroDoc" value="<?php echo $row['NumeroDoc']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="FechaPedimento" class="form-label">Fecha de Pedimento:</label>
                                            <input type="date" class="form-control" id="FechaPedimento" name="FechaPedimento" value="<?php echo $row['FechaPedimento']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ClavePedimento" class="form-label">Clave de Pedimento:</label>
                                            <input type="text" class="form-control" id="ClavePedimento" name="ClavePedimento" value="<?php echo $row['ClavePedimento']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="PaisOrigen" class="form-label">País de Origen de la Mercancía:</label>
                                            <input type="text" class="form-control" id="PaisOrigen" name="PaisOrigen" value="<?php echo $row['PaisOrigen']; ?>" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="ActivoFijoID">Descripcion de la mercancia::</label>
                                            <select class="form-control" name="ActivoFijoID">

                                                <?php
                                                $ActivoF = mysqli_query($conn, "SELECT ActivoFijoID, OrdenCompra, DescripcionMercancia FROM activofijo");

                                                while ($datos = mysqli_fetch_array($ActivoF)) {
                                                ?>
                                                    <option value="<?php echo $datos['ActivoFijoID']; ?>" <?php echo ($row['ActivoFijoID'] == $datos['ActivoFijoID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['OrdenCompra']; ?> -Descripción: <?php echo $datos['DescripcionMercancia']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="TipoImpuesto" class="form-label">Tipo de Impuesto:</label>
                                            <select id="TipoImpuesto" name="TipoImpuesto" class="form-control">
                                                <option hidden value="<?php echo $row['TipoImpuesto']; ?> " required> <?php echo $row['TipoImpuesto']; ?></option>
                                                <option disabled>----Seleccionar----</option>
                                                <option value="TIGIE">Tasa general de la TIGIE</option>
                                                <option value="Tasa preferencial">Tasa preferencial conforme algún tratado</option>
                                                <option value="PROSEC">Tasa prevista en los PROSEC</option>
                                                <option value="Regla 8a">Tasa aplicable conforme a la Regla 8a</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="TasaDeImpuesto" class="form-label">Tasa de Impuesto:</label>
                                            <input type="number" step="0.01" class="form-control" id="TasaDeImpuesto" name="TasaDeImpuesto" value="<?php echo $row['TasaDeImpuesto']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="GuiaAereaConocimientoEmbarque" class="form-label">Guía aérea o conocimiento de embarque:</label>
                                            <input type="text" class="form-control" id="GuiaAereaConocimientoEmbarque" name="GuiaAereaConocimientoEmbarque" value="<?php echo $row['GuiaAereaConocimientoEmbarque']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="FacturaComercial" class="form-label">Aviso Factura comercial o CDFI:</label>
                                            <input type="text" class="form-control" id="FacturaComercial" name="FacturaComercial" value="<?php echo $row['FacturaComercial']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ContribuyenteID" class="form-label">Contribuyente</label>
                                            <select class="form-control" name="ContribuyenteID">

                                                <?php
                                                $consulta_contribuyentes = "SELECT ContribuyenteId, DenominacionRazonSocial FROM contribuyente";
                                                $resultado_contribuyentes = mysqli_query($conn, $consulta_contribuyentes);
                                                while ($fila = mysqli_fetch_assoc($resultado_contribuyentes)) {
                                                    $selected = ($fila['ContribuyenteId'] == $row['ContribuyenteId']) ? 'selected' : '';
                                                    echo "<option value=\"{$fila['ContribuyenteId']}\" {$selected}>{$fila['DenominacionRazonSocial']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="AvisoElectronicoImportacionExportacion" class="form-label">Aviso electrónico de importación y de exportación:</label>
                                            <input type="text" class="form-control" id="AvisoElectronicoImportacionExportacion" name="AvisoElectronicoImportacionExportacion" value="<?php echo $row['AvisoElectronicoImportacionExportacion']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="FechaCruceAviso" class="form-label">Fecha de cruce del “Aviso electrónico de importación y de exportación</label>
                                            <input type="date" class="form-control" id="FechaCruceAviso" name="FechaCruceAviso" value="<?php echo $row['FechaCruceAviso']; ?>">

                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" id="IdActivoFijo" name="IdActivoFijo" value="<?php echo $row['IdActivoFijo']; ?>" required>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

</body>
<script>
    function mostrarCamposTipoPedimento() {
        var tipoPedimento = document.getElementById("Tipopedimeto").value;
        var camposConsolidado = document.getElementById("camposConsolidado");

        if (tipoPedimento === "Si") {
            camposConsolidado.style.display = "block";
        } else {
            camposConsolidado.style.display = "none";
        }
    }
</script>

</html>