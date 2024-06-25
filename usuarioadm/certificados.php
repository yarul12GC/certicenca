<?php
include('conexion.php');
include('validarsesion.php');
include('../vista/mensaje.php');

// Verificar la conexión a la base de datos
if (!$conexion) {
    die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
}

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
    <title>Certificados</title>
</head>
<body>
<header>
    <?php include '../vista/headeradm.php'; ?>
</header>
<section class="zona1">
<fieldset>
    <legend>Certificados</legend>
    <input type="text" name="buscar" placeholder="Buscar" class="form-control buscar" oninput="filtrarTabla()">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoarchivo">Subir Certificado</button><br>
    <br>
    <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Nombre del Certificado</th>
            <th>Tamaño del Certificado</th>
            <th>Usuario</th>
            <th class="cent">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include('conexion.php');
        function formatBytes($bytes, $precision = 2) {
            $base = log($bytes, 1024);
            $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
            return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
        }

        $consultaCertificados = "SELECT CertificadoID, NombreCertificado, LENGTH(ArchivoPDF) AS Tamano, Nombre, Matricula FROM certificados
                                INNER JOIN usuarios ON certificados.UsuarioID = usuarios.UsuarioID";
        $resultadoCertificados = mysqli_query($conexion, $consultaCertificados);

        while ($fila = mysqli_fetch_assoc($resultadoCertificados)) {
            ?>
            <tr>
                <td>
                    <a href="visualizar_certificado.php?id=<?php echo $fila['CertificadoID']; ?>" target="_blank">
                        <i class="fas fa-file-pdf text-danger fa-2x"></i> <?php echo $fila['NombreCertificado']; ?>
                    </a>
                </td>
                <td><?php echo formatBytes($fila['Tamano']); ?></td>
                <td><i class="fas fa-user"></i><?php echo $fila['Nombre'] . ' (' . $fila['Matricula'] . ')'; ?></td>
                <td class="cent">
                    <a href="descargar_certificado.php?id=<?php echo $fila['CertificadoID']; ?>" class="btn btn-primary">Descargar</a>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar_<?php echo $fila['CertificadoID']; ?>">Editar</button>
                    <button class="btn btn-danger" onclick="confirmarEliminar(<?php echo $fila['CertificadoID']; ?>)">Eliminar</button>
                </td>
            </tr>
            <?php
        }

        mysqli_free_result($resultadoCertificados);
        mysqli_close($conexion);
        ?>
    </tbody>
        </table>
    </fieldset>
</section>

<footer>
    <?php include '../vista/footer.php'; ?>
</footer>
</script>
</body>



<div class="modal fade" id="nuevoarchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> SUBIR CERTIFICADO</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="procesar_certificado.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <label for="usuarioID" class="form-label">Usuario:</label>
            <input type="text" id="buscador" oninput="buscarUsuario()" placeholder="Buscar por matrícula o nombre" class="form-control mb-3">
            <select name="usuarioID" id="selectUsuarios" required class="form-select mb-3">
            <option value="">--Usuario--</option>
                <?php
                include('conexion.php'); 
                $consultaUsuarios = "SELECT UsuarioID, Matricula, Nombre, ApellidoPaterno FROM usuarios";
                $resultadoUsuarios = mysqli_query($conexion, $consultaUsuarios);
                while ($fila = mysqli_fetch_assoc($resultadoUsuarios)) {
                    echo "<option value='{$fila['UsuarioID']}'>{$fila['Matricula']} - {$fila['Nombre']} {$fila['ApellidoPaterno']}</option>";
                }
                mysqli_free_result($resultadoUsuarios);
                mysqli_close($conexion);
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="nombreCertificado" class="form-label">Nombre del Certificado:</label>
            <input type="text" name="nombreCertificado" required class="form-control mb-3">

            <label for="archivoPDF" class="form-label">Archivo PDF:</label>
            <input type="file" name="archivoPDF" accept=".pdf" required class="form-control mb-3">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="mostrarAlerta()">Subir Certificado</button>
    </div>
</form>
<script>
    function mostrarAlerta() {
        alert("¡Certificado subido exitosamente!");
    }
</script>
        <script>
            function buscarUsuario() {
                var busqueda = document.getElementById('buscador').value.toUpperCase();
                var opciones = document.getElementById('selectUsuarios').options;
                for (var i = 0; i < opciones.length; i++) {
                    var textoUsuario = opciones[i].text.toUpperCase();
                    opciones[i].style.display = textoUsuario.includes(busqueda) ? 'block' : 'none';
                }
            }
        </script>
      </div>
      
    </div>
  </div>
</div>

<?php
include('conexion.php');
$querycert = mysqli_query($conexion, $consultaCertificados);

while ($fila = mysqli_fetch_array($querycert)) {
    ?>
    <div class="modal fade" id="editar_<?php echo $fila['CertificadoID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> <img src="../media/locenca.png" width="40px"> EDITAR CERTIFICADO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="procesar_edicion_certificado.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="certificadoID" value="<?php echo $fila['CertificadoID']; ?>">
                        <div class="mb-3">
                            <label for="nombreCertificado" class="form-label">Nuevo Nombre del Certificado:</label>
                            <input type="text" name="nuevoNombreCertificado" value="<?php echo $fila['NombreCertificado']; ?>" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <?php
}
mysqli_close($conexion);
?>


<script>
function confirmarEliminar(certificadoID) {
    if (confirm("¿Estás seguro de que deseas eliminar este certificado?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_certificado.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                location.reload();
            }
        };
        xhr.send("certificadoID=" + certificadoID);
    }
}
    function mostrarAlerta() {
        alert("¡Certificado subido exitosamente!");
    }
    function filtrarTabla() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.querySelector('.buscar');
        filter = input.value.toUpperCase();
        table = document.querySelector('.table');
        tr = table.getElementsByTagName('tr');

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName('td')[2];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
    </script>

</html>