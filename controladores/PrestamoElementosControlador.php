<?php

include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';
require_once PATH . 'modelos/modeloCategoriaLibrosLecto/CategoriaLibrosLectoDAO.php';
require_once PATH . 'modelos/modeloLibrosLecto/LibrosLectoDAO.php';
require_once PATH . 'modelos/modeloEstadoLibros/EstadoLibrosDAO.php';
require_once PATH . 'modelos/modeloControlPrestamoLibros/ControlPrestamoLibrosDAO.php';


class PrestamoLibrosControlador{

    private $datos = array();
    private $limite;
    

    public function __construct($datos) { //Lo primero que haga es llamar la funcion librosLectoControlador.
        $this->limite=5;
        $this->datos = $datos;
        $this->prestamolibrosControlador();
    }

    public function prestamolibrosControlador() {
        switch ($this->datos["ruta"]) {
            case "verLibrosPrestados":
                                // PARA LA PAGINACIÒN SE VERIFICA Y VALIDA QUE EL LIMIT Y EL OFFSET ESTÈN EN LOS RANGOS QUE CORRESPONDAN//
                $limit = (isset($_GET['limit'])) ? $_GET['limit'] :$this->limite;
                $offset = (isset($_GET['pag'])) ? $_GET['pag'] : 0;
                $offset = ($offset < 0 || !isset($_GET['pag'])) ? 0 : $_GET['pag'];

                // SE REALIZA LA CONSERVACIÓN Y CONSTRUCCIÒN DE FILTROS O BUSQUEDA DE LA CONSULTA
                $filtarBuscar = "";
                $this->conservarFiltroYBuscar();

                $filtrarBuscar = $this->armarFiltradoYBusqueda();

                // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
                $gestarLibrosPrestados = new ControlPrestamoLibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $resultadoConsultaPaginada = $gestarLibrosPrestados->consultaPaginada($limit, $offset, $filtrarBuscar);

                

                $totalRegistrosPrestamos = $resultadoConsultaPaginada[0];
                $listaDePrestamos = $resultadoConsultaPaginada[1];
                $paginasExtra = $this->limite;
                //SE CONSTRUYEN LOS ENLACES PARA LA PAGINACIÓN QUE SE MOSTRARÀ EN LA VISTA//
                $totalEnlacesPaginacion = (isset($_GET['limit'])) ? $_GET['limit'] : $paginasExtra;
                $paginacionVinculos = $this->enlacesPaginacion($totalRegistrosPrestamos, $limit, $offset, $totalEnlacesPaginacion); //Se obtienen los enlaces de paginación
                //
                // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
                $gestarLibrosLecto = new LibrosLectoDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroLibrosLecto= $gestarLibrosLecto->seleccionarTodos();
                
                //SE ALISTA LA CONSULTA DE CATEGORIAS DE LIBROS PARA FUTURO FORMULARIO DE FILTRAR//
                $gestarCategoriasLibrosLecto = new CategoriaLibrosLectoDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroCategoriasLibros = $gestarCategoriasLibrosLecto->seleccionarTodos();
                
                $gestarEstadosLibrosLecto = new EstadoLibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroEstadosLibros =$gestarEstadosLibrosLecto->seleccionarTodos();

                //SE SUBEN A SESION LOS DATOS NECESARIOS PARA QUE LA VISTA LOS IMPRIMA O UTILICE//
                $_SESSION['listaDePrestamos'] = $listaDePrestamos;
                $_SESSION['paginacionVinculosPrestamos'] = $paginacionVinculos;
                $_SESSION['totalRegistrosPrestamos'] = $totalRegistrosPrestamos;
                $_SESSION['registroLibrosLecto'] = $registroLibrosLecto;
                $_SESSION['registroCategoriasLibrosLecto'] = $registroCategoriasLibros;
                $_SESSION['registroEstadosLibrosLecto'] = $registroEstadosLibros;
                $gestarLibrosPrestados = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarLibrosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarCategoriasLibrosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarEstadosLibrosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                header("location:principal.php?contenido=plantillas/Dashio/librosPrestados.php");
//                header("location:vistas/vistasLibros/listarRegistrosLibros.php");
                break;

        }
    }
  public function enlacesPaginacion($totalRegistros = NULL, $limit = 5, $offset = 0, $totalEnlacesPaginacion = 5) {

        $ruta = "verLibrosPrestados";

        if (isset($offset) && (int) $offset <= 0) {
            $offset = 0;
        }
        if (isset($offset) && ((int) $offset > ($totalRegistros - $limit))) {
            $offset = ($totalRegistros - $limit) -($totalRegistros%$limit);
        }
        $anterior = $offset - $totalEnlacesPaginacion; /*         * **** */
        $siguiente = $offset + $totalEnlacesPaginacion; /*         * **** */

        $mostrar = array();
        $enlacesProvisional = array();
        $conteoEnlaces = 0;

        $mostrar['inicio'] = "Controlador.php?ruta=" . $ruta . "&pag=0"; //Enlace a enviar para páginas Iniciales
        $mostrar['anterior'] = "Controlador.php?ruta=" . $ruta . "&pag=" . (($anterior)); //Enlace a enviar para páginas anteriores

        for ($i = $offset; $i < ($offset + $limit) && $i < $totalRegistros && $conteoEnlaces < $totalEnlacesPaginacion; $i++) {

            $mostrar[$i + 1] = "Controlador.php?ruta=" . $ruta . "&pag=".$i;
            $enlacesProvisional[$i] = "Controlador.php?ruta=" . $ruta ."&pag=".$i;
            $conteoEnlaces++;
            $siguiente = $i;
        }

        $cantidadProvisional = count($enlacesProvisional);

        if ($offset < $totalRegistros) {
            if($siguiente < ($totalRegistros-$limit)){
            $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente+1);
            } else {
            $siguiente=$totalRegistros -$totalEnlacesPaginacion;
            $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente);    
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

        $planConsulta = "  where cpl.conPPrestado = 1 ";

        if (!empty($_SESSION['conPIdF'])) {
            $planConsulta .= " and cpl.conPId='" . $_SESSION['conPIdF'] . "'";
            $filtros = 1;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta        
        } else {
            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
            $filtros = 1;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta            
            
            if (!empty($_SESSION['persona_usuario_s_usuIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " cpl.persona_usuario_s_usuId like ('%" . $_SESSION['persona_usuario_s_usuIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['perDocumentoF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " pe.perDocumento like ('%" . $_SESSION['perDocumentoF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['perNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " pe.perNombre like ('%" . $_SESSION['perNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['perApellidoF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " pe.perApellido like ('%" . $_SESSION['perApellidoF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            
            if (!empty($_SESSION['libros_lecto_libLecIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " cpl.libros_lecto_libLecId like ('%" . $_SESSION['libros_lecto_libLecIdF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            
            if (!empty($_SESSION['libLecIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ll.libLecId like ('%" . $_SESSION['libLecIdF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['libLecCodigoF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ll.libLecCodigo like ('%" . $_SESSION['libLecCodigoF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['libLecTituloF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ll.libLecTitulo like upper('%" . $_SESSION['libLecTituloF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
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
        if (!empty($_SESSION['buscarPresF'])) {
            $where = TRUE;
            $condicionBuscar = (($where && !$filtros == 0) ? " or " : " where ");
            $filtros++;
            $planConsulta .= $condicionBuscar;
            $planConsulta .= "( cpl.conPId like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or pe.usuario_s_usuId like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or pe.perNombre like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or pe.perApellido like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or ll.libLecCodigo like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or ll.libLecTitulo like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or cll.catLecNombre like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or el.estLibNombre like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " or cpl.conPFechaSal like '%" . $_SESSION['buscarPresF'] . "%'";
            $planConsulta .= " ) ";
        }
        return $planConsulta;
    }

    public function conservarFiltroYBuscar() {
//        se almacenan en sesion las variables del filtro y buscar para conservarlas en el formulario
        $_SESSION['conPIdF'] = (isset($_POST['conPId']) && !isset($_SESSION['conPIdF'])) ? $_POST['conPId'] : $_SESSION['conPIdF'];
        $_SESSION['conPIdF'] = (!isset($_POST['conPId']) && isset($_SESSION['conPIdF'])) ? $_SESSION['conPIdF'] : $_POST['conPId'];
        
        $_SESSION['perDocumentoF'] = (isset($_POST['perDocumento']) && !isset($_SESSION['perDocumentoF'])) ? $_POST['perDocumento'] : $_SESSION['perDocumentoF'];
        $_SESSION['perDocumentoF'] = (!isset($_POST['perDocumento']) && isset($_SESSION['perDocumentoF'])) ? $_SESSION['perDocumentoF'] : $_POST['perDocumento'];
        
        $_SESSION['perNombreF'] = (isset($_POST['perNombre']) && !isset($_SESSION['perNombreF'])) ? $_POST['perNombre'] : $_SESSION['perNombreF'];
        $_SESSION['perNombreF'] = (!isset($_POST['perNombre']) && isset($_SESSION['perNombreF'])) ? $_SESSION['perNombreF'] : $_POST['perNombre'];
        
        $_SESSION['perApellidoF'] = (isset($_POST['perApellido']) && !isset($_SESSION['perApellidoF'])) ? $_POST['perApellido'] : $_SESSION['perApellidoF'];
        $_SESSION['perApellidoF'] = (!isset($_POST['perApellido']) && isset($_SESSION['perApellidoF'])) ? $_SESSION['perApellidoF'] : $_POST['perApellido'];
        
        $_SESSION['libLecIdF'] = (isset($_POST['libLecId']) && !isset($_SESSION['libLecIdF'])) ? $_POST['libLecId'] : $_SESSION['libLecIdF'];
        $_SESSION['libLecIdF'] = (!isset($_POST['libLecId']) && isset($_SESSION['libLecIdF'])) ? $_SESSION['libLecIdF'] : $_POST['libLecId'];
        
        $_SESSION['libLecCodF'] = (isset($_POST['libLecCod']) && !isset($_SESSION['libLecCodF'])) ? $_POST['libLecCod'] : $_SESSION['libLecCodF'];
        $_SESSION['libLecCodF'] = (!isset($_POST['libLecCod']) && isset($_SESSION['libLecCodF'])) ? $_SESSION['libLecCodF'] : $_POST['libLecCod'];

        $_SESSION['libLecTituloF'] = (isset($_POST['libLecTitulo']) && !isset($_SESSION['libLecTituloF'])) ? $_POST['libLecTitulo'] : $_SESSION['libLecTituloF'];
        $_SESSION['libLecTituloF'] = (!isset($_POST['libLecTitulo']) && isset($_SESSION['libLecTituloF'])) ? $_SESSION['libLecTituloF'] : $_POST['libLecTitulo'];

        
        $_SESSION['categoria_libro_lecto_catLecIdF'] = (isset($_POST['categoria_libro_lecto_catLecId']) && !isset($_SESSION['categoria_libro_lecto_catLecIdF'])) ? $_POST['categoria_libro_lecto_catLecId'] : $_SESSION['categoria_libro_lecto_catLecIdF'];
        $_SESSION['categoria_libro_lecto_catLecIdF'] = (!isset($_POST['categoria_libro_lecto_catLecId']) && isset($_SESSION['categoria_libro_lecto_catLecIdF'])) ? $_SESSION['categoria_libro_lecto_catLecIdF'] : $_POST['categoria_libro_lecto_catLecId'];

        $_SESSION['estado_libros_estLibIdF'] = (isset($_POST['estado_libros_estLibId']) && !isset($_SESSION['estado_libros_estLibIdF'])) ? $_POST['estado_libros_estLibId'] : $_SESSION['estado_libros_estLibIdF'];
        $_SESSION['estado_libros_estLibIdF'] = (!isset($_POST['estado_libros_estLibId']) && isset($_SESSION['estado_libros_estLibIdF'])) ? $_SESSION['estado_libros_estLibIdF'] : $_POST['estado_libros_estLibId'];
        
        $_SESSION['buscarPresF'] = (isset($_POST['buscarPres']) && !isset($_SESSION['buscarPresF'])) ? $_POST['buscarPres'] : $_SESSION['buscarPresF'];
        $_SESSION['buscarPresF'] = (!isset($_POST['buscarPres']) && isset($_SESSION['buscarPresF'])) ? $_SESSION['buscarPresF'] : $_POST['buscarPres'];

    }

}
