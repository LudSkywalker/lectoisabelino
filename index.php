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
            window.location.href = "principal.php";
        </script>
    </head>
    <body>

    </body>
</html>