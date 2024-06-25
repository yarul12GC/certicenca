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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Modalidades</title>
</head>
<body>
<header>
    <?php include '../vista/headeradm.php'; ?>
</header>
<section class="zona1">

<?php
    include('conexion.php');

    $consultar   = "SELECT * FROM modalidadesestudio ORDER BY ModalidadID DESC";
    $querymod = mysqli_query($conexion, $consultar);
    $cantidad     = mysqli_num_rows($querymod);
    ?>

<fieldset>
    <legend>Modalidad De Esestudio</legend>
    <br>
    <form action="catalogoCarreras.php" class="formulario" method="POST">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalidadnv">Nueva Modalidad</button>
    </form>

    <table class="table">
  <thead class="">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nombre</th>
      
      <th scope="col" class="cent">Acciones</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
  <?php            while ($row = mysqli_fetch_array($querymod)) {
            ?>
                <tr>
                    <td><?php echo $row['ModalidadID']; ?></td>
                    <td><?php echo $row['NombreModalidad']; ?></td>
                    <td class="cent">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar_<?php echo $row['ModalidadID']; ?>">Editar</button>
                    <button type="button" class="btn btn-danger" onclick="confirmarEliminar(<?php echo $row['ModalidadID']; ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php
            }
            ?>
            <script>
    function confirmarEliminar(ModalidadID) {
        var confirmacion = confirm("¿Seguro que deseas eliminar este registro?");

        if (confirmacion) {
            window.location.href = 'eliminar_modalidad.php?id=' + ModalidadID;
        } else {
          
        }
    }
</script>
        </tbody>
    
</table>
</fieldset>
</section>

<footer>
    <?php include '../vista/footer.php'; ?>
</footer>
    
</body>

<!-- Modal  nueva modalidad-->
<div class="modal fade" id="modalidadnv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> Nueva Modalidad</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="agregar_modalidad.php" method="POST">
                    <label for="NombreModalidad" class="form-label">Nombre del Tipo de Estudio:</label>
                    <input type="text" class="form-control" id="NombreModalidad" name="NombreModalidad" required>
                    <br>
                    <div class="modal-footer"> 
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
                </form>
      </div>
    </div>
  </div>
</div>
<?php
$querymod = mysqli_query($conexion, $consultar); 
while ($row = mysqli_fetch_array($querymod)) {
    ?>
<!-- Modal editar modalidad -->
<div class="modal fade" id="editar_<?php echo $row['ModalidadID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> Editar Modalidad</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="editar_modalidad.php" method="post" enctype="multipart/form-data">
    <div class="row">
            <input class="form-control" type="hidden" name="ModalidadID" value="<?php echo $row['ModalidadID']; ?>">
            <div class="mb-3">
                <label for="Nombre">Tipo De Estudio</label>
                <input class="form-control" type="text" name="NombreModalidad" value="<?php echo $row['NombreModalidad']; ?>">
            </div>
      </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Guardar</button>
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
</html>