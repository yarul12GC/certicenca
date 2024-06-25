<?php
include('validarsesion.php');
function generarMatricula() {
    $anio_actual = date('Y');
    $conexion = new PDO("mysql:host=mx146;dbname=cencacom_certificados", "cencacom_usercenca", "Cencacomex2023*");

    // Generar matrícula única
    do {
        $matricula = $anio_actual . "CENC" . sprintf("%03d", rand(1, 999));
        $consulta = $conexion->prepare("SELECT COUNT(*) as total FROM usuarios WHERE Matricula = :matricula");
        $consulta->bindParam(':matricula', $matricula);
        $consulta->execute();
        $contador = $consulta->fetch(PDO::FETCH_ASSOC)['total'];
    } while ($contador > 0);

    return $matricula;
}

function generarFolioControl($conexion) {
    // Obtener el último ID insertado
    $consulta = $conexion->query("SELECT MAX(usuarioID) AS max_id FROM usuarios");
    $ultimo_id = $consulta->fetch(PDO::FETCH_ASSOC)['max_id'];

    // Incrementar el último ID para obtener un nuevo valor único
    $nuevo_id = $ultimo_id + 1;

    return date('Y') . $nuevo_id;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["Nombre"]) ? trim($_POST["Nombre"]) : "";
    $apellidoPaterno = isset($_POST["ApellidoPaterno"]) ? trim($_POST["ApellidoPaterno"]) : "";
    $apellidoMaterno = isset($_POST["ApellidoMaterno"]) ? trim($_POST["ApellidoMaterno"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : "";
    $tipoEstudioID = isset($_POST["TipoEstudioID"]) ? intval($_POST["TipoEstudioID"]) : 0;
    $programaID = isset($_POST["ProgramaID"]) ? intval($_POST["ProgramaID"]) : 0;
    $modalidadID = isset($_POST["ModalidadID"]) ? intval($_POST["ModalidadID"]) : 0;
    $estatus = isset($_POST["Estatus"]) ? trim($_POST["Estatus"]) : "";
    $tipoUsuarioID = isset($_POST["TipoUsuarioID"]) ? intval($_POST["TipoUsuarioID"]) : 0;

    if (empty($nombre) || empty($apellidoPaterno) || empty($apellidoMaterno) || empty($email) || empty($contrasena) || empty($tipoEstudioID) || empty($programaID) || empty($modalidadID) || empty($estatus) || empty($tipoUsuarioID)) {
        echo '<p class="text-danger">Por favor, completa todos los campos.</p>';
    } else {
        try {
            $conexion = new PDO("mysql:host=mx146;dbname=cencacom_certificados", "cencacom_usercenca", "Cencacomex2023*");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $consultaExistencia = $conexion->prepare("SELECT email FROM usuarios WHERE email = :email");
            $consultaExistencia->bindParam(':email', $email);
            $consultaExistencia->execute();

            if ($consultaExistencia->rowCount() > 0) {
                echo '<p class="text-danger">El usuario ya existe. Inténtalo con otro correo.</p>';
            } else {
                $matricula = generarMatricula();
                $folioControl = generarFolioControl($conexion);
                $hashedPassword = hash('sha512', $contrasena);
                $fechaRegistro = date('Y-m-d H:i:s'); // Obtenemos la fecha y hora actual

                $consultaInsertar = $conexion->prepare("INSERT INTO usuarios (Matricula, Nombre, ApellidoPaterno, ApellidoMaterno, email, contrasena, TipoEstudioID, ProgramaID, ModalidadID, FolioControl, Estatus, TipoUsuarioID, FechaRegistro) VALUES (:Matricula, :Nombre, :ApellidoPaterno, :ApellidoMaterno, :email, :contrasena, :TipoEstudioID, :ProgramaID, :ModalidadID, :FolioControl, :Estatus, :TipoUsuarioID, :FechaRegistro)");

                $consultaInsertar->bindParam(':Matricula', $matricula);
                $consultaInsertar->bindParam(':Nombre', $nombre);
                $consultaInsertar->bindParam(':ApellidoPaterno', $apellidoPaterno);
                $consultaInsertar->bindParam(':ApellidoMaterno', $apellidoMaterno);
                $consultaInsertar->bindParam(':email', $email);
                $consultaInsertar->bindParam(':contrasena', $hashedPassword);
                $consultaInsertar->bindParam(':TipoEstudioID', $tipoEstudioID);
                $consultaInsertar->bindParam(':ProgramaID', $programaID);
                $consultaInsertar->bindParam(':ModalidadID', $modalidadID);
                $consultaInsertar->bindParam(':FolioControl', $folioControl);
                $consultaInsertar->bindParam(':Estatus', $estatus);
                $consultaInsertar->bindParam(':TipoUsuarioID', $tipoUsuarioID);
                $consultaInsertar->bindParam(':FechaRegistro', $fechaRegistro);

                $consultaInsertar->execute();

                session_start();
                $_SESSION['registro_exitoso'] = true; 

                header("Location: usuarios.php");
                exit();
            }
            $conexion = null;
        } catch (PDOException $e) {
            echo "Error de conexión a la base de datos: " . $e->getMessage();
        }
    }
}
session_start();
if (isset($_SESSION['registro_exitoso']) && $_SESSION['registro_exitoso'] == true) {
    echo '<div class="alert alert-success" role="alert">
            Te has registrado exitosamente. Ahora puedes iniciar sesión con tu correo y contraseña.
          </div>';
    unset($_SESSION['registro_exitoso']); // Eliminamos la variable de sesión
}
?>
