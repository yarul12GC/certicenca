<?php
include('../conexion.php');

// Obtener la ruta absoluta a la carpeta cenca24
$ruta_cenca24 = $_SERVER['DOCUMENT_ROOT'] . "/cessit/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../media/locenca.png" type="image/x-icon" />
    <link rel="stylesheet" href="../estilos/panel.css">
    <link rel="stylesheet" href="../estilos/zona.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home Cessit</title>
</head>
<body>
<header>
    <?php include '../vista/cabezaPANEL.php'; ?>
</header>
<section class="zona1">
<div class="zona2">
<img src="../media/locenca.png" alt="" class="" width="10%" height="10%">
<h1><strong>CENCACOMEX.</strong></h1>

<br>
<h5><strong>Opciones Rapidas</strong></h5>
<div class="botons">

            <div class="contenedor1" id="sinco">
                <a href="../admin/index.php"><img src="../media/certificado.png" class="icon"></a>
                <p class="texto">CERTICENCA</p>

            </div>

            <div class="contenedor3" id="siete">
            <div class="ayuda">
                    <div class="icon-container">
                        <a href="https://wa.me/+5217295279859" class="icon" target="_blank" rel="noopener noreferrer">
                            <img src="../media/whatsapp.png" class="iconwats" alt="Icono de WhatsApp">
                        </a>
                        <span class="tooltip">Si necesitas ayuda, ve a nuestra conversacion de WhatsApp</span>
                    </div>
            </div>
                    <p class="texto">Ayuda</p>
            </div>


            <div class="contenedor1" id="seis">
                <a href="https://certicenca.cencacomex.com.mx/cenca24/contribuyente.php"><img src="../media/aduana.png" class="icon"></a>
                <p class="texto">SECCIT</p>

            </div>
           

        </div>
</div>

</section>

<footer>
    <?php include '../vista/footer.php'; ?>
</footer>
    
</body>
</html>
