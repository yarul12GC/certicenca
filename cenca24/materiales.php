<?php
include 'startSession.php';
require 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales</title>
    <?php
    // Incluir el archivo cabeza.php
    include 'vistas/cabeza.php';
    ?>
</head>

<body>

    <section class="contenedor">
        <?php
        $consultar = "SELECT * FROM materiales ORDER BY MaterialID ASC";
        $query = mysqli_query($conn, $consultar);
        $cantidad = mysqli_num_rows($query);

        // MENSAJE DE EXITO REGISTRO Y ACTUALIZACION


        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>El material se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el material.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>El nuevo material se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo material.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('mensaje').style.display = 'none';
                    }, 2000);
                </script>";
        }
        ?>

        <h3><strong>Materiales</strong></h3>
        <section>
            <div class="float-start">
                <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#nuevoMaterial">
                    <img src="assets/media/registro.png" width="20px" height="20px"> Nuevo Registro de Material
                </button>
            </div>

            <div class="">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Número de parte o clave de identificación</th>
                            <th>Descripción del material</th>
                            <th>Fracción arancelaria</th>
                            <th>Medida de comercialización</th>
                            <th>Unidad de medida TIGIE</th>
                            <th>Tipo de material</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $row['NumParte']; ?></td>
                                <td><?php echo $row['DescripcionMaterial']; ?></td>
                                <td><?php echo $row['FraccionArancelaria']; ?></td>
                                <td><?php echo $row['UnidadMedidaComercializacion']; ?></td>
                                <td><?php echo $row['UnidadMedidaTIGIE']; ?></td>
                                <td><?php echo $row['TipoMaterial']; ?></td>

                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['MaterialID']; ?>">
                                        <img src="assets/media/editar.png" width="15px" height="15px">
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['MaterialID']; ?>)">
                                        <img src="assets/media/eliminar.png" width="15px" height="15px">
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
    <footer>
        <?php
        // Incluir el archivo cabeza.php
        include 'vistas/footer.php';
        ?>
    </footer>
    <div class="modal fade" id="nuevoMaterial" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Registro de Material</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarMaterial.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="NumParte" class="form-label">Número de Parte/Clave de Identificación:</label>
                                    <input type="text" name="NumParte" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="DescripcionMaterial" class="form-label">Descripción del Material:</label>
                                    <input type="text" name="DescripcionMaterial" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="FraccionArancelaria" class="form-label">Fracción Arancelaria:</label>
                                    <input type="text" name="FraccionArancelaria" class="form-control" required>
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="UnidadMedidaTIGIE" class="form-label">Unidad de Medida Tigie:</label>
                                    <select name="UnidadMedidaTIGIE" class="form-select" required>
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

                                <div class="form-group">
                                    <label for="TipoMaterial" class="form-label">Tipo de Material:</label>
                                    <select name="TipoMaterial" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">----Seleccionar----</option>
                                        <option value="Material Directo">Material Directo</option>
                                        <option value="Material Indirecto">Material Indirecto</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="ProveedorID" class="form-label">Proveedor:</label>
                                    <select name="ProveedorID" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">-- Selecciona un Proveedor --</option>
                                        <?php
                                        $contrib = mysqli_query($conn, "SELECT ProveedorID, NumClaveIdentificacionEmpresa, NombreRazonSocial FROM proveedores");

                                        while ($datos = mysqli_fetch_array($contrib)) {
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
                                    <label for="ClienteID" class="form-label">Cliente:</label>
                                    <select name="ClienteID" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">-- Selecciona un Cliente --</option>
                                        <?php
                                        $contrib = mysqli_query($conn, "SELECT ClienteID, NumClaveIdentificacion, NombreRazonSocial FROM clientes");

                                        while ($datos = mysqli_fetch_array($contrib)) {
                                        ?>
                                            <option value="<?php echo $datos['ClienteID']; ?>">
                                                <?php echo $datos['NumClaveIdentificacion'] . ' - ' . $datos['NombreRazonSocial']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div><br>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Registrar Material</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Edición de Contribuyente -->
    <?php
    $query = mysqli_query($conn, $consultar);

    while ($row = mysqli_fetch_assoc($query)) {
    ?>
        <div class="modal fade" id="editarModal<?php echo $row['MaterialID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Material</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editarMaterial.php" method="POST">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NumParte">Número de Parte/Clave de Identificación:</label>
                                        <input type="text" class="form-control" id="NumParte" name="NumParte" value="<?php echo $row['NumParte']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="DescripcionMaterial">Descripción del Material:</label>
                                        <input type="text" class="form-control" id="DescripcionMaterial" name="DescripcionMaterial" value="<?php echo $row['DescripcionMaterial']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="FraccionArancelaria">Fracción Arancelaria:</label>
                                        <input type="text" class="form-control" id="FraccionArancelaria" name="FraccionArancelaria" value="<?php echo $row['FraccionArancelaria']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="UnidadMedidaComercializacion">Unidad de Medida Comercialización:</label>
                                        <select id="UnidadMedidaComercializacion" name="UnidadMedidaComercializacion" class="form-control">
                                            <option hidden value="<?php echo $row['UnidadMedidaComercializacion']; ?> " required> <?php echo $row['UnidadMedidaComercializacion']; ?></option>
                                            <option style="text-align: center;">----Seleccionar----</option>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="UnidadMedidaTIGIE">Unidad de Medida Tigie:</label>
                                        <select id="UnidadMedidaTIGIE" name="UnidadMedidaTIGIE" class="form-control">
                                            <option hidden value="<?php echo $row['UnidadMedidaTIGIE']; ?> " required> <?php echo $row['UnidadMedidaTIGIE']; ?></option>
                                            <option style="text-align: center;">----Seleccionar----</option>
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

                                    <div class="form-group">
                                        <label for="TipoMaterial">Tipo de Material:</label>
                                        <select id="TipoMaterial" name="TipoMaterial" class="form-control">
                                            <option hidden value="<?php echo $row['TipoMaterial']; ?> " required> <?php echo $row['TipoMaterial']; ?></option>
                                            <option style="text-align: center;">----Seleccionar----</option>
                                            <option value="Material Directo">Material Directo</option>
                                            <option value="Material Indirecto">Material Indirecto</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ProveedorID">Proveedor:</label>
                                        <select class="form-control" name="ProveedorID">

                                            <?php
                                            $proveedores = mysqli_query($conn, "SELECT ProveedorID, NumClaveIdentificacionEmpresa, NombreRazonSocial FROM proveedores");

                                            while ($datos = mysqli_fetch_array($proveedores)) {
                                            ?>
                                                <option value="<?php echo $datos['ProveedorID']; ?>" <?php echo ($row['ProveedorID'] == $datos['ProveedorID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumClaveIdentificacionEmpresa']; ?> - <?php echo $datos['NombreRazonSocial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ClienteID">Cliente:</label>
                                        <select class="form-control" name="ClienteID">

                                            <?php
                                            $clientes = mysqli_query($conn, "SELECT ClienteID, NumClaveIdentificacion, NombreRazonSocial FROM clientes");

                                            while ($datos = mysqli_fetch_array($clientes)) {
                                            ?>
                                                <option value="<?php echo $datos['ClienteID']; ?>" <?php echo ($row['ClienteID'] == $datos['ClienteID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['NumClaveIdentificacion']; ?> - <?php echo $datos['NombreRazonSocial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="MaterialID" value="<?php echo $row['MaterialID']; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    </section>
</body>
<script>

</script>

</html>