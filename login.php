<?php
session_start();

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
    $mensaje = NULL;
}
?>

<!DOCTYPE html>
<html lang="es" href="qa.php-language-declarations.es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Funciones JavaScript propias del sistema -->
        <script type="text/javascript" src="javascript/funciones.js"></script>
        <!-- Funciones JavaScript propias del sistema -->
        <script type="text/javascript" src="javascript/md5.js"></script>     
        <title>LectoIsabelino</title>

        <!-- Favicons -->
        <link href="plantillas/Dashio/img/favicon.png" rel="icon">
        <link href="plantillas/Dashio/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Bootstrap core CSS -->
        <link href="plantillas/Dashio/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!--external css-->
        <link href="plantillas/Dashio/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet">

    </head>

    <body>

        <div class="container">
            <form class="form-login" role="form" method="POST" action="Controlador.php" name="formLogin"">
                <h2 class="form-login-heading">Ingresar</h2>
                <div class="login-wrap">
                    <input  id="InputCorreo" class="form-control" placeholder="Correo institucional" name="email" type="email" autofocus>
                    <br>
                    
                    <input id="InputPassword" class="form-control" placeholder="Contraseña" name="password" type="password" value="">
                    
                    
                    <input type="hidden" name="ruta" value="gestionDeAcceso">
                    <label class="checkbox">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="remember" type="checkbox" name="remember" value="false"> Recordarme en este equipo
                        <br>
                        <br>
                        <span class="pull-right">
                            <a data-toggle="modal" href="/../../login.php#myModal">¿Olvido su contraseña?</a>
                        </span>
                        <br>

                    </label>
<!--                    <input type="button" class="btn btn-theme btn-block" onclick="validar_logueo()" value="Ingresar">-->
                   <button class="btn btn-theme btn-block" onclick="validar_logueo()"><i class="fa fa-lock"></i> Ingresar</button> 


                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">¿Olvido su contraseña?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Ingrese el correo institucional para recuperar su contraseña</p>
                                    <input type="text" name="Email" placeholder="Correo institucional" autocomplete="off" class="form-control placeholder-no-fix">
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                                    <button class="btn btn-theme" type="button">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal -->
                </div>
            </form>
        </div>

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="plantillas/Dashio/lib/jquery/jquery.min.js"></script>
        <script src="plantillas/Dashio/lib/bootstrap/js/bootstrap.min.js"></script>
        <!--BACKSTRETCH-->
        <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
        <script type="text/javascript" src="plantillas/Dashio/lib/jquery.backstretch.min.js"></script>
        <script>
                    $.backstretch("plantillas/Dashio/img/login-bg.jpg", {
                        speed: 500
                    });
        </script>
    </body>

</html>
