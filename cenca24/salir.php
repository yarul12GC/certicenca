<?php
session_start();

$_SESSION['mensaje'] = '¡Has cerrado sesión exitosamente!';

session_destroy();

header('Location:https://certicenca.cencacomex.com.mx/index.php');
?>
