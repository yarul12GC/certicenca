<?php
include 'startSession.php';
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/media/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="assets/styles.css">
    <title>Informacion Aduenara</title>
</head>

<body>
    <header>
        <?php include 'vistas/cabeza.php'; ?>

    </header>
    <section class="contenedor">
        <?php
        //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>lLa informacion aduanera se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar de La informacion aduanera.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>La nueva La informacion aduanera se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar La informacion aduanera.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
        </script>";
        }
        ?>
        <h3><strong>Informacion Aduenara (Salidas)</strong></h3>
        <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#exampleModal">Registar Informacion</button>





        <!-- Tabla HTML con los datos -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Aduana Salida ID</th>
                    <th>Número de Pedimento</th>
                    <th>Fecha de Pedimento</th>
                    <th>Clave de Pedimento</th>
                    <th>País de Destino de la Mercancía</th>
                    <th>Obciones</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM aduanasalidas";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['AduanaSalidaID']}</td>";
                    echo "<td>{$row['NumeroPedimento']}</td>";
                    echo "<td>{$row['FechaPedimento']}</td>";
                    echo "<td>{$row['ClavePedimento']}</td>";
                    echo "<td>{$row['PaisOrigenMercancia']}</td>";
                    echo " <td>
                            <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#Modaleditar" . $row["AduanaSalidaID"] . "'>
                                <img src='assets/media/editar.png' width='15px' height='15px'>
                            </button>
                            <button type='button' class='btn btn-danger btn-sm' onclick='confirmarEliminar(" . $row["AduanaSalidaID"] . ")'>
                                <img src='assets/media/eliminar.png' width='15px' height='15px'>
                            </button>
                        </td> ";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </section>
    <footer>
        <?php include 'vistas/footer.php'; ?>
    </footer>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registar Informacion Aduanera (Salida)</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesar_formularioadunas.php" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="AduanaEntradaID" class="form-label">Informacion Aduanera de entrada</label>
                                    <select class="form-control" name="AduanaEntradaID">
                                        <option value="" disabled selected style="text-align: center;">--Seleccione una entrada--</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_entradain = "SELECT AduanaEntradaID, ClavePedimento FROM aduanaentradas";
                                        $resultado_entradain = mysqli_query($conn, $consulta_entradain);
                                        while ($fila = mysqli_fetch_assoc($resultado_entradain)) {
                                            echo "<option value=\"{$fila['AduanaEntradaID']}\">{$fila['ClavePedimento']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="NumeroPedimento" class="form-label">Número de Pedimento:</label>
                                    <input type="text" class="form-control" id="NumeroPedimento" name="NumeroPedimento" required>
                                </div>
                                <div class="form-group">
                                    <label for="ClavePedimento" class="form-label">Clave de Pedimento:</label>
                                    <input type="text" class="form-control" id="ClavePedimento" name="ClavePedimento" required>
                                </div>
                                <div class="form-group">
                                    <label for="FechaPedimento" class="form-label">Fecha de Pedimento:</label>
                                    <input type="date" class="form-control" id="FechaPedimento" name="FechaPedimento" required>
                                </div>

                                <div class="form-group">
                                    <label for="MaterialID" class="form-label">Material:</label>
                                    <select name="MaterialID" id="MaterialID" class="form-select">
                                        <option vvalue="" disabled selected style="text-align: center;">--Seleccione un material --</option>
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

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CantidadSalidaAd" class="form-label">Cantidad de salida:</label>
                                    <input type="number" class="form-control" id="CantidadSalidaAd" name="CantidadSalidaAd" required>
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

                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="FacturaComercial" class="form-label">Factura Comercial:</label>
                                    <input type="text" class="form-control" id="FacturaComercial" name="FacturaComercial" required>
                                </div>

                                <div class="form-group">
                                    <label for="AvisoElectronico" class="form-label">Aviso Electrónico:</label>
                                    <input type="text" class="form-control" id="AvisoElectronico" name="AvisoElectronico" required>
                                </div>
                                <div class="form-group">
                                    <label for="FechaCruce" class="form-label">Fecha de Cruce:</label>
                                    <input type="date" class="form-control" id="FechaCruce" name="FechaCruce" required>
                                </div>
                                <div class="form-group">
                                    <label for="ClienteID" class="form-label">Cliente</label>
                                    <select class="form-control" name="ClienteID" required>
                                        <option value="" disabled selected style="text-align: center;">--Seleccione un cliente--</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_cliente = "SELECT ClienteID, NombreRazonSocial FROM clientes";
                                        $resultado_cliente = mysqli_query($conn, $consulta_cliente);
                                        while ($fila = mysqli_fetch_assoc($resultado_cliente)) {
                                            echo "<option value=\"{$fila['ClienteID']}\">{$fila['NombreRazonSocial']}</option>";
                                        }
                                        ?>
                                    </select>
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
                                    <label for="AgenteAduanalID" class="form-label">Agente Aduanal:</label>
                                    <select name="AgenteAduanalID" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">-- Selecciona un Agente Aduanal --</option>
                                        <?php
                                        $contrib = mysqli_query($conn, "SELECT AgenteAduanalID, NumPatenteAutorizacion, NombreAgenteAduanal FROM agentesaduanales");

                                        while ($datos = mysqli_fetch_array($contrib)) {
                                        ?>
                                            <option value="<?php echo $datos['AgenteAduanalID']; ?>">
                                                <?php echo $datos['NumPatenteAutorizacion'] . ' - ' . $datos['NombreAgenteAduanal']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar Salida</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <?php
    $consultar_infoadu = "SELECT * FROM aduanasalidas";
    $query = mysqli_query($conn, $consultar_infoadu);

    while ($row = mysqli_fetch_assoc($query)) {
    ?>
        <!-- Modal editar -->
        <div class="modal fade" id="Modaleditar<?php echo $row['AduanaSalidaID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Aduana Salida</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="adunasaedi.php" method="POST">
                            <input type="hidden" name="aduana_salida_id" value="<?php echo $row['AduanaSalidaID']; ?>">
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="AduanaEntradaID" class="form-label">Información Aduanera de entrada</label>
                                        <select class="form-control" name="AduanaEntradaID">
                                            <option value="" disabled selected>--Seleccione una entrada--</option>
                                            <?php
                                            $consulta_entrada = mysqli_query($conn, "SELECT AduanaEntradaID, NumeroPedimento, ClavePedimento FROM aduanaentradas");

                                            while ($datos = mysqli_fetch_array($consulta_entrada)) {
                                            ?>
                                                <option value="<?php echo $datos['AduanaEntradaID']; ?>" <?php echo ($datos['AduanaEntradaID'] == $row['AduanaEntradaID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumeroPedimento']; ?> - <?php echo $datos['ClavePedimento']; ?>
                                                <?php
                                            }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="num_pedimento" class="form-label">Número de Pedimento</label>
                                        <input type="text" class="form-control" name="num_pedimento" value="<?php echo $row['NumeroPedimento']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="clave_pedimento" class="form-label">Clave de Pedimento</label>
                                        <input type="text" class="form-control" name="clave_pedimento" value="<?php echo $row['ClavePedimento']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_pedimento" class="form-label">Fecha de Pedimento</label>
                                        <input type="date" class="form-control" name="fecha_pedimento" value="<?php echo $row['FechaPedimento']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="MaterialID" class="form-label">Material</label>
                                        <select class="form-control" name="MaterialID">
                                            <option value="" disabled selected>--Seleccione un material--</option>
                                            <?php
                                            $consulta_materiales = mysqli_query($conn, "SELECT MaterialID, FraccionArancelaria, DescripcionMaterial FROM materiales");

                                            while ($datos = mysqli_fetch_array($consulta_materiales)) {
                                            ?>
                                                <option value="<?php echo $datos['MaterialID']; ?>" <?php echo ($datos['MaterialID'] == $row['MaterialID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['FraccionArancelaria']; ?> - <?php echo $datos['DescripcionMaterial']; ?>
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

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="CantidadSalidaAd" class="form-label">Cantidad de salida:</label>
                                        <input type="text" class="form-control" name="CantidadSalidaAd" value="<?php echo $row['CantidadSalidaAd']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pais_destino" class="form-label">País Destino de la Mercancía</label>
                                        <input type="text" class="form-control" name="pais_destino" value="<?php echo $row['PaisOrigenMercancia']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="ProveedorID" class="form-label">Proveedor</label>
                                        <select class="form-control" name="ProveedorID">
                                            <option value="" disabled selected>--Seleccione un proveedor--</option>
                                            <?php
                                            $consulta_producto = mysqli_query($conn, "SELECT ProveedorID, NumClaveIdentificacionEmpresa, NombreRazonSocial FROM proveedores");

                                            while ($datos = mysqli_fetch_array($consulta_producto)) {
                                            ?>
                                                <option value="<?php echo $datos['ProveedorID']; ?>" <?php echo ($datos['ProveedorID'] == $row['ProveedorID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumClaveIdentificacionEmpresa']; ?> - <?php echo $datos['NombreRazonSocial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="factura_comercial" class="form-label">Factura Comercial</label>
                                        <input type="text" class="form-control" name="factura_comercial" value="<?php echo $row['FacturaComercial']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="TipoImpuesto" class="form-label">Tipo de Impuesto</label>
                                        <select class="form-control" name="TipoImpuesto">
                                            <option value="<?php echo $row['tipoImpuesto']; ?>"><?php echo $row['tipoImpuesto']; ?></option>
                                            <option value="">Seleccione el tipo de impuesto</option>
                                            <option value="TIGIE">Tasa general de la TIGIE</option>
                                            <option value="Tasa preferencial">Tasa preferencial conforme algún tratado</option>
                                            <option value="PROSEC">Tasa prevista en los PROSEC</option>
                                            <option value="Regla 8a">Tasa aplicable conforme a la Regla 8a</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="TasaDeImpuesto" class="form-label">Tasa De Impuesto</label>
                                        <input type="text" class="form-control" name="TasaDeImpuesto" value="<?php echo $row['TasaDeImpuesto']; ?>" required>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="aviso_electronico" class="form-label">Aviso Electrónico de Importación/Exportación</label>
                                        <input type="text" class="form-control" name="aviso_electronico" value="<?php echo $row['AvisoElectronico']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_cruce" class="form-label">Fecha de Cruce del Aviso Electrónico</label>
                                        <input type="date" class="form-control" name="fecha_cruce" value="<?php echo $row['FechaCruce']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contribuyente_id" class="form-label">Contribuyente</label>
                                        <select class="form-control" name="contribuyente_id">
                                            <option value="" disabled selected>--Seleccione un contribuyente--</option>
                                            <?php
                                            $consulta_contribuyente = mysqli_query($conn, "SELECT ContribuyenteID, DenominacionRazonSocial, ClaveRFC FROM contribuyente");

                                            while ($datos = mysqli_fetch_array($consulta_contribuyente)) {
                                            ?>
                                                <option value="<?php echo $datos['ContribuyenteID']; ?>" <?php echo ($datos['ContribuyenteID'] == $row['ContribuyenteID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['DenominacionRazonSocial']; ?> - RFC: <?php echo $datos['ClaveRFC']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ClienteID" class="form-label">cliente</label>
                                        <select class="form-control" name="ClienteID">
                                            <option value="" disabled selected>--Seleccione un cliente--</option>
                                            <?php
                                            $consulta_cliente = mysqli_query($conn, "SELECT ClienteID, NombreRazonSocial, NumClaveIdentificacion FROM clientes");

                                            while ($datos = mysqli_fetch_array($consulta_cliente)) {
                                            ?>
                                                <option value="<?php echo $datos['ClienteID']; ?>" <?php echo ($datos['ClienteID'] == $row['ClienteID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NombreRazonSocial']; ?> - <?php echo $datos['NumClaveIdentificacion']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ClientSubmanufacturaIDeID" class="form-label">Submanufactura</label>
                                        <select class="form-control" name="SubmanufacturaID">
                                            <option value="" disabled selected>--Seleccione una submanufactura--</option>
                                            <?php
                                            $consulta_subma = mysqli_query($conn, "SELECT SubmanufacturaID, NumClaveIdentificacion, NumAutorizacionSE FROM submanufactura");

                                            while ($datos = mysqli_fetch_array($consulta_subma)) {
                                            ?>
                                                <option value="<?php echo $datos['SubmanufacturaID']; ?>" <?php echo ($datos['SubmanufacturaID'] == $row['SubmanufacturaID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumClaveIdentificacion']; ?> - <?php echo $datos['NumAutorizacionSE']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="AgenteAduanalID" class="form-label">Agente Aduanal</label>
                                        <select class="form-control" name="AgenteAduanalID">
                                            <option value="">Seleccione un agente aduanal</option>
                                            <?php
                                            $consulta_agentes = "SELECT AgenteAduanalID, NumPatenteAutorizacion, NombreAgenteAduanal FROM agentesaduanales";
                                            $resultado_agentes = mysqli_query($conn, $consulta_agentes);
                                            while ($fila = mysqli_fetch_assoc($resultado_agentes)) {
                                                $selected = ($fila['AgenteAduanalID'] == $row['AgenteAduanalID']) ? 'selected' : '';
                                                echo "<option value=\"{$fila['AgenteAduanalID']}\" {$selected}>{$fila['NumPatenteAutorizacion']} - {$fila['NombreAgenteAduanal']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>


</body>

</html>
<script>
    function confirmarEliminar(aduanaSalidaID) {
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            // Si se confirma la eliminación, enviar la solicitud al servidor
            eliminarRegistro(aduanaSalidaID);
        }
    }

    function eliminarRegistro(aduanaSalidaID) {
        // Enviar la solicitud AJAX para eliminar el registro
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminaraduanasa.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Manejar la respuesta del servidor
                console.log(xhr.responseText);
                // Puedes realizar alguna acción adicional, como actualizar la tabla o mostrar un mensaje de éxito
            }
        };
        xhr.send("aduana_salida_id=" + aduanaSalidaID);
    }
</script>