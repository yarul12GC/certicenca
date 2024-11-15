<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Iniciar sesión
    session_start();

    // Sanitizar y validar el correo electrónico
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
                alert("Correo electrónico inválido.");
                window.location = "index.php";
              </script>';
        exit();
    }

    // Validar la contraseña
    $contrasena = $_POST['contrasena'];
    if (empty($contrasena)) {
        echo '<script>
                alert("Por favor, ingrese su contraseña.");
                window.location = "index.php";
              </script>';
        exit();
    }

    // Hashear la contraseña
    $contrasena = hash('sha512', $contrasena);

    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, "SELECT usuarioID, tipoUsuarioID FROM usuarios WHERE email = ? AND contrasena = ?");
    if ($stmt === false) {
        echo '<script>
                alert("Error en la consulta.");
                window.location = "index.php";
              </script>';
        exit();
    }

    // Enlazar los parámetros y ejecutar la consulta
    mysqli_stmt_bind_param($stmt, 'ss', $email, $contrasena);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Verificar si se encontró el usuario
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Vincular los resultados
        mysqli_stmt_bind_result($stmt, $usuarioID, $tipoUsuarioID);
        mysqli_stmt_fetch($stmt);

        // Guardar el ID del usuario y el email en la sesión
        $_SESSION['usuarioID'] = $usuarioID;
        $_SESSION['email'] = $email;

        // Redirigir según el tipo de usuario
        switch ($tipoUsuarioID) {
            case 1:
                header("Location: admin/index.php");
                break;
            case 2:
                header("Location: usuarioadm/index.php");
                break;
            case 3:
                header("Location: cessit/index.php");
                break;
            case 4:
                header("Location: pedimento-/user/panel.php");
                break;
            default:
                echo '<script> 
                        alert("Tipo de usuario desconocido. Por favor, contacte al administrador.");
                        window.location = "index.php";
                      </script>';
                break;
        }
        exit();
    } else {
        // Si el usuario no existe o la contraseña es incorrecta
        echo '<script>
                alert("El usuario no existe o las credenciales son incorrectas. Por favor, verifique los datos.");
                window.location = "index.php";
              </script>';
        exit();
    }
}
