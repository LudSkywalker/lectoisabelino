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
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>LectoIsabelino</title>

  <!-- Favicons -->
  <link href="plantillas/Dashio/img/favicon.png" rel="icon">
  <link href="plantillas/Dashio/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="plantillas/Dashio/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="plantillas/Dashio/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="plantillas/Dashio/css/style.css" rel="stylesheet">
  <link href="plantillas/Dashio/css/style-responsive.css" rel="stylesheet">
  

</head>

<body onload="getTime(),pantallaBloqueo()">
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div class="container">
    <div id="showtime"></div>
    <div class="col-lg-4 col-lg-offset-4">
      <div class="lock-screen">
      <h2> <a  href="principal.php"><i class="fa fa-lock"></i></a></h2>
        <p style="color: white">VOLVER</p>
        <!-- Modal -->

        <!-- modal -->
      </div>
      <!-- /lock-screen -->
    </div>
    <!-- /col-lg-4 -->
  </div>
  <!-- /container -->
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
  <script>
    function getTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      // add a zero in front of numbers<10
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('showtime').innerHTML = h + ":" + m + ":" + s;
      t = setTimeout(function() {
        getTime()
      }, 500);
    }

    function checkTime(i) {
      if (i < 10) {
        i = "0" + i;
      }
      return i;
    }
    function pantallaBloqueo() {
    enviara = setInterval(enviar, 900000);
    }
    function enviar() {
window.location.href = "Controlador.php?ruta=cerrarSesion";
         }
    
  </script>
</body>

</html>
