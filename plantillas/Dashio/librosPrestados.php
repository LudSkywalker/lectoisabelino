<?php
session_start();

include_once '../../modelos/ConstantesDeConexion.php';
include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';


if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
}

if (isset($_SESSION['listaDeLibros'])) {
    $listaDeLibros = $_SESSION['listaDeLibros'];
}

if (isset($_SESSION['paginacionVinculos'])) {
    $paginacionVinculos = $_SESSION['paginacionVinculos'];
}
if (isset($_SESSION['totalRegistrosLibros'])) {
    $totalRegistrosLibros = $_SESSION['totalRegistrosLibros'];
}
if (isset($_SESSION['registroCategoriasLibros'])) { /* * ************************ */
    $registroCategoriasLibros = $_SESSION['registroCategoriasLibros'];
    $cantCategorias = count($registroCategoriasLibros);
}

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
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <title>LectoIsabelino</title>

        <!-- Favicons -->
        <link href="img/favicon.png" rel="icon">
        <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Bootstrap core CSS -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!--external css-->
        <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet">

        <!-- =======================================================
          Template Name: Dashio
          Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
          Author: TemplateMag.com
          License: https://templatemag.com/license/
        ======================================================= -->
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
                <a href="../../principal.php" class="logo"><b>LECTO<span>ISABELINO</span></b></a>
                <!--logo end-->
                <!--<div class="nav notify-row" id="top_menu">
                  
                  <ul class="nav top-menu">
                    
                    <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="../../principal.php#">
                        <i class="fa fa-tasks"></i>
                        <span class="badge bg-theme">4</span>
                        </a>
                      <ul class="dropdown-menu extended tasks-bar">
                        <div class="notify-arrow notify-arrow-green"></div>
                        <li>
                          <p class="green">You have 4 pending tasks</p>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <div class="task-info">
                              <div class="desc">Dashio Admin Panel</div>
                              <div class="percent">40%</div>
                            </div>
                            <div class="progress progress-striped">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                <span class="sr-only">40% Complete (success)</span>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <div class="task-info">
                              <div class="desc">Database Update</div>
                              <div class="percent">60%</div>
                            </div>
                            <div class="progress progress-striped">
                              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                <span class="sr-only">60% Complete (warning)</span>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <div class="task-info">
                              <div class="desc">Product Development</div>
                              <div class="percent">80%</div>
                            </div>
                            <div class="progress progress-striped">
                              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                <span class="sr-only">80% Complete</span>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <div class="task-info">
                              <div class="desc">Payments Sent</div>
                              <div class="percent">70%</div>
                            </div>
                            <div class="progress progress-striped">
                              <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                <span class="sr-only">70% Complete (Important)</span>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="external">
                          <a href="#">See All Tasks</a>
                        </li>
                      </ul>
                    </li>
                    
                    <li id="header_inbox_bar" class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="../../principal.php#">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-theme">5</span>
                        </a>
                      <ul class="dropdown-menu extended inbox">
                        <div class="notify-arrow notify-arrow-green"></div>
                        <li>
                          <p class="green">You have 5 new messages</p>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="photo"><img alt="avatar" src="img/ui-zac.jpg"></span>
                            <span class="subject">
                            <span class="from">Zac Snider</span>
                            <span class="time">Just now</span>
                            </span>
                            <span class="message">
                            Hi mate, how is everything?
                            </span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="photo"><img alt="avatar" src="img/ui-divya.jpg"></span>
                            <span class="subject">
                            <span class="from">Divya Manian</span>
                            <span class="time">40 mins.</span>
                            </span>
                            <span class="message">
                            Hi, I need your help with this.
                            </span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="photo"><img alt="avatar" src="img/ui-danro.jpg"></span>
                            <span class="subject">
                            <span class="from">Dan Rogers</span>
                            <span class="time">2 hrs.</span>
                            </span>
                            <span class="message">
                            Love your new Dashboard.
                            </span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="photo"><img alt="avatar" src="img/ui-sherman.jpg"></span>
                            <span class="subject">
                            <span class="from">Dj Sherman</span>
                            <span class="time">4 hrs.</span>
                            </span>
                            <span class="message">
                            Please, answer asap.
                            </span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">See all messages</a>
                        </li>
                      </ul>
                    </li>
                   
                    <li id="header_notification_bar" class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="../../principal.php#">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge bg-warning">7</span>
                        </a>
                      <ul class="dropdown-menu extended notification">
                        <div class="notify-arrow notify-arrow-yellow"></div>
                        <li>
                          <p class="yellow">You have 7 new notifications</p>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                            Server Overloaded.
                            <span class="small italic">4 mins.</span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="label label-warning"><i class="fa fa-bell"></i></span>
                            Memory #2 Not Responding.
                            <span class="small italic">30 mins.</span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                            Disk Space Reached 85%.
                            <span class="small italic">2 hrs.</span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">
                            <span class="label label-success"><i class="fa fa-plus"></i></span>
                            New User Registered.
                            <span class="small italic">3 hrs.</span>
                            </a>
                        </li>
                        <li>
                          <a href="../../principal.php#">See all notifications</a>
                        </li>
                      </ul>
                    </li>
                    
                  </ul>
                -->
                </div>
                <div class="top-menu">
                    <ul class="nav pull-right top-menu">
                        <li><a class="logout" href="../../Controlador.php?ruta=cerrarSesion" >Salir</a></li>
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
                        <p class="centered"><a href="profile.php"><img src="img/ui-sam.jpg" class="img-circle" width="80"></a></p>
                        <h5 class="centered">Sam Soffes</h5>
                        <li class="mt">
                            <a href="../../principal.php">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a class="active" href="javascript:;">
                                <i class="fa fa-cogs"></i>
                                <span>Gestión de Libros</span>
                            </a>
                            <ul class="sub">
                                <li class="active"><a href="../../Controlador.php?ruta=listarLibros&pag=0">Listar Libros</a></li>
                                <?php if (in_array(1, $_SESSION['rolesEnSesion'])) { ?>
                                    <li><a href="../../Controlador.php?ruta=mostrarInsertarLibros">Insertar Nuevo Libro</a></li>
                                    <?php }
                                ?>
                            </ul>
                        </li>     
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-desktop"></i>
                                <span>UI Elements</span>
                            </a>
                            <ul class="sub">
                                <li><a href="general.php">General</a></li>
                                <li ><a href="buttons.php">Buttons</a></li>
                                <li><a href="panels.php">Panels</a></li>
                                <li><a href="font_awesome.php">Font Awesome</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-cogs"></i>
                                <span>Components</span>
                            </a>
                            <ul class="sub">
                                <li><a href="grids.php">Grids</a></li>
                                <li><a href="calendar.php">Calendar</a></li>
                                <li><a href="gallery.php">Gallery</a></li>
                                <li><a href="todo_list.php">Todo List</a></li>
                                <li><a href="dropzone.php">Dropzone File Upload</a></li>
                                <li><a href="inline_editor.php">Inline Editor</a></li>
                                <li><a href="file_upload.php">Multiple File Upload</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Extra Pages</span>
                            </a>
                            <ul class="sub">
                                <li><a href="blank.php">Blank Page</a></li>
                                <li><a href="../../login.php">Login</a></li>
                                <li><a href="lock_screen.php">Lock Screen</a></li>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="invoice.php">Invoice</a></li>
                                <li><a href="pricing_table.php">Pricing Table</a></li>
                                <li><a href="faq.php">FAQ</a></li>
                                <li><a href="404.php">404 Error</a></li>
                                <li><a href="500.php">500 Error</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-tasks"></i>
                                <span>Forms</span>
                            </a>
                            <ul class="sub">
                                <li><a href="form_component.php">Form Components</a></li>
                                <li><a href="advanced_form_components.php">Advanced Components</a></li>
                                <li><a href="form_validation.php">Form Validation</a></li>
                                <li><a href="contactform.php">Contact Form</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-th"></i>
                                <span>Data Tables</span>
                            </a>
                            <ul class="sub">
                                <li><a href="basic_table.php">Basic Table</a></li>
                                <li><a href="responsive_table.php">Responsive Table</a></li>
                                <li><a href="advanced_table.php">Advanced Table</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="inbox.php">
                                <i class="fa fa-envelope"></i>
                                <span>Mail </span>
                                <span class="label label-theme pull-right mail-info">2</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class=" fa fa-bar-chart-o"></i>
                                <span>Charts</span>
                            </a>
                            <ul class="sub">
                                <li><a href="morris.php">Morris</a></li>
                                <li><a href="chartjs.php">Chartjs</a></li>
                                <li><a href="flot_chart.php">Flot Charts</a></li>
                                <li><a href="xchart.php">xChart</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-comments-o"></i>
                                <span>Chat Room</span>
                            </a>
                            <ul class="sub">
                                <li><a href="lobby.php">Lobby</a></li>
                                <li><a href="chat_room.php"> Chat Room</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="google_maps.php">
                                <i class="fa fa-map-marker"></i>
                                <span>Google Maps </span>
                            </a>
                        </li>
                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->
            <!-- **********************************************************************************************************************************************************
                MAIN CONTENT
                *********************************************************************************************************************************************************** -->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                    <h3><i class="fa fa-angle-right"></i>Libros Prestados</h3>



                        <p class="drop-after">Total de Registros: <?php if (isset($totalRegistrosLibros)) echo $totalRegistrosLibros; ?></p>
                        <table border='1' class="display table table-bordered">
                            <thead>
                                <tr>
                                    <td class="hidden-phone" style="text-align: center">ISBN</td>
                                    <td class="hidden-phone" style="text-align: center">TITULO</td>
                                    <td class="hidden-phone" style="text-align: center">AUTOR</td>
                                    <td class="hidden-phone" style="text-align: center">PRECIO</td>
                                    <td class="hidden-phone" style="text-align: center">ID CATEGORIA</td>
                                    <td class="hidden-phone" style="text-align: center">NOMBRE CATEGORIA</td>
                                    <td class="hidden-phone" style="text-align: center" colspan="2"> ACCIONES </td>
                                </tr>
                            </thead> 
<?php
$i = 0;
foreach ($listaDeLibros as $key => $value) {
    ?>
                                <tr>
                                    <td class="hidden-phone" style="text-align: center"><?php echo $listaDeLibros[$i]->isbn; ?></td>
                                    <td class="hidden-phone" style="text-align: center"><?php echo strtoupper($listaDeLibros[$i]->titulo); ?></td>
                                    <td class="hidden-phone" style="text-align: center"><?php echo strtoupper($listaDeLibros[$i]->autor); ?></td>
                                    <td class="hidden-phone" style="text-align: center"><?php echo strtoupper($listaDeLibros[$i]->precio); ?></td>
                                    <td class="hidden-phone" style="text-align: center"><?php echo $listaDeLibros[$i]->catLibId; ?></td>
                                    <td class="hidden-phone" style="text-align: center"><?php echo $listaDeLibros[$i]->catLibNombre; ?></td>
                                    <td class="hidden-phone" style="text-align: center"><?php if (in_array(1, $_SESSION['rolesEnSesion'])) { ?><a href="../../Controlador.php?ruta=actualizarLibro&idAct=<?php echo $listaDeLibros[$i]->isbn; ?>" >Devolucion</a><?php }
                                    ?></td>

                                        <?php
                                        $i++;
                                        ?>
                                <tr>
                                        <?php
                                    }
                                    ?>
                        </table>
                        <!--<nav aria-label="Page navigation example">-->
                                    <?php $i = 0; ?>
                        <table>

                            <tr>
                                    <td>
                                        <div class="btn-group btn-group-justified"style="color: white">
                                    <?php foreach ($paginacionVinculos as $key => $value) { ?>    
                                            <div class="btn-group"style="color: white">
                                                <button class="btn btn-theme" style="color: white"><a style="color: white"class="page-link" href="<?php echo $value; ?>"><?php echo ($key); ?>
                                                    </a></button>
                                            </div>
                                    <?php }
                                ?>
                                        </div>
                                </td>
                            </tr>
                        </table>

                        <!--</nav>-->
                        <fieldset class="scheduler-border"><legend class="scheduler-border">FILTRO</legend>

                            <form name="formBuscarLibros" action="../../Controlador.php" method="POST">
                    <div class="row mt">
                    <div class="col-lg-6 col-md-2 col-sm-2">
                    <div class="showback">
                                <input type="hidden" name="ruta" value="listarLibros"/>
                                <table> 
                                    <tr><td>ISBN:</td>
                                        <td><input type="number" name="isbn" onclick="" value="<?php
                                                                              if (isset($_SESSION['isbnF'])) {
                                                                                  echo $_SESSION['isbnF'];
                                                                              }
                                                                              ?>"/>
                                        </td>                      
                                    </tr> 
                                    <tr><td>TITULO:</td>
                                        <td><input type="text" name="titulo" onclick="" value="<?php
                                                                              if (isset($_SESSION['tituloF'])) {
                                                                                  echo $_SESSION['tituloF'];
                                                                              }
                                                                              ?>"/>
                                        </td>                       
                                    </tr> 
                                    <tr><td>AUTOR:</td>
                                        <td><input type="text" onclick="" name="autor" value="<?php
                                                                              if (isset($_SESSION['autorF'])) {
                                                                                  echo $_SESSION['autorF'];
                                                                              }
                                                                              ?>"/>
                                        </td>
                                        <td>                         
                                    </tr> 
                                    <tr><td>PRECIO:</td>
                                        <td><input type="number" onclick=""  name="precio" value="<?php
                                                                              if (isset($_SESSION['precioF'])) {
                                                                                  echo $_SESSION['precioF'];
                                                                              }
                                                                              ?>"/>
                                        </td>                          
                                    </tr>                   
                                    <tr><td>CATEGORIA </td>
                                        <td>
                                            <select id="categoriaLibro_catLibId" name="categoriaLibro_catLibId">
                                                <option value = "">Seleccionar</option>
<?php
for ($j = 0; $j < $cantCategorias; $j++) {
    ?>
                                                    <option value = "<?php echo $registroCategoriasLibros[$j]->catLibId; ?>" <?php
                                                if (isset($_SESSION['categoriaLibro_catLibIdF']) && $_SESSION['categoriaLibro_catLibIdF'] == $registroCategoriasLibros[$j]->catLibId) {
                                                    echo " selected";
                                                }
                                                ?> > <?php echo $registroCategoriasLibros[$j]->catLibId . " - " . $registroCategoriasLibros[$j]->catLibNombre; ?></option>             
    <?php
}
?>
                                            </select> 
                                        </td>
                                        <td></td>                          
                                    </tr>
                                </table>
                                            <div class="btn-group">
                                <input type="submit" class=" btn-theme" value="Filtrar" name="enviar" title="Si es necesario limpie 'Buscar'"/>
                                 <input type="reset"  class="btn-theme" value="limpiar" onclick="
                            javascript:document.formBuscarLibros.isbn.value = '';
                            javascript:document.formBuscarLibros.titulo.value = '';
                            javascript:document.formBuscarLibros.autor.value = '';
                            javascript:document.formBuscarLibros.precio.value = '';
                            javascript:document.formBuscarLibros.categoriaLibro_catLibId.value = '';
                            javascript:document.formBuscarLibros.buscar.value = '';
                            javascript:document.formBuscarLibros.submit();"/>
                                            </div>
                              
                    </div>
                                
                                <fieldset class="scheduler-border"><legend class="scheduler-border">BUSCAR</legend>
                                    <div class="showback">
                                        <!--BOTÓN PARA BUSCAR*************************-->
                                        <input type="text" name="buscar" placeholder="Término a Buscar" value="<?php
                                                if (isset($_SESSION['buscarF'])) {
                                                    echo $_SESSION['buscarF'];
                                                }
                                                ?>">
                                    </div>
                                </fieldset>             
                                    </div>        
                    </div>
                            </form>
                        </fieldset>
                    
                    <!--/ row -->
                </section>
                <!-- /wrapper -->
            </section>
            <!-- /MAIN CONTENT -->
            <!--main content end-->
            <!--footer start-->
            <footer class="site-footer">
                <div class="text-center">
                    <p>
                        &copy; Copyrights <strong>Dashio</strong>. All Rights Reserved
                    </p>
                    <div class="credits">
                        <!--
                          You are NOT allowed to delete the credit link to TemplateMag with free version.
                          You can delete the credit link only if you bought the pro version.
                          Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/
                          Licensing information: https://templatemag.com/license/
                        -->
                        Created with Dashio template by <a href="https://templatemag.com/">TemplateMag</a>
                    </div>
                    <a href="buttons.php#" class="go-top">
                        <i class="fa fa-angle-up"></i>
                    </a>
                </div>
            </footer>
            <!--footer end-->
        </section>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="lib/jquery/jquery.min.js"></script>

        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
        <script src="lib/jquery.scrollTo.min.js"></script>
        <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
        <!--common script for all pages-->
        <script src="lib/common-scripts.js"></script>
    </body>

</html>
