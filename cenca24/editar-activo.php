<?php
include 'startSession.php';
require 'conexion.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $ActivoFijoID = $_POST["ActivoFijoID"];
    $OrdenCompra = $_POST["OrdenCompra"];
    $DescripcionMercancia = $_POST["DescripcionMercancia"];
    $Marca = $_POST["Marca"];
    $Modelo = $_POST["Modelo"];
    $NumSerie = $_POST["NumSerie"];
    $FraccionArancelaria = $_POST["FraccionArancelaria"];
    $ContribuyenteID = $_POST["ContribuyenteID"];

    try {
    $actualizar_activo = "UPDATE activofijo SET 

    OrdenCompra = '$OrdenCompra',
    DescripcionMercancia = '$DescripcionMercancia',
    Marca = '$Marca',
    Modelo = '$Modelo',
    NumSerie = '$NumSerie',
    FraccionArancelaria = '$FraccionArancelaria',
    ContribuyenteID = '$ContribuyenteID'
    WHERE ActivoFijoID = '$ActivoFijoID'";

        if (mysqli_query($conn, $actualizar_activo)) {
            // Éxito al actualizar
            header("Location: activo.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
        } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página, todo este codigo se hace en caso de que falle la bd no detenga la pagina y solo nos made el error en mensaje 
        header("Location: activo.php?mensaje=error");
        exit();
        }


    }else {
        header("activo.php");
        exit();
        
    }
?>