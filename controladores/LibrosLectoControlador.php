<?php

include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';
require_once PATH . 'modelos/modeloCategoriaLibrosLecto/CategoriaLibrosLectoDAO.php';
require_once PATH . 'modelos/modeloLibrosLecto/LibrosLectoDAO.php';
require_once PATH . 'modelos/modeloEstadoLibros/EstadoLibrosDAO.php';

class LibrosLectoControlador {

    private $datos = array();
    private $limite;
    private $enlaces;

    public function __construct($datos) { //Lo primero que haga es llamar la funcion librosLectoControlador.
        $this->limite = 3;
        $this->enlaces = 3;
        $this->datos = $datos;
        $this->librosLectoControlador();
    }

    public function librosLectoControlador() {
        switch ($this->datos["ruta"]) {
            case"eliminarLibroLecto":

                $idl = (isset($_GET['idEli'])) ? $_GET['idEli'] : null;
                $id = array($idl);
                try {
                    $gestareliLibrosLecto = new LibrosLectoDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                    $resultadoDelete = $gestareliLibrosLecto->eliminarLogico($id);
                    header("location:Controlador.php?ruta=gestionLibrosLecto&pag=0&#cont");


                    $_SESSION['mensaje'] = "Se ha borrado el libro correctamente";
                } catch (Exception $exc) {
                    $_SESSION['mensaje'] = "No se pudo borrar el libro correctamente";
                }

                break;

            case "gestionLibrosLecto":
                $paginacion = $this->paginacion();

                header("location:principal.php?contenido=plantillas/Dashio/gestionarLibrosLecto.php");
                break;
            case "verInventarioLibros":
                $paginacion = $this->paginacion();
                header("location:principal.php?contenido=plantillas/Dashio/todosLosLibros.php");
                break;
        }
    }

    public function paginacion() {
        // PARA LA PAGINACIÒN SE VERIFICA Y VALIDA QUE EL LIMIT Y EL OFFSET ESTÈN EN LOS RANGOS QUE CORRESPONDAN//
        $limit = (isset($_GET['limit'])) ? $_GET['limit'] : $this->limite;
        $offset = (isset($_GET['pag'])) ? $_GET['pag'] : 0;
        $offset = ($offset < 0 || !isset($_GET['pag'])) ? 0 : $_GET['pag'];

        // SE REALIZA LA CONSERVACIÓN Y CONSTRUCCIÒN DE FILTROS O BUSQUEDA DE LA CONSULTA
        $filtarBuscar = "";
        $this->conservarFiltroYBuscar();

        $filtrarBuscar = $this->armarFiltradoYBusqueda();

        // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
        $gestarLibrosLecto = new LibrosLectoDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
        $resultadoConsultaPaginada = $gestarLibrosLecto->consultaPaginada($limit, $offset, $filtrarBuscar);

        $totalRegistrosLibros = $resultadoConsultaPaginada[0];
        $listaDeLibros = $resultadoConsultaPaginada[1];
        $paginasExtra = $this->enlaces;
        //SE CONSTRUYEN LOS ENLACES PARA LA PAGINACIÓN QUE SE MOSTRARÀ EN LA VISTA//
        $totalEnlacesPaginacion = (isset($_GET['limit'])) ? $_GET['limit'] : $paginasExtra;
        $rutas = $this->datos["ruta"];
        $paginacionVinculos = $this->enlacesPaginacion($totalRegistrosLibros, $limit, $offset, $totalEnlacesPaginacion, $rutas); //Se obtienen los enlaces de paginación
        //SE ALISTA LA CONSULTA DE CATEGORIAS DE LIBROS PARA FUTURO FORMULARIO DE FILTRAR//
        $gestarCategoriasLibrosLecto = new CategoriaLibrosLectoDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
        $registroCategoriasLibros = $gestarCategoriasLibrosLecto->seleccionarTodos();

        $gestarEstadosLibrosLecto = new EstadoLibrosDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
        $registroEstadosLibros = $gestarEstadosLibrosLecto->seleccionarTodos();

        //SE SUBEN A SESION LOS DATOS NECESARIOS PARA QUE LA VISTA LOS IMPRIMA O UTILICE//
        $_SESSION['listaDeLibrosLecto'] = $listaDeLibros;
        $_SESSION['paginacionVinculosLecto'] = $paginacionVinculos;
        $_SESSION['totalRegistrosLibrosLecto'] = $totalRegistrosLibros;
        $_SESSION['registroCategoriasLibrosLecto'] = $registroCategoriasLibros;
        $_SESSION['registroEstadosLibrosLecto'] = $registroEstadosLibros;
        $gestarLibrosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
        $gestarCategoriasLibrosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
        $gestarEstadosLibrosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
    }

    public function enlacesPaginacion($totalRegistros = NULL, $limit = 5, $offset = 0, $totalEnlacesPaginacion = 3, $ruta) {


        if (isset($offset) && (int) $offset <= 0) {
            $offset = 0;
        }
        if (isset($offset) && ((int) $offset > ($totalRegistros - $limit))) {
            $offset = ($totalRegistros - $limit) - ($totalRegistros % $limit);
        }
        $anterior = $offset - $totalEnlacesPaginacion; /*         * **** */
        $siguiente = $offset + $totalEnlacesPaginacion; /*         * **** */

        $mostrar = array();
        $enlacesProvisional = array();
        $conteoEnlaces = 0;

        $mostrar['inicio'] = "Controlador.php?ruta=" . $ruta . "&pag=0"; //Enlace a enviar para páginas Iniciales
        $mostrar['anterior'] = "Controlador.php?ruta=" . $ruta . "&pag=" . (($anterior)); //Enlace a enviar para páginas anteriores

        for ($i = $offset; $i < ($offset + $limit) && $i < $totalRegistros && $conteoEnlaces < $totalEnlacesPaginacion; $i++) {
            $mostrar[$i + 1] = "Controlador.php?ruta=" . $ruta . "&pag=" . $i;
            $enlacesProvisional[$i] = "Controlador.php?ruta=" . $ruta . "&pag=" . $i;
            $conteoEnlace += $this->enlaces;
            $siguiente = $i;
        }

        $cantidadProvisional = count($enlacesProvisional);

        if ($offset < $totalRegistros) {
            if ($siguiente < ($totalRegistros - $limit)) {
                $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente + 1);
            } elseif ($totalRegistros < $limit) {
                $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros + 1);
            } else {
                $totalEnlacesPaginacion = $this->limite;
                $siguiente = $totalRegistros - $totalEnlacesPaginacion - 1;
                $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente + 1);
            }
//            $mostrar.="<a href='controladores/ControladorPrincipal.php?ruta=listarLibros&pag=" . ($totalPag - $totalEnlacesPaginacion) . "'>..::BLOQUE FINAL::..</a><br></center>";
            $mostrar ['final'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros - $totalEnlacesPaginacion);
        }

        if ($offset >= $totalRegistros) {
            $mostrar[$siguiente + 1] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente );
            for ($j = 0; $j < $cantidadProvisional; $j++) {
                $mostrar [] = $enlacesProvisional[$j];
            }
            $mostrar [$totalRegistros - $offset] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros - $offset);
        }

        return $mostrar;
    }

    public function armarFiltradoYBusqueda() {

        $planConsulta = "";

            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
        if (!empty($_SESSION['libLecCodF'])) {
            $planConsulta .= " where ( ll.libLecCodigo ='" . $_SESSION['libLecCodF'] . "'";
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta        
        } else {
            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta            
            if (!empty($_SESSION['libLecTituloF'])) {
                $where = true; // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where ( " : " and ") . "ll.libLecTitulo like upper('%" . $_SESSION['libLecTituloF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['libLecAutorF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where ( " : " and ") . " ll.libLecAutor like upper('%" . $_SESSION['libLecAutorF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['categoria_libro_lecto_catLecIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where ( " : " and ") . " ll.categoria_libro_lecto_catLecId like ('%" . $_SESSION['categoria_libro_lecto_catLecIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['catLecNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where ( " : " and ") . " cll.catLecNombre like upper('%" . $_SESSION['catLecNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }

            if (!empty($_SESSION['estado_libros_estLibIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where ( " : " and ") . " ll.estado_libros_estLibId like ('%" . $_SESSION['estado_libros_estLibIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['estLibNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where ( " : " and ") . " el.estLibNombre like upper('%" . $_SESSION['estLibNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
        }
        if (!empty($_SESSION['buscarLibLecF'])) {
            $condicionBuscar = (($where && !$filtros == 0) ? " or (" : " where (  ");
            $filtros++;
            $planConsulta .= $condicionBuscar;
            $planConsulta .= "( ll.libLecCodigo like '%" . $_SESSION['buscarLibLecF'] . "%'";
            $planConsulta .= " or ll.libLecTitulo like '%" . $_SESSION['buscarLibLecF'] . "%'";
            $planConsulta .= " or ll.libLecAutor like '%" . $_SESSION['buscarLibLecF'] . "%'";
            $planConsulta .= " or cll.catLecNombre like '%" . $_SESSION['buscarLibLecF'] . "%'";
            $planConsulta .= " or el.estLibNombre like '%" . $_SESSION['buscarLibLecF'] . "%'";
            $planConsulta .= " ) ";
            $where=true; 
        }
        $condicionBuscar = (($where && !$filtros == 0) ? " ) and " : " where  ");
        $planConsulta .= $condicionBuscar;
        $planConsulta .= "  ll.libLecEstado = 1 ";
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
                
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
