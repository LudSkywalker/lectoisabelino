<?php

include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';
require_once PATH . 'modelos/modeloCategoriaLibrosLecto/CategoriaLibrosLectoDAO.php';
require_once PATH . 'modelos/modeloLibrosLecto/LibrosLectoDAO.php';


class LibrosLectoControlador{

    private $datos = array();

    public function __construct($datos) { //Lo primero que haga es llamar la funcion librosLectoControlador.
        $this->datos = $datos;
        $this->librosLectoControlador();
    }

    public function librosLectoControlador() {
        switch ($this->datos["ruta"]) {
            case "verInventarioLibros":
                                // PARA LA PAGINACIÒN SE VERIFICA Y VALIDA QUE EL LIMIT Y EL OFFSET ESTÈN EN LOS RANGOS QUE CORRESPONDAN//
                $limit = (isset($_GET['limit'])) ? $_GET['limit'] : 4;
                $offset = (isset($_GET['pag'])) ? $_GET['pag'] : 0;
                $offset = ($offset < 0 || !isset($_GET['pag'])) ? 0 : $_GET['pag'];

                // SE REALIZA LA CONSERVACIÓN Y CONSTRUCCIÒN DE FILTROS O BUSQUEDA DE LA CONSULTA
                $filtarBuscar = "";
                $this->conservarFiltroYBuscar();

                $filtrarBuscar = $this->armarFiltradoYBusqueda();

                // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
                $gestarLibros = new LibrosLectoDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $resultadoConsultaPaginada = $gestarLibros->consultaPaginada($limit, $offset, $filtrarBuscar);

                $totalRegistrosLibros = $resultadoConsultaPaginada[0];
                $listaDeLibros = $resultadoConsultaPaginada[1];
                $paginasExtra = $totalRegistrosLibros%4;
                //SE CONSTRUYEN LOS ENLACES PARA LA PAGINACIÓN QUE SE MOSTRARÀ EN LA VISTA//
                $totalEnlacesPaginacion = (isset($_GET['limit'])) ? $_GET['limit'] : $paginasExtra;
                $paginacionVinculos = $this->enlacesPaginacion($totalRegistrosLibros, $limit, $offset, $totalEnlacesPaginacion); //Se obtienen los enlaces de paginación
                //SE ALISTA LA CONSULTA DE CATEGORIAS DE LIBROS PARA FUTURO FORMULARIO DE FILTRAR//
                $gestarCategoriasLibros = new CategoriaLibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroCategoriasLibros = $gestarCategoriasLibros->seleccionarTodos();

                //SE SUBEN A SESION LOS DATOS NECESARIOS PARA QUE LA VISTA LOS IMPRIMA O UTILICE//
                $_SESSION['listaDeLibros'] = $listaDeLibros;
                $_SESSION['paginacionVinculos'] = $paginacionVinculos;
                $_SESSION['totalRegistrosLibros'] = $totalRegistrosLibros;
                $_SESSION['registroCategoriasLibros'] = $registroCategoriasLibros;
                $gestarLibros = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarCategoriasLibros = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                header("location:plantillas/Dashio/listarRegistrosLibros.php");
//                header("location:vistas/vistasLibros/listarRegistrosLibros.php");
                break;
            case "gestionDeAcceso":

                $gestarLibrosLecto  = new UsuariosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);

                $this->datos["password"] = md5($this->datos["password"]); //Encriptamos password para que coincida con la base de datos
                $this->datos["documento"] = ""; //Para logueo crear ésta variable límpia por cuanto se utiliza el mismo método de registrarse a continuación
                $existeUsuario_s = $gestarLibrosLecto ->seleccionarId(array($this->datos["documento"], $this->datos['email'], $this->datos["password"])); //Se revisa si existe la persona en la base                
                if ((0 != $existeUsuario_s['exitoSeleccionId']) && ($existeUsuario_s['registroEncontrado'][0]->usuLogin == $this->datos['email'])) {
                     //se abre sesión para almacenar en ella el mensaje de inserción
                    $_SESSION['mensaje'] = "Bienvenido a nuestra Aplicación."; //mensaje de inserción
                    //Consultamos los roles de la persona logueada
                    $consultaRoles = new RolDAO(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                    $rolesUsuario = $consultaRoles->seleccionarRolPorPersona(array($existeUsuario_s['registroEncontrado'][0]->perDocumento));
                    $cantidadRoles = count($rolesUsuario['registroEncontrado']);
                    $rolesEnSesion = array();
                    for ($i = 0; $i < $cantidadRoles; $i++) {
                        $rolesEnSesion[] = $rolesUsuario['registroEncontrado'][$i]->rolId;
                    }
                    //ABRIR SESION ******************************************
                    $sesionPermitida = new ClaseSesion(); //Se abre sesiòn
                    $sesionPermitida->crearSesion(array($existeUsuario_s['registroEncontrado'][0], $rolesUsuario, $rolesEnSesion)); //Se envìa a la sesiòn los datos del usuario logeado
                    header("location:principal.php");
                } else {
                     //se abre sesión para almacenar en ella el mensaje de inserción
                    $_SESSION['mensaje'] = "Credenciales de acceso incorrectas"; //mensaje de inserción
                    header("location:login.php");
                }

                break;
            case "cerrarSesion":
                $cerrarSesion = new ClaseSesion();
                $cerrarSesion->cerrarSesion(); //Se cierra sesión

                break;
        }
    }
  public function enlacesPaginacion($totalRegistros = NULL, $limit = 4, $offset = 0, $totalEnlacesPaginacion = 2) {

        $ruta = "listarLibros";

        if (isset($offset) && (int) $offset <= 0) {
            $offset = 0;
        }
        if (isset($offset) && ((int) $offset > ($totalRegistros - $limit))) {
            $offset = ($totalRegistros - $limit) + 1;
        }
        $anterior = $offset - $totalEnlacesPaginacion; /*         * **** */
        $siguiente = $offset + $totalEnlacesPaginacion; /*         * **** */

        $mostrar = array();
        $enlacesProvisional = array();
        $conteoEnlaces = 0;

        $mostrar['inicio'] = "Controlador.php?ruta=" . $ruta . "&pag=0"; //Enlace a enviar para páginas Iniciales
        $mostrar['anterior'] = "Controlador.php?ruta=" . $ruta . "&pag=" . (($anterior)); //Enlace a enviar para páginas anteriores

        for ($i = $offset; $i < ($offset + $limit) && $i < $totalRegistros && $conteoEnlaces < $totalEnlacesPaginacion; $i++) {

            $mostrar[$i + 1] = "Controlador.php?ruta=" . $ruta . "&pag=$i";
            $enlacesProvisional[$i] = "Controlador.php?ruta=" . $ruta . "&pag=$i";
            $conteoEnlaces++;
            $siguiente = $i;
        }

        $cantidadProvisional = count($enlacesProvisional);

        if ($offset < $totalRegistros) {
            $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente + 1);
//            $mostrar.="<a href='controladores/ControladorPrincipal.php?ruta=listarLibros&pag=" . ($totalPag - $totalEnlacesPaginacion) . "'>..::BLOQUE FINAL::..</a><br></center>";
            $mostrar ['final'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros - $totalEnlacesPaginacion);
        }

        if ($offset >= $totalRegistros) {
            $mostrar[$siguiente + 1] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente + 1);
            for ($j = 0; $j < $cantidadProvisional; $j++) {
                $mostrar [] = $enlacesProvisional[$j];
            }
            $mostrar [$totalRegistros - $offset] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros - $offset);
        }

        return $mostrar;
    }

    public function armarFiltradoYBusqueda() {

        $planConsulta = "";

        if (!empty($_SESSION['libLecCodF'])) {
            $planConsulta .= " where ll.libLecCodigo ='" . $_SESSION['libLecCodF'] . "'";
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta        
        } else {
            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta            
            if (!empty($_SESSION['libLecTituloF'])) {
                $where = true; // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . "ll.libLecTitulo like upper('%" . $_SESSION['libLecTituloF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['libLecAutorF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ll.libLecAutor like upper('%" . $_SESSION['libLecAutorF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['categoria_libro_lecto_catLecIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ll.categoria_libro_lecto_catLecId like ('%" . $_SESSION['categoria_libro_lecto_catLecIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['catLecNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " cll.catLecNombre like upper('%" . $_SESSION['catLecNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            
            if (!empty($_SESSION['estado_libros_estLibIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ll.estado_libros_estLibId like ('%" . $_SESSION['estado_libros_estLibIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['estLibNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.estLibNombre like upper('%" . $_SESSION['estLibNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
        }
        if (!empty($_SESSION['buscarF'])) {
            $where = TRUE;
            $condicionBuscar = (($where && !$filtros == 0) ? " or " : " where ");
            $filtros++;
            $planConsulta .= $condicionBuscar;
            $planConsulta .= "( ll.libLecCodigo like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or ll.libLecTitulo like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or ll.libLecAutor like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or cll.catLecId like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or cll.catLecNombre like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or el.estLibId like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or el.estLibNombre like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " ) ";
        }
        return $planConsulta;
    }

    public function conservarFiltroYBuscar() {
//        se almacenan en sesion las variables del filtro y buscar para conservarlas en el formulario
        $_SESSION['libLecIdF'] = (isset($_POST['libLecId']) && !isset($_SESSION['libLecIdF'])) ? $_POST['libLecId'] : $_SESSION['libLecIdF'];
        $_SESSION['libLecIdF'] = (!isset($_POST['libLecId']) && isset($_SESSION['libLecIdF'])) ? $_SESSION['libLecIdF'] : $_POST['libLecId'];
        
        $_SESSION['libLecCodF'] = (isset($_POST['libLecCod']) && !isset($_SESSION['libLecCodF'])) ? $_POST['libLecCod'] : $_SESSION['libLecCodF'];
        $_SESSION['libLecCodF'] = (!isset($_POST['libLecCod']) && isset($_SESSION['libLecCodF'])) ? $_SESSION['libLecCodF'] : $_POST['libLecCod'];

        $_SESSION['libLecTituloF'] = (isset($_POST['libLecTitulo']) && !isset($_SESSION['libLecTituloF'])) ? $_POST['libLecTitulo'] : $_SESSION['libLecTituloF'];
        $_SESSION['libLecTituloF'] = (!isset($_POST['libLecTitulo']) && isset($_SESSION['libLecTituloF'])) ? $_SESSION['libLecTituloF'] : $_POST['libLecTitulo'];

        $_SESSION['libLecAutorF'] = (isset($_POST['libLecAutor']) && !isset($_SESSION['libLecAutorF'])) ? $_POST['libLecAutor'] : $_SESSION['libLecAutorF'];
        $_SESSION['libLecAutorF'] = (!isset($_POST['libLecAutor']) && isset($_SESSION['libLecAutorF'])) ? $_SESSION['libLecAutorF'] : $_POST['libLecAutor'];
        $_SESSION['categoria_libro_lecto_catLecIdF'] = (isset($_POST['categoria_libro_lecto_catLecId']) && !isset($_SESSION['categoria_libro_lecto_catLecIdF'])) ? $_POST['categoria_libro_lecto_catLecId'] : $_SESSION['categoria_libro_lecto_catLecIdF'];
        $_SESSION['categoria_libro_lecto_catLecIdF'] = (!isset($_POST['categoria_libro_lecto_catLecId']) && isset($_SESSION['categoria_libro_lecto_catLecIdF'])) ? $_SESSION['categoria_libro_lecto_catLecIdF'] : $_POST['categoria_libro_lecto_catLecId'];

        $_SESSION['estado_libros_estLibIdF'] = (isset($_POST['estado_libros_estLibId']) && !isset($_SESSION['estado_libros_estLibIdF'])) ? $_POST['estado_libros_estLibId'] : $_SESSION['estado_libros_estLibIdF'];
        $_SESSION['estado_libros_estLibIdF'] = (!isset($_POST['estado_libros_estLibId']) && isset($_SESSION['estado_libros_estLibIdF'])) ? $_SESSION['estado_libros_estLibIdF'] : $_POST['estado_libros_estLibId'];
        
        $_SESSION['buscarLibLecF'] = (isset($_POST['buscarLibLec']) && !isset($_SESSION['buscarLibLecF'])) ? $_POST['buscarLibLec'] : $_SESSION['buscarLibLecF'];
        $_SESSION['buscarLibLecF'] = (!isset($_POST['buscarLibLec']) && isset($_SESSION['buscarLibLecF'])) ? $_SESSION['buscarLibLecF'] : $_POST['buscarLibLec'];

    }

}
