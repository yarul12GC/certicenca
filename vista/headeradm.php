<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..\estilos/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <header>
        <div>
            <nav class="navegacion">
                <ul class="menu">
                    <li><a href=""> <img src="..\mediahea/lista.png" alt="" width="15px"> catalogos </a>
                        <ul class="submenu">
                            <li><a href="../usuarioadm/usuarios.php"> <img src="../mediahea/usuario.png" width="15px">catalogo de usuarios</a></li>
                            <li><a href="../usuarioadm/modalidades.php"> <i class="fa-solid fa-school"></i></i> catalogo de modalidades</a></li>
                            <li><a href="../usuarioadm/programa.php"> <i class="fa-solid fa-graduation-cap" ></i> catalogo de programas</a></li>
                            <li><a href="../usuarioadm/tipoestudio.php"> <i class="fa-solid fa-building-columns" ></i> catalogo de tipos de estudio</a></li>
                        </ul>
                    </li>

                    <li><a href=""> <img src="..\mediahea/docs.png" alt="" width="15px"> Materiales</a>
                        <ul class="submenu">
                            <li><a href="../usuarioadm/archivoMateriales.php"> <img src="../mediahea/libro.png" width="15px"> Subir Material</a></li>
                            <li><a href="../usuarioadm/materiales.php"> <img src="../mediahea/libro.png" width="15px"> Asignar Material</a></li>
                        </ul>
                    </li>
                   
                </ul>
            </nav>
        </div>
        <nav class="navegacion">
            <ul>

                <li><a href="../usuarioadm/index.php"> <img src="../media/locenca.png" width="45px"></a></li>
            </ul>
        </nav>
        </div>

        <nav class="navegacion">

            <div>
                <ul class="menu2">
                <li><a href="../usuarioadm/certificados.php"> <img src="../mediahea/libro.png" width="15px">Subir Certificados</a></li>
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