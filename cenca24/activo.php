<?php
include 'startSession.php';
require 'conexion.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/media/icon.png" type="image/x-icon" />

    <title>Activo Fijo</title>
</head>

<body>
    <header>
        <?php
        include 'vistas/cabeza.php';
        ?>
    </header>
    <section class="contenedor">
        <h3><strong>Datos del Activo</strong></h3>

        <div>
            <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button>
        </div>

        <?php
        $consultar = "SELECT * FROM activofijo ORDER BY activoFijoID ASC";
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
                echo "<div id='mensaje' class='alert alert-success'>El nuevo contribuyente se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo activo.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('mensaje').style.display = 'none';
                    }, 2000);
                </script>";
        }
        ?>
        <br>
        <br>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Orden Compra</th>
                    <th>Descripcion Mercancia</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>NumSerie</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $row['OrdenCompra'] ?></td>
                        <td><?php echo $row['DescripcionMercancia'] ?></td>
                        <td><?php echo $row['Marca'] ?></td>
                        <td><?php echo $row['Modelo'] ?></td>
                        <td><?php echo $row['NumSerie'] ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar"><img src="assets/media/editar.png" width="15px" height="15px"></button>
                            <button class="btn btn-danger"> <img src="assets/media/eliminar.png" width="15px" height="15px"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div>



    </section>
    <footer>
        <?php
        include 'vistas/footer.php';
        ?>
    </footer>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Activo fijo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="activo_fijo.php" method="POST">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="OrdenCompra" class="form-label">Orden de Compra</label>
                                    <input type="text" class="form-control" id="OrdenCompra" name="OrdenCompra">
                                </div>
                                <div class="mb-3">
                                    <label for="DescripcionMercancia" class="form-label">Descripcion de Mercancia</label>
                                    <input type="text" class="form-control" id="DescripcionMercancia" name="DescripcionMercancia">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="Marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="Marca" name="Marca">
                                </div>
                                <div class="mb-3">
                                    <label for="Modelo" class="form-label">Modelo</label>
                                    <input type="text" class="form-control" id="Modelo" name="Modelo">
                                </div>
                                <div class="mb-3">
                                    <label for="NumSerie" class="form-label">Numero de Serie</label>
                                    <input type="text" class="form-control" id="NumSerie" name="NumSerie">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="FraccionArancelaria" class="form-label">Fraccion Arancelaria</label>
                                    <input type="text" class="form-control" id="FraccionArancelaria" name="FraccionArancelaria">
                                </div>
                                <div class="form-group">
                                    <label for="ContribuyenteID" class="form-label">Contribuyente:</label>
                                    <select name="ContribuyenteID" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">-- Selecciona un contribuyente --</option>
                                        <?php
                                        include 'conexion.php';

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

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Registar Activo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Editar Actvo -->
    <?php
    $query = mysqli_query($conn, $consultar);
    while ($row = mysqli_fetch_array($query)) {
    ?>
        <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Activo fijo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="editar-activo.php" method="POST">

                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control" id="ActivoFijoID" name="ActivoFijoID" value="<?php echo $row['ActivoFijoID']; ?>" required>

                                    <div class="mb-3">
                                        <label for="OrdenCompra" class="form-label">Orden de Compra</label>
                                        <input type="text" class="form-control" id="OrdenCompra" name="OrdenCompra" value="<?php echo $row['OrdenCompra']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="DescripcionMercancia" class="form-label">Descripcion de Mercancia</label>
                                        <input type="text" class="form-control" id="DescripcionMercancia" name="DescripcionMercancia" value="<?php echo $row['DescripcionMercancia']; ?>" required>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="Marca" class="form-label">Marca</label>
                                        <input type="text" class="form-control" id="Marca" name="Marca" value="<?php echo $row['Marca']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Modelo" class="form-label">Modelo</label>
                                        <input type="text" class="form-control" id="Modelo" name="Modelo" value="<?php echo $row['Modelo']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NumSerie" class="form-label">Numero de Serie</label>
                                        <input type="text" class="form-control" id="NumSerie" name="NumSerie" value="<?php echo $row['NumSerie']; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="FraccionArancelaria" class="form-label">Fraccion Arancelaria</label>
                                        <input type="text" class="form-control" id="FraccionArancelaria" name="FraccionArancelaria" value="<?php echo $row['NumSerie']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ContribuyenteID">Contribuyente:</label>
                                        <select class="form-control" required="required" name="ContribuyenteID">
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

                                    </div><br>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Actualizar Activo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


</body>

</html>