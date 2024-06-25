<?php
include 'startSession.php';
require 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contibuyentes</title>
    <?php
    // Incluir el archivo cabeza.php
    include 'vistas/cabeza.php';
    ?>
</head>

<body>

    <section class="contenedor">
        <?php
        $consultar = "SELECT * FROM contribuyente ORDER BY ContribuyenteID  ASC";
        $query = mysqli_query($conn, $consultar);
        $cantidad     = mysqli_num_rows($query);

        //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

        // 

        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>El usuario se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el usuario.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>El nuevo contribuyente se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo contribuyente.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
          </script>";
        }
        ?>



        <h3><strong>Datos del contribuyente</strong></h3>
        <section>
            <div class="float-start">


                <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#nuevoContibuyente">
                    <img src="assets/media/registro.png" width="20px" height="20px"> Nuevo Contribuyente
                </button>
            </div>

            <div class="">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Denominación o Razón Social</th>
                            <th>Clave del RFC</th>
                            <th>Número de Programa IMMEX</th>
                            <th>Dirección</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                            <tr>
                                <td><?php echo $row['DenominacionRazonSocial']; ?></td>
                                <td><?php echo $row['ClaveRFC']; ?></td>
                                <td><?php echo $row['NumProgramaIMMEX']; ?></td>
                                <td><?php echo $row['TipoDomicilio'] . ': ' . $row['CallePlanta'] . ', ' . $row['NumeroPlanta'] . ', ' . $row['CodigoPostal'] . ', ' . $row['ColoniaPlanta']; ?></td>

                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['ContribuyenteID']; ?>">
                                        <img src="assets/media/editar.png" width="15px" height="15px">
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['ContribuyenteID']; ?>)">
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
    <div class="modal fade" id="nuevoContibuyente" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Nuevo Contribuyente</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="procesarContribuyente.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="DenominacionRazonSocial">Denominación o Razón Social:</label>
                                    <input type="text" class="form-control" id="DenominacionRazonSocial" name="DenominacionRazonSocial" required>
                                </div>

                                <div class="form-group">
                                    <label for="ClaveRFC">Clave RFC:</label>
                                    <input type="text" class="form-control" id="ClaveRFC" name="ClaveRFC" maxlength="13" required>
                                </div>

                                <div class="form-group">
                                    <label for="NumProgramaIMMEX">Número de Programa IMMEX:</label>
                                    <input type="text" class="form-control" id="NumProgramaIMMEX" name="NumProgramaIMMEX">
                                </div>
                                <div class="form-group">
                                    <label for="TipoDomicilio">Tipo de Domicilio a Registrar:</label>
                                    <select name="TipoDomicilio" class="form-select" required>
                                        <option value="" disabled selected style="text-align: center;">----Seleccionar----</option>
                                        <option value="Domicilio fiscal">Domicilio fiscal</option>
                                        <option value="Planta industrial">Planta industrial</option>
                                        <option value="Bodega">Bodega</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CallePlanta">Calle:</label>
                                    <input type="text" class="form-control" id="CallePlanta" name="CallePlanta" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="NumeroPlanta">Número del Domicilio:</label>
                                    <input type="text" class="form-control" id="NumeroPlanta" name="NumeroPlanta">
                                </div>

                                <div class="form-group">
                                    <label for="CodigoPostal">Codigo Postal:</label>
                                    <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal">
                                </div>

                                <div class="form-group">
                                    <label for="ColoniaPlanta">Colonia:</label>
                                    <input type="text" class="form-control" id="ColoniaPlanta" name="ColoniaPlanta">
                                </div>
                                <div class="form-group">
                                    <label for="EntidadFederativa">Entidad Federativa:</label>
                                    <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa">
                                </div>

                            </div>
                        </div><br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar Contribuyente</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Edición de Contribuyente -->
    <?php
    $query = mysqli_query($conn, $consultar);

    while ($row = mysqli_fetch_array($query)) {
    ?>
        <div class="modal fade" id="editarModal<?php echo $row['ContribuyenteID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Contribuyente</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editarContribuyente.php" method="POST">
                            <!-- Campo oculto para almacenar el ID del contribuyente -->
                            <input type="hidden" id="ContribuyenteID" name="ContribuyenteID" value="<?php echo $row['ContribuyenteID']; ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DenominacionRazonSocial">Denominación o Razón Social:</label>
                                        <input type="text" class="form-control" id="DenominacionRazonSocial" name="DenominacionRazonSocial" value="<?php echo $row['DenominacionRazonSocial']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="ClaveRFC">Clave RFC:</label>
                                        <input type="text" class="form-control" id="ClaveRFC" name="ClaveRFC" maxlength="13" value="<?php echo $row['ClaveRFC']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="NumProgramaIMMEX">Número de Programa IMMEX:</label>
                                        <input type="text" class="form-control" id="NumProgramaIMMEX" name="NumProgramaIMMEX" value="<?php echo $row['NumProgramaIMMEX']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="TipoDomicilio">Tipo de Domicilio a Registrar:</label>
                                        <select id="TipoDomicilio" name="TipoDomicilio" class="form-control">
                                            <option hidden value="<?php echo $row['TipoDomicilio']; ?> " required> <?php echo $row['TipoDomicilio']; ?></option>
                                            <option>----Seleccionar---</option>
                                            <option value="Domicilio fiscal">Domicilio fiscal</option>
                                            <option value="Planta industrial">Planta industrial</option>
                                            <option value="Bodega">Bodega</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="CallePlanta">Calle:</label>
                                        <input type="text" class="form-control" id="CallePlanta" name="CallePlanta" value="<?php echo $row['CallePlanta']; ?>" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NumeroPlanta">Número del Domicilio:</label>
                                        <input type="text" class="form-control" id="NumeroPlanta" name="NumeroPlanta" value="<?php echo $row['NumeroPlanta']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="CodigoPostal">Codigo Postal:</label>
                                        <input type="text" class="form-control" id="codigoPostal" name="CodigoPostal" maxlength="10" value="<?php echo $row['CodigoPostal']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ColoniaPlanta">Colonia:</label>
                                        <input type="text" class="form-control" id="ColoniaPlanta" name="ColoniaPlanta" value="<?php echo $row['ColoniaPlanta']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="EntidadFederativa">Entidad Federativa:</label>
                                        <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa" value="<?php echo $row['EntidadFederativa']; ?>" required>
                                    </div><br>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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