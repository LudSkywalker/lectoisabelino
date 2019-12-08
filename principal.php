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
        <link rel="stylesheet" type="text/css" href="plantillas/Dashio/css/zabuto_calendar.css">
        <link rel="stylesheet" type="text/css" href="plantillas/Dashio/lib/gritter/css/jquery.gritter.css" />
        <!-- Custom styles for this template -->
        <link href="plantillas/Dashio/css/style.css" rel="stylesheet">
        <link href="plantillas/Dashio/css/style-responsive.css" rel="stylesheet">
        <script src="plantillas/Dashio/lib/chart-master/Chart.js"></script>

        
        
        
    </head>

    <body>
        <section id="container">
            <!-- **********************************************************************************************************************************************************
                TOP BAR CONTENT & NOTIFICATIONS
                *********************************************************************************************************************************************************** -->
            <!--header start-->
            <header class="header black-bg">
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                </div>
                <!--logo start-->
                <a href="principal.php" class="logo"><b>LECTO<span>ISABELINO</span></b></a>

                <div class="top-menu">
                    <ul class="nav pull-right top-menu">
                        <li><a class="logout" href="Controlador.php?ruta=cerrarSesion">Salir</a></li>
                    </ul>
                </div>
            </header>
            <!--header end-->
            <!-- **********************************************************************************************************************************************************
                MAIN SIDEBAR MENU
                *********************************************************************************************************************************************************** -->
            <!--sidebar start-->
            <aside>
                <div id="sidebar" class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <p class="centered"><a href="profile.php"><img src="https://s3.amazonaws.com/s3.timetoast.com/public/uploads/photos/12328712/CPSIH.jpg" class="img-circle" width="80"></a></p>
                        <h5 class="centered">  Colegio Parroquial Santa <br> Isabel de Hungria  </h5>

                        
                        <li class="mt">
                            <a  <?php
                            if (!isset($_GET["contenido"])){
                                echo 'class="active"';
                            }
                            ?> href="principal.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                                <?php
 if ((in_array(1, $_SESSION['rolesEnSesion']))||(in_array(2, $_SESSION['rolesEnSesion']))||(in_array(3, $_SESSION['rolesEnSesion']))) {
     ?>
  
                        <li class="sub-menu">
                            <a <?php
                            if ((isset($_GET["contenido"]))&&(($_GET["contenido"]=="plantillas/Dashio/todosLosLibros.php"))){
                                echo 'class="active"';
                            }
                            ?> href="javascript:;">
                                <i class="fa fa-cogs"></i>
                                <span>Miembro </span>
                            </a>
                            <ul class="sub">
                                <li <?php
                            if ((isset($_GET["contenido"]))&&(($_GET["contenido"]=="plantillas/Dashio/todosLosLibros.php"))){
                                echo 'class="active"';
                            }
                            ?>><a  href="Controlador.php?ruta=verInventarioLibros&pag=0&#cont">Ver Libros </a></li>

                            </ul>
                        </li>  
                        <?php
     }
?>

                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->
            <!-- **********************************************************************************************************************************************************
                MAIN CONTENT
                *********************************************************************************************************************************************************** -->
          

                            <section id="cont">
                            <br/>
                            <?php
                            if (isset($_GET["contenido"])){
                                include_once($_GET["contenido"]);
                            }
                            ?>

                        

        </section>
        <script src="plantillas/Dashio/lib/jquery/jquery.min.js"></script>

        <script src="plantillas/Dashio/lib/bootstrap/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="plantillas/Dashio/lib/jquery.dcjqaccordion.2.7.js"></script>
        <script src="plantillas/Dashio/lib/jquery.scrollTo.min.js"></script>
        <script src="plantillas/Dashio/lib/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="plantillas/Dashio/lib/jquery.sparkline.js"></script>
        <!--common script for all pages-->
        <script src="plantillas/Dashio/lib/common-scripts.js"></script>
        <script type="text/javascript" src="plantillas/Dashio/lib/gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="plantillas/Dashio/lib/gritter-conf.js"></script>
        <!--script for this page-->
        <script src="plantillas/Dashio/lib/sparkline-chart.js"></script>
        <script src="plantillas/Dashio/lib/zabuto_calendar.js"></script>
                                   
        <script type="application/javascript">
            $(document).ready(function() {
            $("#date-popover").popover({
           .php: true,
            trigger: "manual"
            });
            $("#date-popover").hide();
            $("#date-popover").click(function(e) {
            $(this).hide();
            });

            $("#my-calendar").zabuto_calendar({
            action: function() {
            return myDateFunction(this.id, false);
            },
            action_nav: function() {
            return myNavFunction(this.id);
            },
            ajax: {
            url: "show_data.php?action=1",
            modal: true
            },
            legend: [{
            type: "text",
            label: "Special event",
            badge: "00"
            },
            {
            type: "block",
            label: "Regular event",
            }
            ]
            });
            });

            function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
            }
        </script>
    </body>

</html>
