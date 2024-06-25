<?php
include('conexion.php');
include('validarsesion.php');

// Verificar si se ha enviado el formulario de actualización
if (isset($_POST["update"])) {
    // Validar los datos recibidos del formulario
    $idusuario = mysqli_real_escape_string($conexion, $_POST["UsuarioID"]);
    $matricula = mysqli_real_escape_string($conexion, isset($_POST["Matricula"]) ? $_POST["Matricula"] : "");
    $nombre = mysqli_real_escape_string($conexion, isset($_POST["Nombre"]) ? $_POST["Nombre"] : "");
    $apellidoPaterno = mysqli_real_escape_string($conexion, isset($_POST["ApellidoPaterno"]) ? $_POST["ApellidoPaterno"] : "");
    $apellidoMaterno = mysqli_real_escape_string($conexion, isset($_POST["ApellidoMaterno"]) ? $_POST["ApellidoMaterno"] : "");
    $email = mysqli_real_escape_string($conexion, isset($_POST["email"]) ? $_POST["email"] : "");
    $nueva_contrasena = isset($_POST["nueva_contrasena"]) ? $_POST["nueva_contrasena"] : ""; // Nueva contraseña
    $tipoEstudioID = mysqli_real_escape_string($conexion, isset($_POST["TipoEstudioID"]) ? $_POST["TipoEstudioID"] : "");
    $programaID = mysqli_real_escape_string($conexion, isset($_POST["ProgramaID"]) ? $_POST["ProgramaID"] : "");
    $modalidadID = mysqli_real_escape_string($conexion, isset($_POST["ModalidadID"]) ? $_POST["ModalidadID"] : "");
    $folioControl = mysqli_real_escape_string($conexion, isset($_POST["FolioControl"]) ? $_POST["FolioControl"] : "");
    $estatus = mysqli_real_escape_string($conexion, isset($_POST["Estatus"]) ? $_POST["Estatus"] : "");
    $tipoUsuarioID = mysqli_real_escape_string($conexion, isset($_POST["TipoUsuarioID"]) ? $_POST["TipoUsuarioID"] : "");

    // Verificar si se ha proporcionado una nueva contraseña
    if (!empty($nueva_contrasena)) {
        // Encriptar la nueva contraseña
        $contrasena_encriptada = hash('sha512', $nueva_contrasena);
        $contrasena_query = ", contrasena = '$contrasena_encriptada'";
    } else {
        // Si no se proporciona una nueva contraseña, mantener la contraseña existente
        $contrasena_query = "";
    }

    // Query de actualización con los datos validados
    $queryUpdate = "UPDATE usuarios SET Matricula = '$matricula', Nombre = '$nombre', ApellidoPaterno = '$apellidoPaterno', 
                    ApellidoMaterno = '$apellidoMaterno', email = '$email' $contrasena_query, TipoEstudioID = '$tipoEstudioID', 
                    ProgramaID = '$programaID', ModalidadID = '$modalidadID', FolioControl = '$folioControl', 
                    Estatus = '$estatus', TipoUsuarioID = '$tipoUsuarioID' WHERE UsuarioID = '$idusuario'";

    if (mysqli_query($conexion, $queryUpdate)) {
        // Actualización exitosa, redirigir al usuario
        header("Location: usuarios.php");
        exit;
    } else {
        // Error en la actualización
        $error_message = "Error al actualizar el usuario: " . mysqli_error($conexion);
        // Manejar el error aquí, como redirigir a una página de error o registrar el error en un archivo de registro
    }
} else {
    // Redirigir si no se envió el formulario de actualización
    header("Location: usuarios.php");
    exit;
}
?>
