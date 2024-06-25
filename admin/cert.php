<?php
include '../admin/sesion.php';
include '../admin/conexion.php';
include('../vista/mensaje.php');
$conexion = new mysqli($servidor, $usuario, $password, $db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
$email = $_SESSION['email'];
$consultaUsuario = $conexion->prepare("SELECT UsuarioID FROM usuarios WHERE email = ?");
$consultaUsuario->bind_param('s', $email);
$consultaUsuario->execute();
$resultadoUsuario = $consultaUsuario->get_result();
$usuario = $resultadoUsuario->fetch_assoc();
// Obtener certificados del usuario
$usuarioID = $usuario['UsuarioID'];
$consultaCertificados = $conexion->prepare("SELECT * FROM certificados WHERE UsuarioID = ?");
$consultaCertificados->bind_param('i', $usuarioID);
$consultaCertificados->execute();
$resultadoCertificados = $consultaCertificados->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTENEDOR</title>
    <link rel="shortcut icon" href="..\media/locenca.png" type="image/x-icon" />
    <link rel="stylesheet" href="..\estilos/zona.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<header>
    <?php include '../vista/header.php'; ?>
</header>

<section class="zona1">
    <h2><strong>Documentos Legalizados</strong></h2><br>

    
                <li class="usu">Hola <strong><?php echo $_SESSION['email']; ?></strong></li>
            
     
    <div class="row">
        <div class="col-xs-12">
            <p align="left"><b>Instrucciones:</b></p>
            <p align="justify">Los documentos que se encuentran en la parte inferior, están en formato PDF y pueden ser descargados las veces que consideres necesario. Si requieres información específica, te sugerimos contactar nuestro departamento <strong>Administrativo CENCA.</strong></p><br>
            <p align="justify">
            Además, te ofrecemos acceso al material proporcionado durante los talleres que has participado con <strong>CENCA COMEX.</strong> Para acceder, haz clic en el botón <strong>MIS MATERIALES</strong> y serás dirigido al repositorio donde encontrarás recursos relacionados con los talleres que has completado."   
           </p><br>
            <p align="justify"><a href="materiales.php">
            <button type="button" class="btn btn-success"><i style="color: #ffffff;"><img src="..\mediahea/docs.png" width="15px"></i> MIS MATERIALES</button>
            </a></p><br>


        </div>

        <table class="table table-bordered table-hover">
        <thead class="encabezadot">
            <tr>
                <th scope="col">Nombre del Certificado</th>
                <th scope="col">Tamaño</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($certificado = $resultadoCertificados->fetch_assoc()) : ?>
                <tr>
                    <td class="info1">
                    <a href="vicertificado.php?id=<?php echo $certificado['CertificadoID']; ?>" target="_blank">
                    <i class="fas fa-file-pdf text-danger fa-2x"></i> <?php echo $certificado['NombreCertificado']; ?>
                 </a>
                    </td>
                    <td class="info">
                        <?php
                        $tamanioKB = round(strlen($certificado['ArchivoPDF']) / 1024, 2);
                        echo "$tamanioKB KB";
                        ?>
                    </td>
                    <td class="info">
                    <a href="descargar_certificado.php?id=<?php echo $certificado['CertificadoID']; ?>" class="btn btn-primary">Descargar</a>
                    </td>
                </div>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</section>
<footer>
    <?php include '../vista/footer.php'; ?>
</footer>
</body>
</html>
