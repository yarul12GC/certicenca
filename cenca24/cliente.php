<?php
include 'startSession.php';
require 'conexion.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>Clientes</title>
    <?php
    // Incluir el archivo cabeza.php 
    include 'vistas/cabeza.php';
    ?>
</head>

<body>
    <section class="contenedor">
        <?php
        $consultar = "SELECT * FROM clientes ORDER BY ClienteID ASC";
        $query = mysqli_query($conn, $consultar);
        $cantidad = mysqli_num_rows($query);

        //MENSAJE DE EXITO REGISTRO Y ACTUALIZACION

        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje === "exito") {
                echo "<div id='mensaje' class='alert alert-success'>El cliente se ha actualizado correctamente.</div>";
            } elseif ($mensaje === "error") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el cliente.</div>";
            } elseif ($mensaje === "exito_registro") {
                echo "<div id='mensaje' class='alert alert-success'>El nuevo cliente se ha registrado correctamente.</div>";
            } elseif ($mensaje === "error_registro") {
                echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo cliente.</div>";
            }

            // Agrega el script JavaScript
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('mensaje').style.display = 'none';
                    }, 2000);
                </script>";
        }
        ?>

        <h3><strong>Datos del cliente</strong></h3>
        <!-- Button trigger modal -->
        <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#registrarcliente">
            Registrar cliente
        </button>
        <br><br>

        <div>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ClienteID</th>
                        <th>NumClaveIdentificacion</th>
                        <th>NombreRazonSocial</th>
                        <th>NumProgramaIMMEX</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['ClienteID']; ?></td>
                            <td><?php echo $row['NumClaveIdentificacion']; ?></td>
                            <td><?php echo $row['NombreRazonSocial']; ?></td>
                            <td><?php echo $row['NumProgramaIMMEX']; ?></td>

                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal<?php echo $row['ClienteID']; ?>">
                                    <img src="assets/media/editar.png" width="15px" height="15px">
                                </button>

                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?php echo $row['ClienteID']; ?>)">
                                    <img src="assets/media/eliminar.png" width="15px" height="15px">
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <?php
        // Incluir el archivo ´pie.php
        include 'vistas/footer.php';
        ?>
    </footer>


    <!-- Modal de registro de cliente -->
    <div class="modal fade" id="registrarcliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Nuevo Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="procesar_registro_cliente.php" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Primera Columna -->
                                    <div class="mb-3">
                                        <label for="NumClaveIdentificacion" class="form-label">Número de Clave de Identificación</label>
                                        <input type="text" class="form-control" id="NumClaveIdentificacion" name="NumClaveIdentificacion" placeholder="Ingrese el número de clave de identificación">
                                    </div>
                                    <div class="mb-3">
                                        <label for="NombreRazonSocial" class="form-label">Nombre o Razón Social</label>
                                        <input type="text" class="form-control" id="NombreRazonSocial" name="NombreRazonSocial" placeholder="Ingrese el nombre o razón social">
                                    </div>
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
                                        <div class="mb-3">
                                            <label for="NumProgramaIMMEX" class="form-label">Número de Programa IMMEX</label>
                                            <input type="text" class="form-control" id="NumProgramaIMMEX" name="NumProgramaIMMEX" placeholder="Ingrese el número de programa IMMEX">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ECEX" class="form-label">ECEX</label>
                                            <input type="text" class="form-control" id="ECEX" name="ECEX" placeholder="Ingrese el ECEX">
                                        </div>
                                        <div class="mb-3">
                                            <label for="EmpresaIndustrial" class="form-label">Empresa Industrial</label>
                                            <input type="text" class="form-control" id="EmpresaIndustrial" name="EmpresaIndustrial" placeholder="Ingrese la empresa industrial">
                                        </div>
                                        <div class="mb-3">
                                            <label for="RecintoFiscalizado" class="form-label">Recinto Fiscalizado</label>
                                            <input type="text" class="form-control" id="RecintoFiscalizado" name="RecintoFiscalizado" placeholder="Ingrese el recinto fiscalizado">
                                        </div>
                                    </div>
                                    <div id="camposExtranjero" style="display: none;">
                                        <!-- Campos para Extranjero -->
                                        <div class="mb-3">
                                            <label for="ClaveIdentificacionFiscal" class="form-label">Clave de Identificación Fiscal (CURP o RFC)</label>
                                            <input type="text" class="form-control" id="ClaveIdentificacionFiscal" name="ClaveIdentificacionFiscal" placeholder="Ingrese la clave de identificación fiscal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Segunda Columna -->
                                    <div class="mb-3">
                                        <label for="Calle" class="form-label">Calle</label>
                                        <input type="text" class="form-control" id="Calle" name="Calle" placeholder="Ingrese la calle">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Numero" class="form-label">Número</label>
                                        <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Ingrese el número">
                                    </div>
                                    <div class="mb-3">
                                        <label for="CodigoPostal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal" placeholder="Ingrese el código postal">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Colonia" class="form-label">Colonia</label>
                                        <input type="text" class="form-control" id="Colonia" name="Colonia" placeholder="Ingrese la colonia">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Tercera Columna -->
                                    <div class="mb-3">
                                        <label for="EntidadFederativa" class="form-label">Entidad Federativa</label>
                                        <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa" placeholder="Ingrese la entidad federativa">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Pais" class="form-label">País</label>
                                        <input type="text" class="form-control" id="Pais" name="Pais" placeholder="Ingrese el país">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ContribuyenteID" class="form-label">Contribuyente</label>
                                        <select class="form-select" id="ContribuyenteID" name="ContribuyenteID">
                                            <option value="">Seleccione un contribuyente</option>
                                            <?php
                                            // Conexión a la base de datos
                                            include('conexion.php');
                                            // Consulta SQL para obtener los contribuyentes
                                            $consulta_contribuyentes = "SELECT ContribuyenteID, DenominacionRazonSocial FROM contribuyente";
                                            $resultado_contribuyentes = mysqli_query($conn, $consulta_contribuyentes);
                                            // Iterar sobre los resultados y crear las opciones del select
                                            while ($fila = mysqli_fetch_assoc($resultado_contribuyentes)) {
                                                echo "<option value=\"{$fila['ContribuyenteID']}\">{$fila['DenominacionRazonSocial']}</option>";
                                            }
                                            // Cerrar la conexión
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Registrar Cliente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales de edición de cliente -->
    <?php
    $query = mysqli_query($conn, $consultar);
    while ($row = mysqli_fetch_array($query)) {
    ?>
        <div class="modal fade" id="editarModal<?php echo $row['ClienteID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Cliente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="procesar_edicion_cliente.php" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Primera Columna -->
                                    <input type="hidden" name="ClienteID" value="<?php echo $row['ClienteID']; ?>">
                                    <div class="mb-3">
                                        <label for="NumClaveIdentificacion" class="form-label">Número de Clave de Identificación</label>
                                        <input type="text" class="form-control" id="NumClaveIdentificacion" name="NumClaveIdentificacion" value="<?php echo $row['NumClaveIdentificacion']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NombreRazonSocial" class="form-label">Nombre o Razón Social</label>
                                        <input type="text" class="form-control" id="NombreRazonSocial" name="NombreRazonSocial" value="<?php echo $row['NombreRazonSocial']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Nacionalidad" class="form-label">Nacionalidad</label>
                                        <select class="form-select" id="NacionalidadEditar<?php echo $row['ClienteID']; ?>" name="Nacionalidad" required onchange="mostrarCamposEditar(<?php echo $row['ClienteID']; ?>)">
                                            <option value="<?php echo $row['Nacionalidad']; ?>"><?php echo $row['Nacionalidad']; ?></option>
                                            <option value="Nacional">Nacional</option>
                                            <option value="Extranjero">Extranjero</option>
                                        </select>
                                    </div>
                                    <div id="camposNacionalEditar<?php echo $row['ClienteID']; ?>" style="display:none;">
                                        <!-- Campos para Nacional -->
                                        <div class="mb-3">
                                            <label for="NumProgramaIMMEX" class="form-label">Número de Programa IMMEX</label>
                                            <input type="text" class="form-control" id="NumProgramaIMMEX" name="NumProgramaIMMEX" value="<?php echo $row['NumProgramaIMMEX']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ECEX" class="form-label">ECEX</label>
                                            <input type="text" class="form-control" id="ECEX" name="ECEX" value="<?php echo $row['ECEX']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="EmpresaIndustrial" class="form-label">Empresa Industrial</label>
                                            <input type="text" class="form-control" id="EmpresaIndustrial" name="EmpresaIndustrial" value="<?php echo $row['EmpresaIndustrial']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="RecintoFiscalizado" class="form-label">Recinto Fiscalizado</label>
                                            <input type="text" class="form-control" id="RecintoFiscalizado" name="RecintoFiscalizado" value="<?php echo $row['RecintoFiscalizado']; ?>">
                                        </div>
                                    </div>
                                    <div id="camposExtranjeroEditar<?php echo $row['ClienteID']; ?>" style="display:none;">
                                        <!-- Campos para Extranjero -->
                                        <div class="mb-3">
                                            <label for="ClaveIdentificacionFiscal" class="form-label">Clave de Identificación Fiscal (CURP o RFC)</label>
                                            <input type="text" class="form-control" id="ClaveIdentificacionFiscal" name="ClaveIdentificacionFiscal" value="<?php echo $row['ClaveIdentificacionFiscal']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Segunda Columna -->
                                    <div class="mb-3">
                                        <label for="Calle" class="form-label">Calle</label>
                                        <input type="text" class="form-control" id="Calle" name="Calle" value="<?php echo $row['Calle']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Numero" class="form-label">Numero</label>
                                        <input type="text" class="form-control" id="Numero" name="Numero" value="<?php echo $row['Numero']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="CodigoPostal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal" value="<?php echo $row['CodigoPostal']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Colonia" class="form-label">Colonia</label>
                                        <input type="text" class="form-control" id="Colonia" name="Colonia" value="<?php echo $row['Colonia']; ?>" required>
                                    </div>
                                    <!-- Agregar más campos según sea necesario -->
                                </div>
                                <div class="col-md-4">
                                    <!-- Tercera Columna -->
                                    <div class="mb-3">
                                        <label for="EntidadFederativa" class="form-label">Entidad Federativa</label>
                                        <input type="text" class="form-control" id="EntidadFederativa" name="EntidadFederativa" value="<?php echo $row['EntidadFederativa']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Pais" class="form-label">País</label>
                                        <input type="text" class="form-control" id="Pais" name="Pais" value="<?php echo $row['Pais']; ?>">
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
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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