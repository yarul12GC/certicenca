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
            $consultar = "SELECT * FROM productos ORDER BY productoID ASC";
            $query = mysqli_query($conn, $consultar);
            $cantidad = mysqli_num_rows($query);

            //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

            // 

            if (isset($_GET['mensaje'])) {
                $mensaje = $_GET['mensaje'];
                if ($mensaje === "exito") {
                    echo "<div id='mensaje' class='alert alert-success'>El producto se ha actualizado correctamente.</div>";
                } elseif ($mensaje === "error") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el producto.</div>";
                } elseif ($mensaje === "exito_registro") {
                    echo "<div id='mensaje' class='alert alert-success'>El nuevo producto se ha registrado correctamente.</div>";
                } elseif ($mensaje === "error_registro") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo producto.</div>";
                }

                // Agrega el script JavaScript
                echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
          </script>";
            }
            ?>



         <h3><strong>Productos</strong></h3>
         <section class="">
             <div class="float-start">


                 <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#nuevoproducto">
                     <img src="assets/media/registro.png" width="20px" height="20px"> Nuevo Producto
                 </button>
             </div>

             <div>
                 <table class="table table-bordered table-hover">
                     <thead class="table-dark">
                         <tr>
                             <th>Número de parte o clave de identificación</th>
                             <th>Descripción del material</th>
                             <th>Fracción arancelaria</th>
                             <th>Medida de comercialización</th>
                             <th>Unidad de medida TIGIE</th>
                             <th>Funciones</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = mysqli_fetch_array($query)) { ?>
                             <tr>
                                 <td><?php echo $row['NumParte']; ?></td>
                                 <td><?php echo $row['DescripcionProducto']; ?></td>
                                 <td><?php echo $row['FraccionArancelaria']; ?></td>
                                 <td><?php echo $row['UnidadMedidaComercializacion']; ?></td>
                                 <td><?php echo $row['UnidadMedidaTIGIE']; ?></td>

                                 <td>
                                     <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['ProductoID']; ?>">
                                         <img src="assets/media/editar.png" width="15px" height="15px">
                                     </button>

                                     <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['ProductoID']; ?>)">
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


     <div class="modal fade" id="nuevoproducto" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel"><strong>Nuevo Producto</strong></h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     </button>
                 </div>
                 <div class="modal-body">
                     <form action="procesarProducto.php" method="POST">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="NumParte" class="form-label">Número de Parte/Clave de Identificación:</label>
                                     <input type="text" name="NumParte" class="form-control" required>
                                 </div>

                                 <div class="form-group">
                                     <label for="DescripcionProducto" class="form-label">Descripción del Producto:</label>
                                     <input type="text" name="DescripcionProducto" class="form-control" required>
                                 </div>

                                 <div class="form-group">
                                     <label for="FraccionArancelaria" class="form-label">Fracción Arancelaria:</label>
                                     <input type="text" name="FraccionArancelaria" class="form-control" required>
                                 </div>
                                 <div class="form-group">
                                     <label for="UnidadMedidaComercializacion" class="form-label">Unidad de Medida Comercialización:</label>
                                     <select name="UnidadMedidaComercializacion" class="form-select" required>
                                         <option value="" disabled selected>--Selecciona una unidad--</option>
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
                                     <label for="UnidadMedidaTIGIE" class="form-label">Unidad de Medida TIGIE:</label>
                                     <select name="UnidadMedidaTIGIE" class="form-select" required>
                                         <option value="" disabled selected>--Selecciona una unidad--</option>
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
                                 <button type="submit" class="btn btn-primary">Registrar Producto</button>
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

        while ($row = mysqli_fetch_array($query)) {
        ?>
         <div class="modal fade" id="editarModal<?php echo $row['ProductoID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><strong>Editar Producto</strong></h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <form action="editarProducto.php" method="POST">

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="NumParte">Número de Parte/Clave de Identificación:</label>
                                         <input type="text" class="form-control" id="NumParte" name="NumParte" value="<?php echo $row['NumParte']; ?>" required>
                                     </div>

                                     <div class="form-group">
                                         <label for="DescripcionProducto">Descripción del Producto:</label>
                                         <input type="text" class="form-control" id="DescripcionProducto" name="DescripcionProducto" value="<?php echo $row['DescripcionProducto']; ?>" required>
                                     </div>

                                     <div class="form-group">
                                         <label for="FraccionArancelaria">Fracción Arancelaria:</label>
                                         <input type="text" class="form-control" id="FraccionArancelaria" name="FraccionArancelaria" value="<?php echo $row['FraccionArancelaria']; ?>" required>
                                     </div>

                                 </div>
                                 <div class="col-md-6">

                                     <div class="form-group">
                                         <label for="UnidadMedidaComercializacion">Unidad de Medida Comercialización:</label>
                                         <select id="UnidadMedidaComercializacion" name="UnidadMedidaComercializacion" class="form-control">
                                             <option hidden value="<?php echo $row['UnidadMedidaComercializacion']; ?> " required> <?php echo $row['UnidadMedidaComercializacion']; ?></option>
                                             <option disabled>----Seleccionar----</option>
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
                                     <input type="hidden" name="ProductoID" value="<?php echo $row['ProductoID']; ?>">
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


 </html>