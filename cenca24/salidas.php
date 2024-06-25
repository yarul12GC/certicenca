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

    <title>Salidas</title>
</head>

<body>
    <header>
        <?php include 'vistas/cabeza.php'; ?>
    </header>

    <section class="contenedor">
        <h3><strong>Datos de Salida</strong></h3>
        <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Registar salida
        </button>

        <?php
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

        $sql = "SELECT i.InterfaseSalidaID, m.DescripcionMaterial, i.Cantidad, i.MontoDolares, c.DenominacionRazonSocial AS NombreRazonSocial, cl.NombreRazonSocial AS DenominacionRazonSocial
            FROM interfasesalidas i
            INNER JOIN materiales m ON i.MaterialID = m.MaterialID
            LEFT JOIN contribuyente c ON i.ContribuyenteID = c.ContribuyenteID
            LEFT JOIN clientes cl ON i.ClienteID = cl.ClienteID";

        $result = mysqli_query($conn, $sql);
        ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Interfase Salida ID</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Monto en Dólares</th>
                    <th>Contribuyente</th>
                    <th>Cliente</th>
                    <th>Obciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['InterfaseSalidaID']}</td>";
                    echo "<td>{$row['DescripcionMaterial']}</td>";
                    echo "<td>{$row['Cantidad']}</td>";
                    echo "<td>{$row['MontoDolares']}</td>";
                    echo "<td>{$row['DenominacionRazonSocial']}</td>";
                    echo "<td>{$row['NombreRazonSocial']}</td>";
                    echo " <td>
                            <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#Modaleditar" . $row["InterfaseSalidaID"] . "'>
                                <img src='assets/media/editar.png' width='15px' height='15px'>
                            </button>
                            <button type='button' class='btn btn-danger btn-sm' onclick='confirmarEliminar(" . $row["InterfaseSalidaID"] . ")'>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Salida</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesar_salida.php" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="InterfaseEntradaID" class="form-label">Entrada</label>
                                    <select class="form-control" name="entrada_id" id="entrada">
                                        <option value="">Seleccione una entrada</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_entradas = "SELECT e.InterfaseEntradaID, CONCAT(m.DescripcionMaterial, ' - ', e.Cantidad) AS DescripcionEntrada 
                                                    FROM interfaseentradas e
                                                    INNER JOIN materiales m ON e.MaterialID = m.MaterialID
                                                    ORDER BY m.DescripcionMaterial";

                                        $resultado_entradas = mysqli_query($conn, $consulta_entradas);
                                        while ($fila = mysqli_fetch_assoc($resultado_entradas)) {
                                            echo "<option value=\"{$fila['InterfaseEntradaID']}\">{$fila['DescripcionEntrada']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="material" class="form-label">Material</label>
                                    <select class="form-control" name="material" required>
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
                                    <select class="form-control" name="producto" required>
                                        <option value="">Seleccione un producto</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_productos = "SELECT ProductoID, DescripcionProducto FROM productos";
                                        $resultado_productos = mysqli_query($conn, $consulta_productos);
                                        while ($fila = mysqli_fetch_assoc($resultado_productos)) {
                                            echo "<option value=\"{$fila['ProductoID']}\">{$fila['DescripcionProducto']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cantidad" class="form-label">Cantidad de salida</label>
                                    <input type="number" class="form-control" name="cantidad" required>
                                </div>
                                <div class="form-group">
                                    <label for="unidad_medida" class="form-label">Unidad de Medida Comercialización:</label>
                                    <select name="unidad_medida" class="form-select" required>
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
                                    <input type="number" step="0.01" class="form-control" name="monto" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_recibo" class="form-label">Fecha de Recibo</label>
                                    <input type="date" class="form-control" name="fecha_recibo" required>
                                </div>
                                <div class="form-group">
                                    <label for="proveedor" class="form-label">Proveedor</label>
                                    <select class="form-control" name="proveedor" required>
                                        <option value="">Seleccione un proveedor</option>
                                        <?php
                                        include('conexion.php');
                                        $consulta_proveedores = "SELECT ProveedorID, NombreRazonSocial FROM proveedores";
                                        $resultado_proveedores = mysqli_query($conn, $consulta_proveedores);
                                        while ($fila = mysqli_fetch_assoc($resultado_proveedores)) {
                                            echo "<option value=\"{$fila['ProveedorID']}\">{$fila['NombreRazonSocial']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cliente" class="form-label">Cliente</label>
                                    <select class="form-control" name="cliente" required>
                                        <option value="">Seleccione un cliente</option>
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
                                    <label for="num_factura" class="form-label">Número de Factura de Control Recibo</label>
                                    <input type="text" class="form-control" name="num_factura_control_recibo" required>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="orden_compra" class="form-label">Orden de Compra</label>
                                    <input type="text" class="form-control" name="orden_compra" required>
                                </div>
                                <div class="form-group">
                                    <label for="identificador" class="form-label">Identificador de Sistema Corporativo</label>
                                    <input type="text" class="form-control" name="identificador_sistema_corporativo" required>
                                </div>
                                <div class="form-group">
                                    <label for="contribuyente" class="form-label">Contribuyente</label>
                                    <select class="form-control" name="contribuyente" required>
                                        <option value="">Seleccione un contribuyente</option>
                                        <?php
                                        include('conexion.php');
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

                            <button type="submit" class="btn btn-primary">Registrar Salida</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </div>




    <!-- Button trigger modal -->

    <?php
    $consultar_entrada = "SELECT * FROM interfasesalidas";
    $query = mysqli_query($conn, $consultar_entrada);

    while ($row1 = mysqli_fetch_assoc($query)) {
    ?>
        <!-- Modal -->
        <div class="modal fade" id="Modaleditar<?php echo $row1['InterfaseSalidaID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Salidas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editar_salida.php" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="entrada" class="form-label">Entrada</label>
                                        <select class="form-control" name="entrada_id">
                                            <?php
                                            include('conexion.php');
                                            $consulta_entradas = "SELECT e.InterfaseEntradaID, CONCAT(m.DescripcionMaterial, ' - ', e.Cantidad) AS DescripcionEntrada 
                                                    FROM interfaseentradas e
                                                    INNER JOIN materiales m ON e.MaterialID = m.MaterialID
                                                    ORDER BY m.DescripcionMaterial";

                                            $resultado_entradas = mysqli_query($conn, $consulta_entradas);
                                            // Agrega una opción oculta por defecto si es necesario
                                            echo "<option hidden value=''>Seleccionar una entrada</option>";
                                            while ($fila = mysqli_fetch_assoc($resultado_entradas)) {
                                                $selected = ($fila['InterfaseEntradaID'] == $row1['InterfaseEntradaID']) ? 'selected' : '';
                                                echo "<option value=\"{$fila['InterfaseEntradaID']}\" $selected>{$fila['DescripcionEntrada']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="material" class="form-label">Material</label>
                                        <select class="form-control" name="material">
                                            <option value="">Seleccione un material</option>
                                            <?php
                                            $consulta_materiales = mysqli_query($conn, "SELECT MaterialID, DescripcionMaterial FROM materiales");

                                            while ($datos = mysqli_fetch_array($consulta_materiales)) {
                                            ?>
                                                <option value="<?php echo $datos['MaterialID']; ?>" <?php echo ($datos['MaterialID'] == $row1['MaterialID']) ? 'selected' : ''; ?>>
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
                                            <option value="">Seleccione un producto</option>
                                            <?php
                                            $consulta_producto = mysqli_query($conn, "SELECT ProductoID, DescripcionProducto FROM productos");

                                            while ($datos = mysqli_fetch_array($consulta_producto)) {
                                            ?>
                                                <option value="<?php echo $datos['ProductoID']; ?>" <?php echo ($datos['ProductoID'] == $row1['ProductoID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['DescripcionProducto']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cantidad" class="form-label">Cantidad de salida</label>
                                        <input type="number" class="form-control" name="cantidad" value="<?php echo $row1['Cantidad']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="unidad_medida" class="form-label">Unidad de Medida Comercialización:</label>
                                        <select name="unidad_medida" class="form-select" required>
                                            <option hidden value="<?php echo $row1['UnidadMedidaComercializacion']; ?> " required> <?php echo $row1['UnidadMedidaComercializacion']; ?></option>
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
                                        <input type="number" step="0.01" class="form-control" name="monto" value="<?php echo $row1['MontoDolares']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_recibo" class="form-label">Fecha de Recibo</label>
                                        <input type="date" class="form-control" name="fecha_recibo" value="<?php echo isset($row1['FechaRecibo']) ? date('Y-m-d', strtotime($row1['FechaRecibo'])) : date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="ProveedorID" class="form-label">Proveedor:</label>
                                        <select class="form-control" name="ProveedorID">

                                            <?php
                                            $proveedores = mysqli_query($conn, "SELECT ProveedorID, NumClaveIdentificacionEmpresa, NombreRazonSocial FROM proveedores");

                                            while ($datos = mysqli_fetch_array($proveedores)) {
                                            ?>
                                                <option value="<?php echo $datos['ProveedorID']; ?>" <?php echo ($row1['ProveedorID'] == $datos['ProveedorID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumClaveIdentificacionEmpresa']; ?> - <?php echo $datos['NombreRazonSocial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ClienteID" class="form-label">Cliente:</label>
                                        <select class="form-control" name="ClienteID">

                                            <?php
                                            $clientes = mysqli_query($conn, "SELECT ClienteID, NumClaveIdentificacion, NombreRazonSocial FROM clientes");

                                            while ($datos = mysqli_fetch_array($clientes)) {
                                            ?>
                                                <option value="<?php echo $datos['ClienteID']; ?>" <?php echo ($row1['ClienteID'] == $datos['ClienteID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumClaveIdentificacion']; ?> - <?php echo $datos['NombreRazonSocial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="num_factura" class="form-label">Número de Factura de Control Recibo</label>
                                        <input type="text" class="form-control" name="num_factura_control_recibo" value="<?php echo $row1['NumFacturaControlRecibo']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="orden_compra" class="form-label">Orden de Compra</label>
                                        <input type="text" class="form-control" name="orden_compra" value="<?php echo $row1['OrdenCompra']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="identificador" class="form-label">Identificador de Sistema Corporativo</label>
                                        <input type="text" class="form-control" name="identificador_sistema_corporativo" value="<?php echo $row1['IdentificadorSistemaCorporativo']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="ContribuyenteID" class="form-label">Contribuyente:</label>
                                        <select class="form-control" required="required" name="ContribuyenteID">

                                            <?php
                                            $contribuyente = mysqli_query($conn, "SELECT ContribuyenteID, DenominacionRazonSocial, ClaveRFC FROM contribuyente");

                                            while ($datos = mysqli_fetch_array($contribuyente)) {
                                            ?>
                                                <option value="<?php echo $datos['ContribuyenteID']; ?>" <?php echo ($row1['ContribuyenteID'] == $datos['ContribuyenteID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['DenominacionRazonSocial']; ?> - RFC: <?php echo $datos['ClaveRFC']; ?>
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