<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'your_secret_key';

$jwt = isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : null;

if (!$jwt) {
    echo '<script> 
            alert("Acceso denegado, no autenticado.");
            window.location = "../index.php";
          </script>';
    exit();
}

try {
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $userData = (array)$decoded->data;

    session_start();
    $_SESSION['usuarioID'] = $userData['id'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['tipoUsuarioID'] = $userData['tipoUsuarioID'];

    switch ($userData['tipoUsuarioID']) {
        case 1:
            header("Location: ../certicenca/admin/index.php");
            break;
        case 2:
            header("Location: ../certicenca/usuarioadm/index.php");
            break;
        case 3:
            header("Location: ../certicenca/cessit/home.php");
            break;
        case 4:
            $secondaryKey = 'secondary_secret_key'; 
            $secondaryPayload = array(
                "iss" => "http://localhost",
                "aud" => "http://localhost",
                "iat" => time(),
                "exp" => time() + 3600,
                "data" => array(
                    "id" => $userData['id'],
                    "email" => $userData['email'],
                    "tipoUsuarioID" => $userData['tipoUsuarioID']
                )
            );
            $secondaryJwt = JWT::encode($secondaryPayload, $secondaryKey, 'HS256');

            header("Location: http://localhost/pedimento/verificar.php?token=" . $secondaryJwt);
            break;
        default:
            echo '<script> 
                    alert("Tipo de usuario desconocido. Por favor, contacte al administrador.");
                    window.location = "../index.php";
                  </script>';
            break;
    }
} catch (Exception $e) {
    echo '<script> 
            alert("Acceso denegado, token inválido.");
            window.location = "../index.php";
          </script>';
}
?>
