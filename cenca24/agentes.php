<?php
include 'startSession.php';
require 'conexion.php';
?>

 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Agentes</title>
     <?php
        // Incluir el archivo cabeza.php
        include 'vistas/cabeza.php';
        ?>
 </head>

 <body>

     <section class="contenedor">
         <?php
            $consultar = "SELECT * FROM agentesaduanales ORDER BY AgenteAduanalID ASC";
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



         <h3><strong>Agentes y/o apoderados aduanales. </strong></h3>
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
                             <th>Número de patente </th>
                             <th>Nombre del Agente </th>
                             <th>RFC</th>
                             <th>CURP</th>
                             <th>Funciones</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = mysqli_fetch_array($query)) { ?>
                             <tr>
                                 <td><?php echo $row['NumPatenteAutorizacion']; ?></td>
                                 <td><?php echo $row['NombreAgenteAduanal'] . ' ' . $row['ApellidoPaterno'] . ' ' . $row['ApellidoMaterno']; ?></td>
                                 <td><?php echo $row['RFC']; ?></td>
                                 <td><?php echo $row['CURP']; ?></td>

                                 <td>
                                     <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['AgenteAduanalID']; ?>">
                                         <img src="assets/media/editar.png" width="15px" height="15px">
                                     </button>

                                     <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['AgenteAduanalID']; ?>)">
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
                     <form action="procesarAgente.php" method="POST">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="TipoAgente" class="form-label">Tipo de Agente</label>
                                     <select class="form-select" id="TipoAgente" name="TipoAgente" onchange="mostrarCamposTipoAgente()">
                                         <option value="" disabled selected>--Seleccione el tipo de agente--</option>
                                         <option value="Agente Aduanal">Agente Aduanal</option>
                                         <option value="Apoderado Aduanal">Apoderado Aduanal</option>
                                     </select>
                                 </div>

                                 <div class="form-group">
                                     <label for="NumPatenteAutorizacion" class="form-label">Número de Patente/Autorización</label>
                                     <input type="text" class="form-control" id="NumPatenteAutorizacion" name="NumPatenteAutorizacion" require>
                                 </div>
                                 <div class="form-group">
                                     <label for="NombreAgenteAduanal" class="form-label">Nombre</label>
                                     <input type="text" class="form-control" id="NombreAgenteAduanal" name="NombreAgenteAduanal" required>
                                 </div>
                                 <div class="form-group">
                                     <label for="ApellidoPaterno" class="form-label">Apellido Paterno</label>
                                     <input type="text" class="form-control" id="ApellidoPaterno" name="ApellidoPaterno" require>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="ApellidoMaterno" class="form-label">Apellido Materno</label>
                                     <input type="text" class="form-control" id="ApellidoMaterno" name="ApellidoMaterno" required>
                                 </div>
                                 <div class="form-group">
                                     <label for="RFC" class="form-label">RFC:</label>
                                     <input type="text" class="form-control" id="RFC" name="RFC" require>
                                 </div>
                                 <div class="form-group">
                                     <label for="CURP" class="form-label">CURP:</label>
                                     <input type="text" class="form-control" id="CURP" name="CURP" required>
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
                             <div id="camposAgenteAduanal" style="display: none;">
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label for="RazonSocial">Denominación o razón social:</label>
                                             <input type="text" class="form-control" id="RazonSocial" name="RazonSocial">
                                         </div>
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

     <!-- Formulario de Edición  -->
     <?php
        $query = mysqli_query($conn, $consultar);

        while ($row = mysqli_fetch_array($query)) {
        ?>
         <div class="modal fade" id="editarModal<?php echo $row['AgenteAduanalID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Agente</strong></h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <form action="editarAgente.php" method="POST">

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="TipoAgente" class="form-label">Tipo de Agente</label>
                                         <select class="form-select" id="TipoAgenteEditar<?php echo $row['AgenteAduanalID']; ?>" name="TipoAgente" required onchange="mostrarCamposTipoAgenteEditar(<?php echo $row['AgenteAduanalID']; ?>)">
                                             <option hidden value="<?php echo $row['TipoAgente']; ?>"><?php echo $row['TipoAgente']; ?></option>
                                             <option value="" disabled>--Seleccione el tipo de agente--</option>
                                             <option value="Agente Aduanal">Agente Aduanal</option>
                                             <option value="Apoderado Aduanal">Apoderado Aduanal</option>
                                         </select>
                                     </div>
                                     <div class="form-group">
                                         <label for="NumPatenteAutorizacion" class="form-label">Número de Patente/Autorización</label>
                                         <input type="text" class="form-control" id="NumPatenteAutorizacion" name="NumPatenteAutorizacion" value="<?php echo $row['NumPatenteAutorizacion']; ?>" require>
                                     </div>
                                     <div class="form-group">
                                         <label for="NombreAgenteAduanal" class="form-label">Nombre</label>
                                         <input type="text" class="form-control" id="NombreAgenteAduanal" name="NombreAgenteAduanal" value="<?php echo $row['NombreAgenteAduanal']; ?>" required>
                                     </div>
                                     <div class="form-group">
                                         <label for="ApellidoPaterno" class="form-label">Apellido Paterno</label>
                                         <input type="text" class="form-control" id="ApellidoPaterno" name="ApellidoPaterno" value="<?php echo $row['ApellidoPaterno']; ?>" require>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="ApellidoMaterno" class="form-label">Apellido Materno</label>
                                         <input type="text" class="form-control" id="ApellidoMaterno" name="ApellidoMaterno" value="<?php echo $row['ApellidoMaterno']; ?>" required>
                                     </div>
                                     <div class="form-group">
                                         <label for="RFC" class="form-label">RFC:</label>
                                         <input type="text" class="form-control" id="RFC" name="RFC" value="<?php echo $row['RFC']; ?>" require>
                                     </div>
                                     <div class="form-group">
                                         <label for="CURP" class="form-label">CURP:</label>
                                         <input type="text" class="form-control" id="CURP" name="CURP" value="<?php echo $row['CURP']; ?>" required>
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
                                 <div id="camposAgenteAduanalEditar<?php echo $row['AgenteAduanalID']; ?>" style="display:none;">
                                     <div class="row">
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="RazonSocial">Denominación o razón social:</label>
                                                 <input type="text" class="form-control" id="RazonSocial" name="RazonSocial" value="<?php echo $row['RazonSocial']; ?>">
                                             </div>
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
                                 </div>
                             </div>
                             <input type="hidden" name="AgenteAduanalID" value="<?php echo $row['AgenteAduanalID']; ?>">
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
 </body>
 <script>
     function mostrarCamposTipoAgente() {
         var tipoAgente = document.getElementById("TipoAgente").value;
         var camposAgenteAduanal = document.getElementById("camposAgenteAduanal");

         if (tipoAgente === "Agente Aduanal") {
             camposAgenteAduanal.style.display = "block";
         } else {
             camposAgenteAduanal.style.display = "none";
         }
     }

     function mostrarCamposTipoAgenteEditar(id) {
         var tipoAgente = document.getElementById("TipoAgenteEditar" + id).value;
         var camposAgenteAduanal = document.getElementById("camposAgenteAduanalEditar" + id);

         if (tipoAgente === "Agente Aduanal") {
             camposAgenteAduanal.style.display = "block";
         } else {
             camposAgenteAduanal.style.display = "none";
         }
     }
 </script>

 </html>