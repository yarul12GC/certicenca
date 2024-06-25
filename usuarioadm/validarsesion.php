<?php
session_start();

if (!isset($_SESSION['usuarioID'])) {
    echo '<script> 
            alert("Acceso denegado, no autenticado.");
            window.location = "../index.php";
          </script>';
    exit();
}

