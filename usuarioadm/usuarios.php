<?php
include('conexion.php');
include('validarsesion.php');
include('../vista/mensaje.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../media/locenca.png" type="image/x-icon" />
    <link rel="stylesheet" href="../estilos/zona.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>usuarios</title>
</head>

<body>
    <header>
        <?php include '../vista/headeradm.php'; ?>
    </header>
    <section class="zona1">
         <?php
        $consultar   = "SELECT * FROM usuarios ORDER BY UsuarioID DESC";
        $queryUsua = mysqli_query($conexion, $consultar);
        $cantidad     = mysqli_num_rows($queryUsua);
        ?>

        <fieldset class="fiel">
            <legend>usuarios</legend>
            <br>
                <input type="text" name="buscar" placeholder="Buscar" class="form-control buscar" oninput="filtrarTabla()">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">Nuevo Usuario</button><br><br>
             

                <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Matricula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>

                        <th scope="col">Apellido</th>
                        <th scope="col">Folio de Control</th>
                        <th scope="col">Estatus</th>
                        <th scope="col" class="cent">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php while ($row = mysqli_fetch_array($queryUsua)) { ?>
                        <tr>
                            <td><?php echo $row['Matricula']; ?></td>
                            <td><i class="fas fa-user"></i> <?php echo $row['Nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['ApellidoPaterno']; ?></td>
                            <td><?php echo $row['FolioControl']; ?></td>
                            <td><?php echo $row['Estatus']; ?></td>
                            <td class="cent">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar_<?php echo $row['UsuarioID']; ?>">Editar</button>
                                <button type="button" class="btn btn-danger" onclick="confirmarEliminar(<?php echo $row['UsuarioID']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </fieldset>
    </section>

<footer>
    <?php include '../vista/footer.php'; ?>
</footer>

<!-- nuevo usuario -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> REGISTRAR USUARIO</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section class="form-register">
                    <form action="registrobe.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <label class="col-md-12 text-white"><strong>Ingresa los siguientes datos para generar tu perfil</strong></label>

                            <div class="col-md-4">
                                <!-- Primera Columna -->
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Nombre </label>
                                    <input class="form-control" type="text" name="Nombre" placeholder="Nombre">
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Apellido Paterno </label>
                                    <input class="form-control" type="text" name="ApellidoPaterno" placeholder="Apellido Paterno">
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Apellido Materno </label>
                                    <input class="form-control" type="text" name="ApellidoMaterno" placeholder="Apellido Materno">
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Correo </label>
                                    <input class="form-control" type="text" name="email" placeholder="Correo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Segunda Columna -->
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Contraseña </label>
                                    <input class="form-control" type="password" name="contrasena" id="contrasena" placeholder="Contraseña" minlength="8">
                                    <small class="text-white">La contraseña debe tener al menos 8 caracteres.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Confirma tu Contraseña </label>
                                    <input class="form-control" type="password" name="confirm_contrasena" id="confirm_contrasena" placeholder="Confirmar Contraseña" minlength="8">
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Tipo de usuario </label>
                                    <select required="required" name="TipoUsuarioID" class="form-control">
                                        <option value="">-- Tipo de Usuario --</option>
                                        <?php
                                        include 'conexion.php';
                                        $tiposUsuarios = mysqli_query($conexion, "SELECT TipoUsuarioID, NombreTipoUsuario FROM tiposusuarios");

                                        while ($datos = mysqli_fetch_array($tiposUsuarios)) {
                                        ?>
                                            <option value="<?php echo $datos['TipoUsuarioID']; ?>"><?php echo $datos['NombreTipoUsuario']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Tercera Columna -->
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Tipo de Estudio </label>
                                    <select class="form-control" required="required" name="TipoEstudioID">
                                        <option value="">--Tipo Estudio--</option>
                                        <?php
                                        include 'conexion.php';
                                        $estudio = mysqli_query($conexion, "SELECT TipoEstudioID, NombreTipoEstudio FROM tiposestudio");

                                        while ($datos = mysqli_fetch_array($estudio)) {
                                        ?>
                                            <option value="<?php echo $datos['TipoEstudioID']; ?>"><?php echo  $datos['NombreTipoEstudio']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Programa de Estudio</label>
                                    <select class="form-control" required="required" name="ProgramaID">
                                        <option value="">--Programa--</option>
                                        <?php
                                        include 'conexion.php';
                                        $programa = mysqli_query($conexion, "SELECT ProgramaID, NombrePrograma FROM programasestudio");

                                        while ($datos = mysqli_fetch_array($programa)) {
                                        ?>
                                            <option value="<?php echo $datos['ProgramaID']; ?>"><?php echo  $datos['NombrePrograma']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="control-label mb-3" for="Estatus">Modalidad de Estudio </label>
                                    <select class="form-control" required="required" name="ModalidadID">
                                        <option value="">--Modalidad--</option>
                                        <?php
                                        include 'conexion.php';
                                        $programa = mysqli_query($conexion, "SELECT ModalidadID, NombreModalidad FROM modalidadesestudio");

                                        while ($datos = mysqli_fetch_array($programa)) {
                                        ?>
                                            <option value="<?php echo $datos['ModalidadID']; ?>"><?php echo  $datos['NombreModalidad']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="control-label mb-3" for="Estatus">Estatus </label>
                                <div class="mb-3 boton1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" checked="checked" id="activo" name="Estatus" type="radio" value="Activo" required>
                                        <label class="form-check-label" for="activo">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="inactivo" name="Estatus" type="radio" value="Inactivo" required>
                                        <label class="form-check-label" for="inactivo">Inactivo</label>
                                    </div>
                                    <span class="field-validation-valid text-danger" data-valmsg-for="Estatus" data-valmsg-replace="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="register" value="Enviar">Registrarme</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

<?php
// Editar usuario
$queryUsua = mysqli_query($conexion, $consultar); // Vuelve a ejecutar la consulta para resetear el puntero
while ($row = mysqli_fetch_array($queryUsua)) {
    ?>
    <div class="modal fade" id="editar_<?php echo $row['UsuarioID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 80vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> EDITAR USUARIO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="actualizarUsuario.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Primera Columna -->
                                <input class="form-control" type="hidden" name="Matricula" value="<?php echo $row['Matricula']; ?>">

                                <div class="mb-3">
                                    <label for="Nombre">Nombre:</label>
                                    <input class="form-control" type="text" name="Nombre" value="<?php echo $row['Nombre']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="ApellidoPaterno">Apellido Paterno:</label>
                                    <input class="form-control" type="text" name="ApellidoPaterno" value="<?php echo $row['ApellidoPaterno']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="ApellidoMaterno">Apellido Materno:</label>
                                    <input class="form-control" type="text" name="ApellidoMaterno" value="<?php echo $row['ApellidoMaterno']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email">Correo:</label>
                                    <input class="form-control" type="text" name="email" value="<?php echo $row['email']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Segunda Columna -->

                                <!-- contraseña oculta -->
                                <div class="mb-3">
                                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                                    <input class="form-control" type="password" name="nueva_contrasena" placeholder="Nueva Contraseña" minlength="8">
                                    <small class="text-white">La contraseña debe tener al menos 8 caracteres.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                                    <input class="form-control" type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" minlength="8">
                                </div>
                                <div class="mb-3">
                                    <label for="TipoEstudioID">Tipo Estudio:</label>
                                    <select class="form-control" required="required" name="TipoEstudioID">
                                        <option value="">--Tipo Estudio--</option>
                                        <?php
                                        $estudio = mysqli_query($conexion, "SELECT TipoEstudioID, NombreTipoEstudio FROM tiposestudio");

                                        while ($datos = mysqli_fetch_array($estudio)) {
                                        ?>
                                            <option value="<?php echo $datos['TipoEstudioID']; ?>" <?php echo ($row['TipoEstudioID'] == $datos['TipoEstudioID']) ? 'selected' : ''; ?>>
                                                <?php echo  $datos['NombreTipoEstudio']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Tercera Columna -->
                                <div class="mb-3">
                                    <label for="ProgramaID">Programa:</label>
                                    <select class="form-control" required="required" name="ProgramaID">
                                        <option value="">--Programa--</option>
                                        <?php
                                        $programa = mysqli_query($conexion, "SELECT ProgramaID, NombrePrograma FROM programasestudio");

                                        while ($datos = mysqli_fetch_array($programa)) {
                                        ?>
                                            <option value="<?php echo $datos['ProgramaID']; ?>" <?php echo ($row['ProgramaID'] == $datos['ProgramaID']) ? 'selected' : ''; ?>>
                                                <?php echo  $datos['NombrePrograma']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="ModalidadID">Modalidad:</label>
                                    <select class="form-control" required="required" name="ModalidadID">
                                        <option value="">--Modalidad--</option>
                                        <?php
                                        $modalidad = mysqli_query($conexion, "SELECT ModalidadID, NombreModalidad FROM modalidadesestudio");

                                        while ($datos = mysqli_fetch_array($modalidad)) {
                                        ?>
                                            <option value="<?php echo $datos['ModalidadID']; ?>" <?php echo ($row['ModalidadID'] == $datos['ModalidadID']) ? 'selected' : ''; ?>>
                                                <?php echo  $datos['NombreModalidad']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="TipoUsuarioID">Tipo de Usuario:</label>
                                    <select class="form-control" required="required" name="TipoUsuarioID">
                                        <option value="">-- Tipo de Usuario --</option>
                                        <?php
                                        $tiposUsuarios = mysqli_query($conexion, "SELECT TipoUsuarioID, NombreTipoUsuario FROM tiposusuarios");

                                        while ($datos = mysqli_fetch_array($tiposUsuarios)) {
                                        ?>
                                            <option value="<?php echo $datos['TipoUsuarioID']; ?>" <?php echo ($row['TipoUsuarioID'] == $datos['TipoUsuarioID']) ? 'selected' : ''; ?>>
                                                <?php echo $datos['NombreTipoUsuario']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="hidden" name="FolioControl" value="<?php echo $row['FolioControl']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="Estatus">Estatus:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="activo" name="Estatus" type="radio" value="Activo" <?php echo ($row['Estatus'] == 'Activo') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="activo">Activo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="inactivo" name="Estatus" type="radio" value="Inactivo" <?php echo ($row['Estatus'] == 'Inactivo') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="inactivo">Inactivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="UsuarioID" value="<?php echo $row['UsuarioID']; ?>">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="update">Guardar Cambios</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
        function filtrarTabla() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.querySelector('.buscar');
            filter = input.value.toUpperCase();
            table = document.querySelector('.table');
            tr = table.getElementsByTagName('tr');

            for (i = 0; i < tr.length; i++) {
                var visible = false;
                var tds = tr[i].getElementsByTagName('td');
                for (var j = 0; j < tds.length; j++) {
                    td = tds[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            visible = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = visible ? '' : 'none';
            }
        }

        function confirmarEliminar(usuarioID) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                window.location.href = 'eliminarUsuario.php?id=' + usuarioID;
            }
        }
    </script>
</html>
