<?php 
include 'startSession.php';
require "conexion.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $activoFijoID = $_POST["ActivoFijoID"];
    $ordenCompra = $_POST["OrdenCompra"];
    $descripcionMercancia = $_POST["DescripcionMercancia"];
    $marca = $_POST["Marca"];
    $modelo = $_POST["Modelo"];
    $numSerie = $_POST["NumSerie"];
    $fraccionArancelaria = $_POST["FraccionArancelaria"];
    $contribuyenteID = $_POST["ContribuyenteID"];

    try {
        $query = "INSERT INTO activofijo(
            OrdenCompra,
            DescripcionMercancia,
            Marca,
            Modelo,
            NumSerie,
            FraccionArancelaria,
            ContribuyenteID)
            VALUES(
            '$ordenCompra',
            '$descripcionMercancia',
            '$marca',
            '$modelo',
            '$numSerie',
            '$fraccionArancelaria',
            '$contribuyenteID')";

            if (mysqli_query($conn, $query)) {

            header("location: activo.php");
        } else {
            throw new Exception("Error al registar el activo fijo");
            
        }

    } catch (Exception $e){
        header("location: activo_fijo.php?menseje=error_registro");
        exit();

    }
}else{
    echo "acceso no permitido";


}
    mysqli_close($conn);
?>