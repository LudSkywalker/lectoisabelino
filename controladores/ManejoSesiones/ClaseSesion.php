<?php
class ClaseSesion {

    function crearSesion($usuario_s) {

        $_SESSION['autenticado'] = "1";

        $estado_session = session_status();
        if ($estado_session == PHP_SESSION_DISABLED) {
                    }

        list($datosUsuario, $rolesUsuario, $rolesEnSesion,$remember) = $usuario_s;
        $_SESSION['remember'] = $remember;
        $_SESSION['datosUsuario'] = $datosUsuario;
        $_SESSION['rolesUsuario'] = $rolesUsuario;
        $_SESSION['rolesEnSesion'] = $rolesEnSesion;
    }

    function cerrarSesion($login) {
                session_destroy();
        header("Location: ".$login);
    }

}
?>

