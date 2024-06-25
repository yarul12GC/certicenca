<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

include('conexion.php');

$key = 'your_secret_key'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];
    $contrasena = hash('sha512', $contrasena);

    $stmt = mysqli_prepare($conexion, "SELECT * FROM usuarios WHERE email = ? AND contrasena = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $email, $contrasena);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $usuarioID, $matricula, $nombre, $apellidoPaterno, $apellidoMaterno, $email, $contrasena, $tipoEstudioID, $programaID, $modalidadID, $folioControl, $estatus, $tipoUsuarioID, $fechaRegistro);
        mysqli_stmt_fetch($stmt);

        $payload = array(
            "iss" => "http://localhost",                                // Emisor del token (puede ser tu dominio)
            "aud" => "http://localhost",                                // Audiencia del token (puede ser tu dominio)
            "iat" => time(), 
            "nbf" => time(), 
            "exp" => time() + 3600, 
            "data" => array(
                "id" => $usuarioID,
                "email" => $email,
                "tipoUsuarioID" => $tipoUsuarioID
            )
        );

        try {
            $jwt = JWT::encode($payload, $key, 'HS256');

            setcookie('jwt', $jwt, [
                'expires' => time() + 3600,
                'path' => '/',
                'domain' => 'localhost',
                'secure' => false, 
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            $_SESSION['email'] = $email;
            $_SESSION['jwt'] = $jwt;

            header("Location: verificar.php");
            exit();
        } catch (Exception $e) {
            echo '<script> 
                    alert("Error al generar el token JWT: ' . $e->getMessage() . '");
                    window.location = "index.php";
                  </script>';
            exit();
        }
    } else {
        echo '<script> 
                alert("El usuario no existe o las credenciales son incorrectas. Por favor, verifique los datos.");
                window.location = "index.php";
              </script>';
        exit();
    }
}
?>
