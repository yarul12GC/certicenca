<?php
include 'startSession.php';
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="assets/media/icon.png" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    </body>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../cessit/index.php">
                <img src="assets/media/icon.png" alt="" width="30" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            CATALOGOS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="contribuyente.php">Datos Generales del Contribuyente</a></li>
                            <li><a class="dropdown-item" href="proveedores.php">Proveedores</a></li>
                            <li><a class="dropdown-item" href="cliente.php">Clientes</a></li>
                            <li><a class="dropdown-item" href="materiales.php">Materiales</a></li>
                            <li><a class="dropdown-item" href="productos.php">Productos</a></li>
                            <li><a class="dropdown-item" href="submanufactura.php">Submanufactura</a></li>
                            <li><a class="dropdown-item" href="agentes.php"> Agentes / Apoderados Aduanales
                                </a></li>
                            <li><a class="dropdown-item" href="activo.php">Activo Fijo</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            MODULO DE INTERFASES
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="entradas.php">Entradas (Importaciones Temporales).</a></li>
                            <li><a class="dropdown-item" href="salidas.php">Salidas (Retornos, Destrucciones, etc.).</a></li>
                            <li><a class="dropdown-item" href="movimientosmanu.php">Movimientos de Manufact</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            MODULO DE ADUANAS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="aduanasEntradas.php">Información aduanera de Entradas</a></li>
                            <li><a class="dropdown-item" href="infoaduanera.php">Información aduanera de Salidas</a></li>
                            <li><a class="dropdown-item" href="aduanasActivo.php">Módulo de Activo Fijo</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            MODULO DE PROCESOS </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="moduloEntradas.php">Proceso de Entradas</a></li>
                            <li><a class="dropdown-item" href="modulosalidas.php">Proceso de Salidas</a></li>
                            <li><a class="dropdown-item" href="procesomovimientos.php">Proceso de Movimientos y Ajustes de Manufactura</a></li>
                            <li><a class="dropdown-item" href="aduanaDescargos.php">Proceso de Descargos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            MODULO DE REPORTES
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="reporteentradas.php">Reporte de Entrada de Mercancías de Importación Temporal</a></li>
                            <li><a class="dropdown-item" href="reporteSalidas.php">Reporte de Salida de Mercancías de Importación Temporal</a></li>
                            <li><a class="dropdown-item" href="reportemovimientos.php">Reporte de Saldos de Mercancías de Importación Temporal</a></li>
                            <li><a class="dropdown-item" href="reporteDescargos.php">Reporte de Descargos de Materiales</a></li>
                            <li><a class="dropdown-item" href="reporteAjuste.php">Reporte de Ajustes</a></li>
                        </ul>
                    </li>


                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="salir.php">
                            <img src="assets/media/cerrarS.png" alt="Cerrar Sesión" width="15px" height="15px">
                            CERRAR SESIÓN
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>

</html>