<?php
    include 'startSession.php';
    require 'conexion.php';
?>

 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Submanufactura o Submaquila</title>
     <?php
        // Incluir el archivo cabeza.php
        include 'vistas/cabeza.php';
        ?>
 </head>

 <body>

     <section class="contenedor">
         <?php
            $consultar = "SELECT * FROM submanufactura ORDER BY SubmanufacturaID ASC";
            $query = mysqli_query($conn, $consultar);
            $cantidad = mysqli_num_rows($query);

            //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

            // 

            if (isset($_GET['mensaje'])) {
                $mensaje = $_GET['mensaje'];
                if ($mensaje === "exito") {
                    echo "<div id='mensaje' class='alert alert-success'>Se ha actualizado correctamente.</div>";
                } elseif ($mensaje === "error") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar.</div>";
                } elseif ($mensaje === "exito_registro") {
                    echo "<div id='mensaje' class='alert alert-success'>Se ha registrado correctamente.</div>";
                } elseif ($mensaje === "error_registro") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al registrar.</div>";
                }

                // Agrega el script JavaScript
                echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
          </script>";
            }
            ?>



         <h3><strong>Submanufactura o Submaquila</strong></h3>
         <section class="">
             <div class="float-start">


                 <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#nuevoRegistro">
                     <img src="assets/media/registro.png" width="20px" height="20px"> Nuevo Registro
                 </button>
             </div>

             <div>
                 <table class="table table-bordered table-hover">
                     <thead class="table-dark">
                         <tr>
                             <th>Número de parte o clave de identificación</th>
                             <th>Nombre, denominación o razón social</th>
                             <th>Número de autorización</th>
                             <th>Fecha de autorización</th>
                             <th>Domicilio del servicio</th>
                             <th>Funciones</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = mysqli_fetch_array($query)) { ?>
                             <tr>
                                 <td><?php echo $row['NumClaveIdentificacion']; ?></td>
                                 <td><?php echo $row['NombreRazonSocial']; ?></td>
                                 <td><?php echo $row['NumAutorizacionSE']; ?></td>
                                 <td><?php echo $row['FechaAutorizacion']; ?></td>
                                 <td><?php echo $row['Calle'] . ', ' . $row['Numero'] . ', ' . $row['CodigoPostal'] . ', ' . $row['Colonia'] . ', ' . $row['EntidadFederativa'] . ', ' . $row['Pais']; ?></td>

                                 <td>
                                     <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['SubmanufacturaID']; ?>">
                                         <img src="assets/media/editar.png" width="15px" height="15px">
                                     </button>

                                     <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['SubmanufacturaID']; ?>)">
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


     <div class="modal fade" id="nuevoRegistro" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel"><strong>Nuevo Registro</strong></h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     </button>
                 </div>
                 <div class="modal-body">
                     <form action="procesarSubmanu.php" method="POST">
                         <div class="row">
                             <div class="col-md-6">

                                 <div class="form-group">
                                     <label for="NumClaveIdentificacion">Número de Clave de Identificación</label>
                                     <input type="text" class="form-control" id="NumClaveIdentificacion" name="NumClaveIdentificacion" require>
                                 </div>

                                 <div class="form-group">
                                     <label for="NombreRazonSocial">Nombre o Razón Social</label>
                                     <input type="text" class="form-control" id="NombreRazonSocial" name="NombreRazonSocial" require>
                                 </div>
                                 <div class="form-group">
                                     <label for="NumAutorizacionSE">Número de Autorización SE</label>
                                     <input type="text" class="form-control" id="NumAutorizacionSE" name="NumAutorizacionSE" require>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="FechaAutorizacion">Fecha de Autorización:</label>
                                     <input type="date" class="form-control" id="FechaAutorizacion" name="FechaAutorizacion" required>
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
                             </div>

                             <div class="modal-header">
                                 <h5 class="modal-title"><strong>Domicilio de donde se llevará a cabo el servicio </strong></h5>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="Calle">Calle:</label>
                                     <input type="text" class="form-control" id="Calle" name="Calle">
                                 </div>

                                 <div class="form-group">
                                     <label for="Numero">Numero:</label>
                                     <input type="text" class="form-control" id="Numero" name="Numero">
                                 </div>
                                 <div class="form-group">
                                     <label for="CodigoPostal">Código Postal:</label>
                                     <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="Colonia">Colonia:</label>
                                     <input type="text" class="form-control" id="Colonia" name="Colonia">
                                 </div>
                                 <div class="form-group">
                                     <label for="EntidadFederativa">Entidad Federativa:</label>
                                     <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa">
                                 </div>
                                 <div class="form-group">
                                     <label for="Pais">País:</label>
                                     <input type="text" class="form-control" id="Pais" name="Pais">
                                 </div><br>
                             </div>
                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-primary">Registrar Producto</button>
                                 <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>

     <!-- Formulario de Edición de subma -->
     <?php
        $query = mysqli_query($conn, $consultar);

        while ($row = mysqli_fetch_array($query)) {
        ?>
         <div class="modal fade" id="editarModal<?php echo $row['SubmanufacturaID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Producto</strong></h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <form action="editarSubman.php" method="POST">

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="NumClaveIdentificacion">Número de Clave de Identificación</label>
                                         <input type="text" class="form-control" id="NumClaveIdentificacion" name="NumClaveIdentificacion" value="<?php echo $row['NumClaveIdentificacion']; ?>" required>
                                     </div>

                                     <div class="form-group">
                                         <label for="NombreRazonSocial">Nombre o Razón Social</label>
                                         <input type="text" class="form-control" id="NombreRazonSocial" name="NombreRazonSocial" value="<?php echo $row['NombreRazonSocial']; ?>" required>
                                     </div>

                                     <div class="form-group">
                                         <label for="NumAutorizacionSE">Número de Autorización SE</label>
                                         <input type="text" class="form-control" id="NumAutorizacionSE" name="NumAutorizacionSE" value="<?php echo $row['NumAutorizacionSE']; ?>" required>
                                     </div>

                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="FechaAutorizacion">Fecha de Autorización</label>
                                         <input type="date" class="form-control" id="FechaAutorizacion" name="FechaAutorizacion" value="<?php echo $row['FechaAutorizacion']; ?>">
                                     </div>

                                     <div class="form-group">
                                         <label for="ContribuyenteID">Contribuyente:</label>
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
                                 </div>
                                 <div class="modal-header">
                                     <h5 class="modal-title"><strong>Domicilio de donde se llevará a cabo el servicio </strong></h5>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="Calle">Calle:</label>
                                         <input type="text" class="form-control" id="Calle" name="Calle" value="<?php echo $row['Calle']; ?>">
                                     </div>

                                     <div class="form-group">
                                         <label for="Numero">Numero:</label>
                                         <input type="text" class="form-control" id="Numero" name="Numero" value="<?php echo $row['Numero']; ?>">
                                     </div>
                                     <div class="form-group">
                                         <label for="CodigoPostal">Código Postal:</label>
                                         <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal" value="<?php echo $row['CodigoPostal']; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="Colonia">Colonia:</label>
                                         <input type="text" class="form-control" id="Colonia" name="Colonia" value="<?php echo $row['Colonia']; ?>">
                                     </div>
                                     <div class="form-group">
                                         <label for="EntidadFederativa">Entidad Federativa:</label>
                                         <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa" value="<?php echo $row['EntidadFederativa']; ?>">
                                     </div>
                                     <div class="form-group">
                                         <label for="Pais">País:</label>
                                         <input type="text" class="form-control" id="Pais" name="Pais" value="<?php echo $row['Pais']; ?>">
                                     </div><br>
                                 </div>

                             </div>
                             <input type="hidden" name="SubmanufacturaID" value="<?php echo $row['SubmanufacturaID']; ?>">
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