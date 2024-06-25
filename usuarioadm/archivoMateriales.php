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
    <link rel="stylesheet" href="../estilos/zona.css">
        <link rel="shortcut icon" href="../edia/locenca.png" type="image/x-icon" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Archivos</title>
</head>
<body>
    <header>
    <?php include '../vista/headeradm.php'; ?>

    </header>
    
    <section class="zona1">
        <fieldset>
            <legend>Carpetas DE Materiales</legend>
        </fieldset>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    subir nuevo Material
    </button>
    <br>
    <br>  
    <?php
        $consultar   = "SELECT * FROM archivo_material ORDER BY ArchivoID DESC";
        $queryUsua = mysqli_query($conexion, $consultar);
        $cantidad     = mysqli_num_rows($queryUsua);
        ?>

                <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">ArchivoID</th>
                        <th scope="col">NombreArchivo</th>
                        <th scope="col">Formato</th>
                        <th scope="col" class="cent">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php while ($row = mysqli_fetch_array($queryUsua)) { ?>
                        <tr>
                            <td><?php echo $row['ArchivoID']; ?></td>
                            <td>
                            <i class="fas fa-file-archive"></i> <?php echo $row['NombreArchivo']; ?>
                            </td>

                            <td><?php echo $row['TipoArchivo']; ?></td>
                            <td class="cent">
                                <button type="button" class="btn btn-danger" onclick="confirmarEliminar(<?php echo $row['ArchivoID']; ?>)">Eliminar</button>
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
    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> SUBIR USUARIO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="subir_material.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_archivo" class="form-label">Nombre del Archivo:</label>
                <input type="text" class="form-control" name="nombre_archivo" id="nombre_archivo" required>
            </div>
            <div class="mb-3">
                <label for="tipo_archivo" class="form-label">Tipo de Archivo:</label>
                <select class="form-select" name="TipoArchivo" id="tipo_archivo" required>
                    <option value="pdf">PDF</option>
                    <option value="zip">ZIP</option>
                    <option value="rar">RAR</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="archivo" class="form-label">Selecciona el archivo:</label>
                <input type="file" class="form-control" name="archivo" id="archivo" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-primary" value="Subir Archivo" name="submit">
            </div> 
        </form>


      </div>
    
    </div>
  </div>
</div>
</body>
</html>
<script>
function confirmarEliminar(archivoID) {
    if (confirm('¿Estás seguro de que quieres eliminar este material?')) {
        // Si el usuario confirma la eliminación, redirecciona a un script de PHP para manejar la eliminación
        window.location.href = 'eliminar_material.php?archivoID=' + archivoID;
    }
}
</script>