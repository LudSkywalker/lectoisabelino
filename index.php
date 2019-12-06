<?php
session_start();

include_once 'modelos/ConstantesDeConexion.php';
include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';

$seguridad = new BloqueDeSeguridad();
$seguridad->seguridad("login.php");

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
    $mensaje = NULL;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <script language="javascript">
            window.location.href = "principal.php";
        </script>
    </head>
    <body>

    </body>
</html>