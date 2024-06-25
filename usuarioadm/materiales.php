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
    <link rel="shortcut icon" href="..\media/locenca.png" type="image/x-icon" />
    <link rel="stylesheet" href="..\estilos/zona.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Asignar materiales</title>
</head>
<body>
    <header>
    <?php include '../vista/headeradm.php'; ?>
    </header>

        <section class="zona1">
        <fieldset class="fiel">
            <legend>Materiales</legend>
            <input type="text" name="buscar" placeholder="Buscar" class="form-control buscar" oninput="filtrarTabla()">
    
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subirmM"> Subir Material </button>
        <br>
        <br>
<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Consulta para obtener los datos requeridos
$query = "SELECT u.Nombre AS NombreUsuario, p.NombrePrograma, a.NombreArchivo, am.AsignacionID
          FROM asignaciones_materiales am
          INNER JOIN usuarios u ON am.UsuarioID = u.UsuarioID
          INNER JOIN programasestudio p ON am.ProgramaID = p.ProgramaID
          INNER JOIN archivo_material a ON am.MaterialID = a.ArchivoID";

$resultado = $conexion->query($query);
?>

<!-- Tabla HTML utilizando Bootstrap -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Nombre del Usuario</th>
                <th>Programa de Estudio</th>
                <th>Nombre del Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Verificar si hay resultados en la consulta
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    ?>
                    <tr>
                       <td>
                            <i class="fas fa-user"></i> <?php echo $fila["NombreUsuario"]; ?>
                        </td>
                        <td><?php echo $fila["NombrePrograma"]; ?></td>
                        <td>
                            <i class="fas fa-file-archive"></i> <?php echo $fila['NombreArchivo']; ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="confirmarEliminar(<?php echo $fila['AsignacionID']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // No hay asignaciones disponibles
                ?>
                <tr>
                    <td colspan="4">No hay asignaciones de materiales.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

        </section>

    <footer><?php include '../vista/footer.php'; ?></footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="subirmM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> ASIGNAR MATERIAL</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form action="asignar_material.php" method="post">
    <div class="mb-3">
        <label for="programa" class="form-label">Selecciona el programa de estudio:</label>
        <select class="form-select" required name="ProgramaID">
            <option value="">--Programa--</option>
            <?php
            include 'conexion.php';
            $query_programas = "SELECT ProgramaID, NombrePrograma FROM programasestudio";
            $result_programas = mysqli_query($conexion, $query_programas);

            while ($programa = mysqli_fetch_assoc($result_programas)) {
                echo "<option value='" . $programa['ProgramaID'] . "'>" . $programa['NombrePrograma'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="material" class="form-label">Selecciona el material:</label>
        <select class="form-select" required name="MaterialID" id="MaterialID">
            <option value="">--Material--</option>
            <?php
            $query_materiales = "SELECT ArchivoID, NombreArchivo, TipoArchivo FROM archivo_material";
            $result_materiales = mysqli_query($conexion, $query_materiales);

            while ($material = mysqli_fetch_assoc($result_materiales)) {
                echo "<option value='" . $material['ArchivoID'] . "'>" . $material['NombreArchivo'] . " (" . strtoupper($material['TipoArchivo']) . ")</option>";
            }
            ?>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <input type="submit" class="btn btn-primary" value="Asignar Material" name="submit">
    </div>
</form>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    function confirmarEliminar(asignacionID) {
        // Mostrar un cuadro de diálogo para confirmar la eliminación
        if (confirm('¿Estás seguro de que quieres eliminar esta asignación de material?')) {
            // Si el usuario confirma, redirigir a la página que procesa la eliminación
            window.location.href = 'eliminar_asignacion.php?id=' + asignacionID;
        }
    }
</script>

</html>