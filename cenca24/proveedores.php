<?php
    include 'startSession.php';
    require 'conexion.php';
?>

 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Productos</title>
     <?php
        // Incluir el archivo cabeza.php
        include 'vistas/cabeza.php';
        ?>
 </head>

 <body>

     <section class="contenedor">
         <?php
            $consultar = "SELECT * FROM proveedores ORDER BY ProveedorID ASC";
            $query = mysqli_query($conn, $consultar);
            $cantidad = mysqli_num_rows($query);

            //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

            // 

            if (isset($_GET['mensaje'])) {
                $mensaje = $_GET['mensaje'];
                if ($mensaje === "exito") {
                    echo "<div id='mensaje' class='alert alert-success'>El proveedor se ha actualizado correctamente.</div>";
                } elseif ($mensaje === "error") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el proveedor.</div>";
                } elseif ($mensaje === "exito_registro") {
                    echo "<div id='mensaje' class='alert alert-success'>El nuevo proveedor se ha registrado correctamente.</div>";
                } elseif ($mensaje === "error_registro") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo proveedor.</div>";
                }

                // Agrega el script JavaScript
                echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
          </script>";
            }
            ?>



         <h3><strong>Proveedores</strong></h3>
         <section>
             <div class="float-start">


                 <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#nuevo">
                     <img src="assets/media/registro.png" width="20px" height="20px"> Nuevo Proveedor
                 </button>
             </div>

             <div>
                 <table class="table table-bordered table-hover">
                     <thead class="table-dark">
                         <tr>
                             <th>Número de parte o clave de identificación</th>
                             <th>Nombre, denominación o razón social</th>
                             <th>Nacionalidad</th>
                             <th>Clave de Identificación</th>
                             <th>Dirección Fiscal</th>
                             <th>Funciones</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = mysqli_fetch_array($query)) { ?>
                             <tr>
                                 <td><?php echo $row['NumClaveIdentificacionEmpresa']; ?></td>
                                 <td><?php echo $row['NombreRazonSocial']; ?></td>
                                 <td><?php echo $row['Nacionalidad']; ?></td>
                                 <td>
                                     <?php
                                        if ($row['Nacionalidad'] === 'Extranjero') {
                                            echo "CURP/RFC: " . $row['ClaveIdentificacionFiscal'];
                                        } elseif ($row['Nacionalidad'] === 'Nacional') {
                                            if (!empty($row['NumProgramaIMMEX'])) {
                                                echo "No. IMMEX: " . $row['NumProgramaIMMEX'];
                                            }

                                            if (!empty($row['RecintoFiscalizado'])) {
                                                if (!empty($row['NumProgramaIMMEX'])) {
                                                    echo ", ";
                                                }
                                                echo "Recinto Fiscalizado: " . $row['RecintoFiscalizado'];
                                            }
                                        }
                                        ?>
                                 </td>

                                 <td><?php echo $row['Calle'] . ', ' . $row['Numero'] . ', ' . $row['CodigoPostal'] . ', ' . $row['Colonia'] . ', ' . $row['EntidadFederativa'] . ', ' . $row['Pais']; ?></td>

                                 <td>
                                     <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['ProveedorID']; ?>">
                                         <img src="assets/media/editar.png" width="15px" height="15px">
                                     </button>

                                     <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['ProveedorID']; ?>)">
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

     <!--Formulario Nuevo-->
     <div class="modal fade" id="nuevo" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel"><strong>Nuevo Proveedor</strong></h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     </button>
                 </div>
                 <div class="modal-body">
                     <form action="procesarProveedor.php" method="POST">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="NumClaveIdentificacionEmpresa" class="form-label">Num Clave Identificación Empresa</label>
                                     <input type="text" class="form-control" id="NumClaveIdentificacionEmpresa" name="NumClaveIdentificacionEmpresa" required>
                                 </div>

                                 <div class="form-group">
                                     <label for="NombreRazonSocial" class="form-label">Nombre, denominación o razón social.</label>
                                     <input type="text" class="form-control" id="NombreRazonSocial" name="NombreRazonSocial" required>
                                 </div>
                             </div>

                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="Nacionalidad" class="form-label">Nacionalidad</label>
                                     <select class="form-select" id="Nacionalidad" name="Nacionalidad" onchange="mostrarCampos()">
                                         <option value="" disabled selected>--Seleccionar Nacionalidad--</option>
                                         <option value="Nacional">Nacional</option>
                                         <option value="Extranjero">Extranjero</option>
                                     </select>
                                 </div>
                                 <div id="camposNacional" style="display: none;">
                                     <!-- Campos para Nacional -->
                                     <div class="form-group">
                                         <label for="NumProgramaIMMEX" class="form-label">Número de Programa IMMEX</label>
                                         <input type="text" class="form-control" id="NumProgramaIMMEX" name="NumProgramaIMMEX">
                                     </div>

                                     <div class="form-group">
                                         <label for="RecintoFiscalizado" class="form-label">Recinto Fiscalizado</label>
                                         <input type="text" class="form-control" id="RecintoFiscalizado" name="RecintoFiscalizado">
                                     </div>
                                 </div>
                                 <div id="camposExtranjero" style="display: none;">
                                     <!-- Campos para Extranjero -->
                                     <div class="form-group">
                                         <label for="ClaveIdentificacionFiscal" class="form-label">Clave de Identificación Fiscal (CURP o RFC)</label>
                                         <input type="text" class="form-control" id="ClaveIdentificacionFiscal" name="ClaveIdentificacionFiscal">
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="modal-header">
                                     <h5 class="modal-title"><strong>Domicilio Fiscal</strong></h5>
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
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="modal-header">
                                     <h5 class="modal-title"><strong>Contribuyente</strong></h5>
                                 </div>
                                 <div class="col-md-6">
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
                                     </div><br>
                                 </div>
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

     <!-- Formulario de Edición-->
     <?php
        $query = mysqli_query($conn, $consultar);

        while ($row = mysqli_fetch_array($query)) {
        ?>
         <div class="modal fade" id="editarModal<?php echo $row['ProveedorID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Proveedor:</strong></h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <form action="editarProveedor.php" method="POST">

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="NumClaveIdentificacionEmpresa">Num Clave Identificación Empresa:</label>
                                         <input type="text" class="form-control" id="NumClaveIdentificacionEmpresa" name="NumClaveIdentificacionEmpresa" value="<?php echo $row['NumClaveIdentificacionEmpresa']; ?>" required>
                                     </div>

                                     <div class="form-group">
                                         <label for="NombreRazonSocial">Nombre, denominación o razón social:</label>
                                         <input type="text" class="form-control" id="NombreRazonSocial" name="NombreRazonSocial" value="<?php echo $row['NombreRazonSocial']; ?>" required>
                                     </div>
                                 </div>
                                 <div class="col-md-6">

                                     <div class="mb-3">
                                         <label for="Nacionalidad" class="form-label">Nacionalidad</label>
                                         <select class="form-select" id="NacionalidadEditar<?php echo $row['ProveedorID']; ?>" name="Nacionalidad" required onchange="mostrarCamposEditar(<?php echo $row['ProveedorID']; ?>)">
                                             <option hidden value="<?php echo $row['Nacionalidad']; ?>"><?php echo $row['Nacionalidad']; ?></option>
                                             <option value="" disabled>--Seleccionar Nacionalidad--</option>
                                             <option value="Nacional">Nacional</option>
                                             <option value="Extranjero">Extranjero</option>
                                         </select>
                                     </div>
                                     <div id="camposNacionalEditar<?php echo $row['ProveedorID']; ?>" style="display:none;">
                                         <!-- Campos para Nacional -->
                                         <div class="mb-3">
                                             <label for="NumProgramaIMMEX" class="form-label">Número de Programa IMMEX</label>
                                             <input type="text" class="form-control" id="NumProgramaIMMEX" name="NumProgramaIMMEX" value="<?php echo $row['NumProgramaIMMEX']; ?>">
                                         </div>
                                         <div class="mb-3">
                                             <label for="RecintoFiscalizado" class="form-label">Recinto Fiscalizado</label>
                                             <input type="text" class="form-control" id="RecintoFiscalizado" name="RecintoFiscalizado" value="<?php echo $row['RecintoFiscalizado']; ?>">
                                         </div>
                                     </div>
                                     <div id="camposExtranjeroEditar<?php echo $row['ProveedorID']; ?>" style="display:none;">
                                         <!-- Campos para Extranjero -->
                                         <div class="mb-3">
                                             <label for="ClaveIdentificacionFiscal" class="form-label">Clave de Identificación Fiscal (CURP o RFC)</label>
                                             <input type="text" class="form-control" id="ClaveIdentificacionFiscal" name="ClaveIdentificacionFiscal" value="<?php echo $row['ClaveIdentificacionFiscal']; ?>">
                                         </div>
                                     </div>
                                 </div>
                             </div>


                             <div class="row">
                                 <div class="modal-header">
                                     <h5 class="modal-title"><strong>Domicilio Fiscal</strong></h5>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="Calle">Calle:</label>
                                         <input type="text" class="form-control" id="Calle" name="Calle" value="<?php echo $row['Calle']; ?>" required>
                                     </div>
                                     <div class="form-group">
                                         <label for="Numero">Número:</label>
                                         <input type="text" class="form-control" id="Numero" name="Numero" value="<?php echo $row['Numero']; ?>" required>
                                     </div>
                                     <div class="form-group">
                                         <label for="CodigoPostal">Codigo Postal:</label>
                                         <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal" maxlength="10" value="<?php echo $row['CodigoPostal']; ?>" required>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="Colonia">Colonia:</label>
                                         <input type="text" class="form-control" id="Colonia" name="Colonia" value="<?php echo $row['Colonia']; ?>" required>
                                     </div>
                                     <div class="form-group">
                                         <label for="EntidadFederativa">Entidad Federativa:</label>
                                         <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa" value="<?php echo $row['EntidadFederativa']; ?>" required>
                                     </div>
                                     <div class="form-group">
                                         <label for="Pais">País:</label>
                                         <input type="text" class="form-control" id="Pais" name="Pais" value="<?php echo $row['Pais']; ?>" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="modal-header">
                                     <h5 class="modal-title"><strong>Contribuyente</strong></h5>
                                 </div>
                                 <div class="col-md-6">
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
                             </div><br>
                             <input type="hidden" name="ProveedorID" value="<?php echo $row['ProveedorID']; ?>">
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
     function mostrarCampos() {
         var nacionalidad = document.getElementById("Nacionalidad").value;
         var camposNacional = document.getElementById("camposNacional");
         var camposExtranjero = document.getElementById("camposExtranjero");

         if (nacionalidad === "Nacional") {
             camposNacional.style.display = "block";
             camposExtranjero.style.display = "none";
         } else {
             camposNacional.style.display = "none";
             camposExtranjero.style.display = "block";
         }
     }

     function mostrarCamposEditar(id) {
         var nacionalidad = document.getElementById("NacionalidadEditar" + id).value;
         var camposNacional = document.getElementById("camposNacionalEditar" + id);
         var camposExtranjero = document.getElementById("camposExtranjeroEditar" + id);

         if (nacionalidad === "Nacional") {
             camposNacional.style.display = "block";
             camposExtranjero.style.display = "none";
         } else {
             camposNacional.style.display = "none";
             camposExtranjero.style.display = "block";
         }
     }
 </script>

 </html>