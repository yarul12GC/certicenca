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
    <title>Entradas</title>
</head>

<body>
    <header>
        <?php include 'vistas/cabeza.php' ?>
    </header>
    <section class="contenedor">
        <?php
        //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>lLa entrada se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el usuario.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>La nueva entrada se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar la nueva entrada.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
        </script>";
        }
        ?>

        <h3><strong>Datos de Entrada</strong></h3>
        <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Registrar entrada
        </button>

        <?php
        $sql = "SELECT ie.InterfaseEntradaID, m.DescripcionMaterial, ie.Cantidad, ie.MontoDolares, pr.NombreRazonSocial 
                            FROM interfaseentradas ie
                            INNER JOIN materiales m ON ie.MaterialID = m.MaterialID
                            INNER JOIN proveedores pr ON ie.ProveedorID = pr.ProveedorID";

        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            echo '<table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Entrada ID</th>
                                        <th>Material</th>
                                        <th>Cantidad</th>
                                        <th>Monto en Dolares</th>
                                        <th>Proveedor</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                                    <td>" . $fila["InterfaseEntradaID"] . "</td>
                                    <td>" . $fila["DescripcionMaterial"] . "</td>
                                    <td>" . $fila["Cantidad"] . "</td>
                                    <td>" . $fila["MontoDolares"] . "</td>
                                    <td>" . $fila["NombreRazonSocial"] . "</td>
                                    <td>
                                        <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#Modaleditar" . $fila["InterfaseEntradaID"] . "'>
                                            <img src='assets/media/editar.png' width='15px' height='15px'>
                                        </button>
                                        <button type='button' class='btn btn-danger btn-sm' onclick='confirmarEliminar(" . $fila["InterfaseEntradaID"] . ")'>
                                            <img src='assets/media/eliminar.png' width='15px' height='15px'>
                                        </button>
                                    </td>
                                </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "No se encontraron resultados.";
        }

        ?>
    </section>

    <footer>
        <?php include 'vistas/footer.php' ?>
    </footer>
    <!-- Modal registro -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Entrada</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insertar_interfase.php" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="material" class="form-label">Material</label>
                                    <select class="form-control" name="material">
                                        <option value="">Seleccione un material</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_materiales = "SELECT MaterialID, DescripcionMaterial FROM materiales";
                                        $resultado_materiales = mysqli_query($conn, $consulta_materiales);
                                        while ($fila = mysqli_fetch_assoc($resultado_materiales)) {
                                            echo "<option value=\"{$fila['MaterialID']}\">{$fila['DescripcionMaterial']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="producto" class="form-label">Producto</label>
                                    <select class="form-control" name="ProductoID" id="producto">
                                        <option value="">Seleccione un producto</option>
                                        <?php
                                        $consulta_producto = "SELECT ProductoID, DescripcionProducto FROM productos";
                                        $resultado_producto = mysqli_query($conn, $consulta_producto);
                                        while ($fila = mysqli_fetch_assoc($resultado_producto)) {
                                            echo "<option value=\"{$fila['ProductoID']}\">{$fila['DescripcionProducto']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type="text" class="form-control" name="cantidad" required>
                                </div>
                                <div class="form-group">
                                    <label for="UnidadMedidaComercializacion" class="form-label">Unidad de Medida Comercialización:</label>
                                    <select name="UnidadMedidaComercializacion" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">----Seleccionar----</option>
                                        <option value="KG">Kilogramo (KG)</option>
                                        <option value="GR">Gramo (GR)</option>
                                        <option value="L">Litro (L)</option>
                                        <option value="M3">Metro cúbico (M3)</option>
                                        <option value="M">Metro (M)</option>
                                        <option value="CM">Centímetro (CM)</option>
                                        <option value="M2">Metro cuadrado (M2)</option>
                                        <option value="CM2">Centímetro cuadrado (CM2)</option>
                                        <option value="PZA">Pieza (PZA)</option>
                                        <option value="DZ">Docena (DZ)</option>
                                        <option value="MLL">Millar (MLL)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="monto" class="form-label">Monto en Dólares</label>
                                    <input type="text" class="form-control" name="monto">
                                </div>
                                <div class="form-group">
                                    <label for="fecha" class="form-label">Fecha de Recibo</label>
                                    <input type="date" class="form-control" name="fecha" required>
                                </div>
                                <div class="form-group">
                                    <label for="ClienteID" class="form-label">cliente</label>
                                    <select class="form-control" name="ClienteID" required>
                                        <option value="" disabled selected style="text-align: center;">--Seleccione un cliente--</option>
                                        <?php
                                        $consulta_cliente = "SELECT ClienteID, NombreRazonSocial FROM clientes";
                                        $resultado_cliente = mysqli_query($conn, $consulta_cliente);
                                        while ($fila = mysqli_fetch_assoc($resultado_cliente)) {
                                            echo "<option value=\"{$fila['ClienteID']}\">{$fila['NombreRazonSocial']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="proveedor" class="form-label">Proveedor</label>
                                    <select class="form-control" name="proveedor">
                                        <option value="" disabled selected style="text-align: center;">--Seleccione un proveedor--</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_proveedor = "SELECT ProveedorID, NombreRazonSocial FROM proveedores";
                                        $resultado_proveedor = mysqli_query($conn, $consulta_proveedor);
                                        while ($fila = mysqli_fetch_assoc($resultado_proveedor)) {
                                            echo "<option value=\"{$fila['ProveedorID']}\">{$fila['NombreRazonSocial']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="num_factura" class="form-label">Número de Factura de Control de Recibo</label>
                                    <input type="text" class="form-control" name="num_factura" required>
                                </div>
                                <div class="form-group">
                                    <label for="orden_compra" class="form-label">Orden de Compra</label>
                                    <input type="text" class="form-control" name="orden_compra" required>
                                </div>
                                <div class="form-group">
                                    <label for="orden_compra" class="form-label">Identificador Sistema Corporativo</label>
                                    <input type="text" class="form-control" name="IdentificadorSistemaCorporativo" required>
                                </div>
                                <div class="form-group">
                                    <label for="ContribuyenteID" class="form-label">Contribuyente</label>
                                    <select class="form-control" name="ContribuyenteID" required>
                                        <option value="" disabled selected style="text-align: center;">--Seleccione un contribuyente--</option>
                                        <?php
                                        $consulta_contribuyentes = "SELECT ContribuyenteID, DenominacionRazonSocial FROM contribuyente";
                                        $resultado_contribuyentes = mysqli_query($conn, $consulta_contribuyentes);
                                        while ($fila = mysqli_fetch_assoc($resultado_contribuyentes)) {
                                            echo "<option value=\"{$fila['ContribuyenteID']}\">{$fila['DenominacionRazonSocial']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div><br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar Entrada</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php
    $consultar_entrada = "SELECT * FROM interfaseentradas";
    $query = mysqli_query($conn, $consultar_entrada);

    while ($row = mysqli_fetch_assoc($query)) {
    ?>
        <!-- Modal -->
        <div class="modal fade" id="Modaleditar<?php echo $row['InterfaseEntradaID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Entrada</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editar_fase.php" method="POST">
                            <input type="hidden" class="form-control" name="InterfaseEntradaID" value="<?php echo isset($row['InterfaseEntradaID']) ? $row['InterfaseEntradaID'] : ''; ?>" required>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="material" class="form-label">Material</label>
                                        <select class="form-control" name="material">
                                            <option value="" disabled selected>--Seleccione un material--</option>
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
                                        <label for="producto" class="form-label">Producto</label>
                                        <select class="form-control" name="ProductoID">
                                            <option value="" disabled selected>--Seleccione un producto--</option>
                                            <?php
                                            $consulta_producto = mysqli_query($conn, "SELECT ProductoID, DescripcionProducto FROM productos");

                                            while ($datos = mysqli_fetch_array($consulta_producto)) {
                                            ?>
                                                <option value="<?php echo $datos['ProductoID']; ?>" <?php echo ($datos['ProductoID'] == $row['ProductoID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['DescripcionProducto']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="text" class="form-control" name="cantidad" value="<?php echo isset($row['Cantidad']) ? $row['Cantidad'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="UnidadMedidaComercializacion" class="form-label">Unidad de Medida Comercialización:</label>
                                        <select name="UnidadMedidaComercializacion" class="form-select" required>
                                            <option value="" disabled selected>--Seleccionar unidad--</option>
                                            <?php
                                            $unidad = isset($row['UnidadMedidaComercializacion']) ? $row['UnidadMedidaComercializacion'] : '';
                                            $unidades = array("KG", "GR", "L", "M3", "M", "CM", "M2", "CM2", "PZA", "DZ", "MLL");
                                            foreach ($unidades as $u) {
                                                echo "<option value='$u' " . ($unidad == $u ? 'selected' : '') . ">$u</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="monto" class="form-label">Monto en Dólares</label>
                                        <input type="text" class="form-control" name="monto" value="<?php echo isset($row['MontoDolares']) ? $row['MontoDolares'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha" class="form-label">Fecha de Recibo</label>
                                        <input type="date" class="form-control" name="fecha" value="<?php echo isset($row['FechaRecibo']) ? date('Y-m-d', strtotime($row['FechaRecibo'])) : date('Y-m-d'); ?>" required max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="proveedor" class="form-label">Proveedor</label>
                                        <select class="form-control" name="proveedor">
                                            <option value="" disabled selected>--Seleccione un proveedor--</option>
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
                                        <label for="num_factura" class="form-label">Número de Factura de Control de Recibo</label>
                                        <input type="text" class="form-control" name="num_factura" value="<?php echo isset($row['NumFacturaControlRecibo']) ? $row['NumFacturaControlRecibo'] : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="orden_compra" class="form-label">Orden de Compra</label>
                                        <input type="text" class="form-control" name="orden_compra" value="<?php echo isset($row['OrdenCompra']) ? $row['OrdenCompra'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="IdentificadorSistemaCorporativo" class="form-label">Identificador de Sistema Corporativo</label>
                                        <input type="text" class="form-control" name="IdentificadorSistemaCorporativo" value="<?php echo isset($row['IdentificadorSistemaCorporativo']) ? $row['IdentificadorSistemaCorporativo'] : ''; ?>" required>
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
                                                    <?php echo $datos['NombreRazonSocial']; ?> - RFC: <?php echo $datos['NumClaveIdentificacion']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
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