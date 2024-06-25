<?php
include('conexion.php');

if(isset($_POST['ProgramaID'], $_POST['MaterialID']) && !empty($_POST['ProgramaID']) && !empty($_POST['MaterialID'])) {
    $programaID = $_POST['ProgramaID'];
    $materialID = $_POST['MaterialID'];

    // Verificar si el programa y el material existen
    $query_programa = "SELECT * FROM programasestudio WHERE ProgramaID = ?";
    $stmt_programa = $conexion->prepare($query_programa);
    $stmt_programa->bind_param("i", $programaID);
    $stmt_programa->execute();
    $result_programa = $stmt_programa->get_result();

    $query_material = "SELECT * FROM archivo_material WHERE ArchivoID = ?";
    $stmt_material = $conexion->prepare($query_material);
    $stmt_material->bind_param("i", $materialID);
    $stmt_material->execute();
    $result_material = $stmt_material->get_result();

    if($result_programa->num_rows > 0 && $result_material->num_rows > 0) {
        $archivoID = $_POST['MaterialID'];

        // Verificar si existen usuarios asociados al programa
        $query_usuarios = "SELECT UsuarioID FROM usuarios WHERE ProgramaID = ?";
        $stmt_usuarios = $conexion->prepare($query_usuarios);
        $stmt_usuarios->bind_param("i", $programaID);
        $stmt_usuarios->execute();
        $result_usuarios = $stmt_usuarios->get_result();

        if($result_usuarios->num_rows > 0) {
            // Asignar el material a todos los usuarios asociados al programa
            while($usuario = $result_usuarios->fetch_assoc()) {
                $usuarioID = $usuario['UsuarioID'];

                // Verificar si ya existe una asignación para este usuario, programa y material
                $query_verificar = "SELECT * FROM asignaciones_materiales WHERE ProgramaID = ? AND UsuarioID = ? AND MaterialID = ?";
                $stmt_verificar = $conexion->prepare($query_verificar);
                $stmt_verificar->bind_param("iii", $programaID, $usuarioID, $materialID);
                $stmt_verificar->execute();
                $result_verificar = $stmt_verificar->get_result();

                if($result_verificar->num_rows == 0) {
                    // Insertar la asignación del material en la tabla asignaciones_materiales
                    $query_insert = "INSERT INTO asignaciones_materiales (ProgramaID, UsuarioID, MaterialID) VALUES (?, ?, ?)";
                    $stmt_insert = $conexion->prepare($query_insert);
                    $stmt_insert->bind_param("iii", $programaID, $usuarioID, $archivoID);
                    $stmt_insert->execute();
                }
            }

            header("Location: materiales.php");
            exit();
        } else {
            echo "No se encontraron usuarios asociados al programa.";
        }
    } else {
        echo "El programa o el material especificado no existe.";
    }
} else {
    echo "Error: Datos insuficientes o incorrectos.";
}

// Cerramos la conexión
$conexion->close();
?>
