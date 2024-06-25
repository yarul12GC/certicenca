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
    <title>Información aduanera de Entradas </title>
    <?php
    // Incluir el archivo cabeza.php 
    include 'vistas/cabeza.php';
    ?>
</head>

<body>
    < <section class="contenedor">
        <?php
        $consultar = "SELECT * FROM aduanaentradas ORDER BY AduanaEntradaID ASC";
        $query = mysqli_query($conn, $consultar);
        $cantidad = mysqli_num_rows($query);

        //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>La entrada se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar la entrada.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>La nueva entrada se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar la entrada.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('mensaje').style.display = 'none';
                    }, 2000);
                </script>";
        }
        ?>

        <h3><strong>Información aduanera de (Entradas)</strong></h3>
        <!-- Button trigger modal -->
        <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#registrarEntrada">
            Registrar Nueva Entrada
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
                            <td><?php echo $row['ClavePedimento']; ?></td>
                            <td><?php echo $row['FechaPedimento']; ?></td>
                            <td><?php echo $row['PaisOrigenMercancia']; ?></td>
                            <td><?php echo $row['TasaDeImpuesto']; ?></td>
                            <td><?php echo $row['FacturaComercial']; ?></td>

                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['AduanaEntradaID']; ?>">
                                    <img src="assets/media/editar.png" width="15px" height="15px">
                                </button>

                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['AduanaEntradaID']; ?>)">
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


        <!-- Modal de registro  -->
        <div class="modal fade" id="registrarEntrada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel">Registrar Nueva Entrada</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="procesarAduanaEntrada.php" method="POST">
                            <div class="row">
                                <div class="col-md-4">
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
                                        <label for="ClavePedimento" class="form-label">Clave de Pedimento:</label>
                                        <input type="text" class="form-control" id="ClavePedimento" name="ClavePedimento" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="FechaPedimento" class="form-label">Fecha de Pedimento:</label>
                                        <input type="date" class="form-control" id="FechaPedimento" name="FechaPedimento" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="MaterialID" class="form-label">Material:</label>
                                        <select name="MaterialID" class="form-select">
                                            <option value="" disabled selected style="text-align: center;">-- Selecciona un Material --</option>
                                            <?php
                                            $material = mysqli_query($conn, "SELECT MaterialID, NumParte, FraccionArancelaria FROM materiales");

                                            while ($datos = mysqli_fetch_array($material)) {
                                            ?>
                                                <option value="<?php echo $datos['MaterialID']; ?>">
                                                    <?php echo $datos['NumParte'] . ' - ' . $datos['FraccionArancelaria']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ProductoID" class="form-label">Producto:</label>
                                        <select name="ProductoID" id="ProductoID" class="form-select">
                                            <option value="" disabled selected style="text-align: center;">-- Seleccione un producto --</option>
                                            <?php
                                            $Producto = mysqli_query($conn, "SELECT ProductoID, DescripcionProducto, FraccionArancelaria FROM productos");

                                            while ($datos = mysqli_fetch_array($Producto)) {
                                            ?>
                                                <option value="<?php echo $datos['ProductoID']; ?>">
                                                    <?php echo $datos['DescripcionProducto'] . ' - ' . $datos['FraccionArancelaria']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="CantidadEntradaAduana" class="form-label">Cantidad de Entrada:</label>
                                        <input type="text" class="form-control" id="CantidadEntradaAduana" name="CantidadEntradaAduana" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ProveedorID" class="form-label">Proveedor:</label>
                                        <select name="ProveedorID" class="form-select" required>
                                            <option value="" disabled selected style="text-align: center;">-- Selecciona un Proveedor --</option>
                                            <?php
                                            $prove = mysqli_query($conn, "SELECT ProveedorID, NumClaveIdentificacionEmpresa, NombreRazonSocial FROM proveedores");

                                            while ($datos = mysqli_fetch_array($prove)) {
                                            ?>
                                                <option value="<?php echo $datos['ProveedorID']; ?>">
                                                    <?php echo $datos['NumClaveIdentificacionEmpresa'] . ' - ' . $datos['NombreRazonSocial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
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
                                        <label for="PaisOrigenMercancia" class="form-label">País de Origen de la Mercancía:</label>
                                        <input type="text" class="form-control" id="PaisOrigenMercancia" name="PaisOrigenMercancia" required>
                                    </div>


                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipoImpuesto" class="form-label">Tipo de Impuesto:</label>
                                        <select name="tipoImpuesto" class="form-select" required>
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
                                        <label for="FacturaComercial" class="form-label">Factura Comercial:</label>
                                        <input type="text" class="form-control" id="FacturaComercial" name="FacturaComercial" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="SubmanufacturaID" class="form-label">Submanufactura:</label>
                                        <select name="SubmanufacturaID" class="form-select" required>
                                            <option value="" disabled selected style="text-align: center;">-- Selecciona un Submanufactura --</option>
                                            <?php
                                            $contrib = mysqli_query($conn, "SELECT SubmanufacturaID, NumClaveIdentificacion, NumAutorizacionSE FROM submanufactura");

                                            while ($datos = mysqli_fetch_array($contrib)) {
                                            ?>
                                                <option value="<?php echo $datos['SubmanufacturaID']; ?>">
                                                    <?php echo $datos['NumClaveIdentificacion'] . ' - ' . $datos['NumAutorizacionSE']; ?>
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
                                                <label for="AvisoElectronico" class="form-label">Aviso Electrónico:</label>
                                                <input type="text" class="form-control" id="AvisoElectronico" name="AvisoElectronico">
                                            </div>
                                            <div class="form-group">
                                                <label for="FechaCruce" class="form-label">Fecha de Cruce:</label>
                                                <input type="date" class="form-control" id="FechaCruce" name="FechaCruce">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="AgenteAduanalID" class="form-label">Agente Aduanal:</label>
                                        <select name="AgenteAduanalID" class="form-select" required>
                                            <option value="" disabled selected style="text-align: center;">-- Selecciona un agente --</option>
                                            <?php
                                            $prove = mysqli_query($conn, "SELECT AgenteAduanalID, NombreAgenteAduanal, ApellidoPaterno FROM agentesaduanales");

                                            while ($datos = mysqli_fetch_array($prove)) {
                                            ?>
                                                <option value="<?php echo $datos['AgenteAduanalID']; ?>">
                                                    <?php echo $datos['NombreAgenteAduanal'] . ' ' . $datos['ApellidoPaterno']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Registrar Agente</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modales de edición  -->
        <?php
        $query = mysqli_query($conn, $consultar);
        while ($row = mysqli_fetch_array($query)) {
        ?>
            <div class="modal fade" id="editarModal<?php echo $row['AduanaEntradaID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Entrada</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="editarAduanaEntrada.php" method="POST">
                                <div class="row">
                                    <div class="col-md-4">
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
                                            <label for="ClavePedimento" class="form-label">Clave de Pedimento:</label>
                                            <input type="text" class="form-control" id="ClavePedimento" name="ClavePedimento" value="<?php echo $row['ClavePedimento']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="FechaPedimento" class="form-label">Fecha de Pedimento:</label>
                                            <input type="date" class="form-control" id="FechaPedimento" name="FechaPedimento" value="<?php echo $row['FechaPedimento']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="material" class="form-label">Material</label>
                                            <select class="form-control" name="material">
                                                <option vvalue="" disabled selected>Seleccione un material</option>
                                                <?php
                                                $consulta_materiales = mysqli_query($conn, "SELECT MaterialID, DescripcionMaterial FROM materiales");

                                                while ($datos = mysqli_fetch_array($consulta_materiales)) {
                                                ?>
                                                    <option value="<?php echo $datos['MaterialID']; ?>" <?php echo ($datos['MaterialID'] == $row['MaterialID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['DescripcionMaterial']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="ProductoID" class="form-label">Producto</label>
                                            <select class="form-control" name="ProductoID">
                                                <option value="" disabled selected>--Seleccione un producto--</option>
                                                <?php
                                                $consulta_producto = mysqli_query($conn, "SELECT ProductoID, FraccionArancelaria, DescripcionProducto FROM productos");

                                                while ($datos = mysqli_fetch_array($consulta_producto)) {
                                                ?>
                                                    <option value="<?php echo $datos['ProductoID']; ?>" <?php echo ($datos['ProductoID'] == $row['ProductoID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['FraccionArancelaria']; ?> - <?php echo $datos['DescripcionProducto']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="CantidadEntradaAduana" class="form-label">Cantidad de Entrada:</label>
                                            <input type="text" class="form-control" id="CantidadEntradaAduana" name="CantidadEntradaAduana" value="<?php echo $row['CantidadEntradaAduana']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="proveedor" class="form-label">Proveedor</label>
                                            <select class="form-control" name="proveedor">
                                                <option value="" disabled selected>Seleccione un proveedor</option>
                                                <?php
                                                $consulta_proveedor = mysqli_query($conn, "SELECT ProveedorID, NombreRazonSocial FROM proveedores");

                                                while ($datos = mysqli_fetch_array($consulta_proveedor)) {
                                                ?>
                                                    <option value="<?php echo $datos['ProveedorID']; ?>" <?php echo ($datos['ProveedorID'] == $row['ProveedorID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['NombreRazonSocial']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ContribuyenteID" class="form-label">Contribuyente:</label>
                                            <select class="form-control" required="required" name="ContribuyenteID">
                                                <option value="" disabled selected>----Seleccionar----</option>
                                                <?php
                                                $contribuyente = mysqli_query($conn, "SELECT ContribuyenteID, DenominacionRazonSocial, ClaveRFC FROM contribuyente");

                                                while ($datos = mysqli_fetch_array($contribuyente)) {
                                                ?>
                                                    <option value="<?php echo $datos['ContribuyenteID']; ?>" <?php echo ($row['ContribuyenteID'] == $datos['ContribuyenteID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['DenominacionRazonSocial']; ?> - RFC: <?php echo $datos['ClaveRFC']; ?>
                                                    </option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="PaisOrigenMercancia" class="form-label">País de Origen de la Mercancía:</label>
                                            <input type="text" class="form-control" id="PaisOrigenMercancia" name="PaisOrigenMercancia" value="<?php echo $row['PaisOrigenMercancia']; ?>" required>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipoImpuesto" class="form-label">Tipo de Impuesto:</label>
                                            <select id="tipoImpuesto" name="tipoImpuesto" class="form-control">
                                                <option hidden value="<?php echo $row['tipoImpuesto']; ?> " required> <?php echo $row['tipoImpuesto']; ?></option>
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
                                            <label for="FacturaComercial" class="form-label">Factura Comercial:</label>
                                            <input type="text" class="form-control" id="FacturaComercial" name="FacturaComercial" value="<?php echo $row['FacturaComercial']; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="SubmanufacturaID" class="form-label">Submanufactura:</label>
                                            <select class=" form-control" required="required" name="SubmanufacturaID">
                                                <option value="" disabled selected>----Seleccionar----</option>
                                                <?php
                                                $Sumbma = mysqli_query($conn, "SELECT SubmanufacturaID, NumClaveIdentificacion, NumAutorizacionSE FROM submanufactura");

                                                while ($datos = mysqli_fetch_array($Sumbma)) {
                                                ?>
                                                    <option value="<?php echo $datos['SubmanufacturaID']; ?>" <?php echo ($row['SubmanufacturaID'] == $datos['SubmanufacturaID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['NumClaveIdentificacion']; ?> - <?php echo $datos['NumAutorizacionSE']; ?>
                                                    </option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="AvisoElectronico" class="form-label">Aviso Electrónico:</label>
                                            <input type="text" class="form-control" id="AvisoElectronico" name="AvisoElectronico" value="<?php echo $row['AvisoElectronico']; ?>">
                                        </div>
                                        <div class=" form-group">
                                            <label for="FechaCruce" class="form-label">Fecha de Cruce:</label>
                                            <input type="date" class="form-control" id="FechaCruce" name="FechaCruce" value="<?php echo $row['FechaCruce']; ?>">
                                        </div>

                                        <div class=" form-group">
                                            <label for="AgenteAduanalID" class="form-label">Agente Aduanal:</label>
                                            <select class="form-control" required="required" name="AgenteAduanalID">
                                                <option value="" disabled selected>----Seleccionar----</option>
                                                <?php
                                                $agente = mysqli_query($conn, "SELECT AgenteAduanalID, NombreAgenteAduanal, ApellidoPaterno FROM agentesaduanales");

                                                while ($datos = mysqli_fetch_array($agente)) {
                                                ?>
                                                    <option value="<?php echo $datos['AgenteAduanalID']; ?>" <?php echo ($row['AgenteAduanalID'] == $datos['AgenteAduanalID']) ? 'selected' : ''; ?>>
                                                        <?php echo $datos['NombreAgenteAduanal']; ?> - <?php echo $datos['ApellidoPaterno']; ?>
                                                    </option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="AduanaEntradaID" value="<?php echo $row['AduanaEntradaID']; ?>">
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