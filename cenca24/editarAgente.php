<?php
include 'startSession.php';
require 'conexion.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $AgenteAduanalID = $_POST['AgenteAduanalID'];
    $TipoAgente = $_POST["TipoAgente"];
    $NumPatenteAutorizacion = $_POST["NumPatenteAutorizacion"];
    $NombreAgenteAduanal = $_POST["NombreAgenteAduanal"];
    $ApellidoPaterno = $_POST["ApellidoPaterno"];
    $ApellidoMaterno = $_POST["ApellidoMaterno"];
    $RFC = $_POST["RFC"];
    $CURP = $_POST["CURP"];
    $ContribuyenteID = $_POST["ContribuyenteID"];
    $RazonSocial = $_POST["RazonSocial"];
    $Calle = $_POST["Calle"];
    $Numero = $_POST["Numero"];
    $CodigoPostal = $_POST["CodigoPostal"];
    $Colonia = $_POST["Colonia"];
    $EntidadFederativa = $_POST["EntidadFederativa"];
    $Pais = $_POST["Pais"];

    try {
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE agentesAduanales SET
            TipoAgente = '$TipoAgente',
            NumPatenteAutorizacion = '$NumPatenteAutorizacion',
            NombreAgenteAduanal = '$NombreAgenteAduanal',
            ApellidoPaterno = '$ApellidoPaterno',
            ApellidoMaterno = '$ApellidoMaterno',
            RFC = '$RFC',
            CURP = '$CURP',
            ContribuyenteID = '$ContribuyenteID',
            RazonSocial = '$RazonSocial',
            Calle = '$Calle',
            Numero = '$Numero',
            CodigoPostal = '$CodigoPostal',
            Colonia = '$Colonia',
            EntidadFederativa = '$EntidadFederativa',
            Pais = '$Pais'
            WHERE AgenteAduanalID = $AgenteAduanalID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: agentes.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: agentes.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}
