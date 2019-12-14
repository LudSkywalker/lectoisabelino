<?php
session_start();

include_once 'modelos/ConstantesDeConexion.php';
include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';

//$seguridad = new BloqueDeSeguridad();
//$seguridad->seguridad("login.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <script language="javascript">
            window.location.href = "Controlador.php?ruta=inicio";
        </script>
    </head>
    <body>

    </body>
</html>