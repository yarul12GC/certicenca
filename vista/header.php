<?php
include('../admin/sesion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/header.css">
</head>
<body>
    <header>
        <div>
            <nav class="navegacion">
                <ul class="menu">
                    <li><a href=""> <img src="../mediahea/lista.png" alt="" width="15px"> Datos </a>
                        <ul class="submenu">
                            <li><a href="../admin/index.php"> <img src="../mediahea/usuario.png" width="15px">datos del alumno</a></li>
                        </ul>
                    </li>
                    <li><a href=""> <img src="..\mediahea/docs.png" alt="" width="15px"> Certificacion</a>
                        <ul class="submenu">
                            <li><a href="../admin/cert.php"> <img src="../mediahea/docs.png" width="15px">certificados</a></li>
                            <li><a href="../admin/materiales.php"> <img src="../mediahea/docs.png" width="15px">Materiales</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <nav class="navegacion">
            <ul>
                <li><a href="../admin/index.php"> <img src="../media/locenca.png" width="45px"></a></li>
            </ul>
        </nav>
        </div>
        <nav class="navegacion">
            <div>
                <ul class="menu2">
                
                    <li><a href="https://wa.me/+527295279859" target="_blank" rel="noopener noreferrer"> <img src="../media/whatsapp.png" alt="" width="20px"> Ayuda</a></li>
                    <li><a href="../salir.php"> <img src="../mediahea/cerrar.png" alt="" width="15px"> Cerrar sesion</a></li>
                </ul>
            </div>
        </nav>
    </header>
</body>
</html>

<script>
    function toggleMenu() {
        var menu = document.querySelector('navegacion');
        menu.classList.toggle('show');
    }
</script>
