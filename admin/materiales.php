<?php
include '../admin/sesion.php';
include '../admin/conexion.php';
include '../vista/mensaje.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales</title>
    <link rel="stylesheet" href="../estilos/zona.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
    <?php include '../vista/header.php'; ?>
    </header>

    <section class="zona1">
    <h2><strong>Materiales de los Talleres</strong></h2><br>

    <div class="row">
        <div class="col-xs-12">
            <p align="left"><b>Instrucciones:</b></p>
            <p align="justify">Los archivos que se encuentran en la parte inferior son materiales de los talleres que has completado y puedes consultar las veces que consideres necesario. Si requieres información específica, te sugerimos contactar nuestro departamento <strong>Administrativo CENCA.</strong></p><br>
    </div>
    
         
    <table class="table table-bordered table-hover">
    <thead class="encabezadot">
        <tr>
            <th>Nombre del Archivo</th>
            <th>Programa de Estudio</th>
            <th>Tipo de Archivo</th>
            <th>Tamaño</th>
            <th>Descargar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $email = $_SESSION['email'];
        $query = "SELECT am.MaterialID, a.NombreArchivo, p.NombrePrograma, a.TipoArchivo
                  FROM asignaciones_materiales am
                  INNER JOIN programasestudio p ON am.ProgramaID = p.ProgramaID
                  INNER JOIN usuarios u ON am.UsuarioID = u.UsuarioID
                  INNER JOIN archivo_material a ON am.MaterialID = a.ArchivoID
                  WHERE u.email = '$email'";
        $result = $conexion->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nombre_archivo = $row['NombreArchivo'];
                $carpeta_archivos_subidos = '../archivos_subidos/';
                $ruta_archivo = $carpeta_archivos_subidos . $nombre_archivo;
                ?>
                <tr>
                    <td class="info"><i class="fas fa-file-archive"></i> <?php echo  $nombre_archivo; ?></td>
                    <td class="info"><?php echo $row['NombrePrograma']; ?></td>
                    <td class="info"><?php echo $row['TipoArchivo']; ?></td>
                    <td class="info">
                        <?php
                        if (file_exists($ruta_archivo)) {
                            $size = round(filesize($ruta_archivo) / 1024, 2) . ' KB';
                            echo $size;
                        } else {
                            echo "Archivo no disponible";
                        }
                        ?>
                    </td>
                    <td class="info">
                        <?php if (file_exists($ruta_archivo)) : ?>
                            <a href="<?php echo $ruta_archivo; ?>" class="btn btn-primary" download="<?php echo $nombre_archivo; ?>">Descargar</a>
                        <?php else : ?>
                            <span class="text-danger">Archivo no disponible</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">No hay materiales disponibles para tu programa de estudio.</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<?php
$conexion->close();
?>

    </section>

    <footer>
    <?php include '../vista/footer.php'; ?>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>
