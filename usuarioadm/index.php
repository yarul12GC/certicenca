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
    <link rel="stylesheet" href="../estilos/zona2.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home Admin</title>
</head>
<body>
<header>
    <?php
    include '../vista/headeradm.php'
    ?>
</header>
<section class="zona1">
<div class="zona2">
<img src="..\media/locenca.png" alt="" class="logoini">
<h1><strong>CERTICENCA.</strong></h1>
<br>
<h5><strong>Obciones Rapidas</strong></h5>
<div class="botons">

            <div class="contenedor1" id="sinco">
                <a href="../usuarioadm/usuarios.php"><img src="../media/equipo.png" class="icon"></a>
                <p class="texto">USUARIOS.</p>
            </div>

            <div class="contenedor1" id="seis">
                <a href="../usuarioadm/certificados.php"><img src="../media/subir-archivo.png" class="icon"></a>
                <p class="texto">SUBIR CERTIFICADOS.</p>
            </div>

            <div class="contenedor" id="siete">
            <div class="ayuda">
                <div class="icon-container">
                    <a href="https://wa.me/+5217295279859" class="icon" target="_blank" rel="noopener noreferrer">
                        <img src="../media/whatsapp.png" class="iconwats" alt="Icono de WhatsApp">
                    </a>
                    <span class="tooltip">Si necesitas ayuda, ve a nuestra conversacion de WhatsApp</span>
                </div>
            </div>
                <p class="texto">AYUDA.</p>
            </div>


            <div class="contenedor1" id="seis">
                <a href="../cenca24/contribuyente.php"><img src="../media/aduana.png" class="icon"></a>
                <p class="texto">SECCIT.</p>
            </div>

            <div class="contenedor1" id="sinco">
                <a href="../admin/index.php"><img src="../media/certificado.png" class="icon"></a>
                <p class="texto">CERTICENCA C.</p>
            </div>
            <div class="contenedor1" id="sinco">
                <a href="http://localhost/pedimento/admin/index.php"><img src="../media/certificado.png" class="icon"></a>
                <p class="texto">PEDIMENTO</p>
            </div>

        </div>
</div>

</section>

<footer>
    <?php include '../vista/footer.php'; ?>
</footer>
    
</body>
</html>