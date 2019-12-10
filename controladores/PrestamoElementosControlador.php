<?php

include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';
require_once PATH . 'modelos/modeloCategoriaElementos/CategoriaElementosDAO.php';
require_once PATH . 'modelos/modeloElementos/ElementosDAO.php';
require_once PATH . 'modelos/modeloEstadoElementos/EstadoElementosDAO.php';
require_once PATH . 'modelos/modeloControlElementos/ControlElementosDAO.php';


class PrestamoElementosControlador{

    private $datos = array();
    private $limite;
    

    public function __construct($datos) { //Lo primero que haga es llamar la funcion librosLectoControlador.
        $this->limite=5;
        $this->datos = $datos;
        $this->PrestamoElementosControlador();
    }

    public function PrestamoElementosControlador() {
        switch ($this->datos["ruta"]) {
            case "verElementosPrestados":
                                // PARA LA PAGINACIÒN SE VERIFICA Y VALIDA QUE EL LIMIT Y EL OFFSET ESTÈN EN LOS RANGOS QUE CORRESPONDAN//
                $limit = (isset($_GET['limit'])) ? $_GET['limit'] :$this->limite;
                $offset = (isset($_GET['pag'])) ? $_GET['pag'] : 0;
                $offset = ($offset < 0 || !isset($_GET['pag'])) ? 0 : $_GET['pag'];

                // SE REALIZA LA CONSERVACIÓN Y CONSTRUCCIÒN DE FILTROS O BUSQUEDA DE LA CONSULTA
                $filtarBuscar = "";
                $this->conservarFiltroYBuscar();

                $filtrarBuscar = $this->armarFiltradoYBusqueda();

                // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
                $gestarElementosPrestados = new ControlElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $resultadoConsultaPaginada = $gestarElementosPrestados->consultaPaginada($limit, $offset, $filtrarBuscar);

                

                $totalRegistrosPrestamos = $resultadoConsultaPaginada[0];
                $listaDePrestamos = $resultadoConsultaPaginada[1];
                $paginasExtra = $this->limite;
                //SE CONSTRUYEN LOS ENLACES PARA LA PAGINACIÓN QUE SE MOSTRARÀ EN LA VISTA//
                $totalEnlacesPaginacion = (isset($_GET['limit'])) ? $_GET['limit'] : $paginasExtra;
                $paginacionVinculos = $this->enlacesPaginacion($totalRegistrosPrestamos, $limit, $offset, $totalEnlacesPaginacion); //Se obtienen los enlaces de paginación
                //
                // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
                $gestarElementos = new ElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroElementos= $gestarElementos->seleccionarTodos();
                
                //SE ALISTA LA CONSULTA DE CATEGORIAS DE LIBROS PARA FUTURO FORMULARIO DE FILTRAR//
                $gestarCategoriaElementos = new CategoriaElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroCategoriaElementos = $gestarCategoriaElementos->seleccionarTodos();
                
                $gestarEstadoElementos = new EstadoElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroEstadoElementos =$gestarEstadoElementos->seleccionarTodos();

                //SE SUBEN A SESION LOS DATOS NECESARIOS PARA QUE LA VISTA LOS IMPRIMA O UTILICE//
                $_SESSION['listaDePrestamosEle'] = $listaDePrestamos;
                $_SESSION['paginacionVinculosPrestamosEle'] = $paginacionVinculos;
                $_SESSION['totalRegistrosPrestamosEle'] = $totalRegistrosPrestamos;
                $_SESSION['registroElementos'] = $registroElementos;
                $_SESSION['registroCategoriasElementos'] = $registroCategoriaElementos;
                $_SESSION['registroEstadosElementos'] = $registroEstadoElementos;
                $gestarElementosPrestados = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarElementos = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarCategoriaElementos = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarEstadoElementos = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                header("location:principal.php?contenido=plantillas/Dashio/elementosPrestados.php");
//                header("location:vistas/vistasLibros/listarRegistrosLibros.php");
                break;

        }
    }
  public function enlacesPaginacion($totalRegistros = NULL, $limit = 5, $offset = 0, $totalEnlacesPaginacion = 5) {

        $ruta = "verElementosPrestados";

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
//            $mostrar.="<a href='controladores/ControladorPrincipal.php?ruta=listarElementos&pag=" . ($totalPag - $totalEnlacesPaginacion) . "'>..::BLOQUE FINAL::..</a><br></center>";
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

        $planConsulta = "  where ce.conEPrestado = 1 ";

        if (!empty($_SESSION['conEIdF'])) {
            $planConsulta .= " and ce.conEId='" . $_SESSION['conEIdF'] . "'";
            $filtros = 1;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta        
        } else {
            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
            $filtros = 1;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta            
            
            if (!empty($_SESSION['persona_usuario_s_usuId'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ce.persona_usuario_s_usuId ('%" . $_SESSION['persona_usuario_s_usuIdF'] . "%')";
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
            
            if (!empty($_SESSION['elementos_lecto_eleLecIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ce.elementos_lecto_eleLecId like ('%" . $_SESSION['elementos_lecto_eleLecIdF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            
            if (!empty($_SESSION['eleLecIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.eleLecId like ('%" . $_SESSION['eleLecIdF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['eleLecCodigoF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.eleLecCodigo like ('%" . $_SESSION['eleLecCodigoF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }            
            if (!empty($_SESSION['categoria_elementos_catEleIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.categoria_elementos_catEleId like ('%" . $_SESSION['categoria_elementos_catEleIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['catEleNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " cel.catEleNombre like upper('%" . $_SESSION['catEleNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            
            if (!empty($_SESSION['estado_elementos_estEleIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.estado_elementos_estEleId like ('%" . $_SESSION['estado_elementos_estEleIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['estEleNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ee.estEleNombre like upper('%" . $_SESSION['estLibNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
        }
        if (!empty($_SESSION['buscarPresEleF'])) {
            $where = TRUE;
            $condicionBuscar = (($where && !$filtros == 0) ? " or " : " where ");
            $filtros++;
            $planConsulta .= $condicionBuscar;
            $planConsulta .= "( cpl.conPId like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or pe.usuario_s_usuId like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or pe.perNombre like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or pe.perApellido like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or el.eleLecCodigo like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or cel.catEleNombre like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or ee.estEleNombre like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " or ce.conEFechaSal like '%" . $_SESSION['buscarPresEleF'] . "%'";
            $planConsulta .= " ) ";
        }
        return $planConsulta;
    }

    public function conservarFiltroYBuscar() {
//        se almacenan en sesion las variables del filtro y buscar para conservarlas en el formulario
        $_SESSION['conEIdF'] = (isset($_POST['conEId']) && !isset($_SESSION['conEIdF'])) ? $_POST['conEId'] : $_SESSION['conEIdF'];
        $_SESSION['conEIdF'] = (!isset($_POST['conEId']) && isset($_SESSION['conEIdF'])) ? $_SESSION['conEIdF'] : $_POST['conEId'];
        
        $_SESSION['perDocumentoF'] = (isset($_POST['perDocumento']) && !isset($_SESSION['perDocumentoF'])) ? $_POST['perDocumento'] : $_SESSION['perDocumentoF'];
        $_SESSION['perDocumentoF'] = (!isset($_POST['perDocumento']) && isset($_SESSION['perDocumentoF'])) ? $_SESSION['perDocumentoF'] : $_POST['perDocumento'];
        
        $_SESSION['perNombreF'] = (isset($_POST['perNombre']) && !isset($_SESSION['perNombreF'])) ? $_POST['perNombre'] : $_SESSION['perNombreF'];
        $_SESSION['perNombreF'] = (!isset($_POST['perNombre']) && isset($_SESSION['perNombreF'])) ? $_SESSION['perNombreF'] : $_POST['perNombre'];
        
        $_SESSION['perApellidoF'] = (isset($_POST['perApellido']) && !isset($_SESSION['perApellidoF'])) ? $_POST['perApellido'] : $_SESSION['perApellidoF'];
        $_SESSION['perApellidoF'] = (!isset($_POST['perApellido']) && isset($_SESSION['perApellidoF'])) ? $_SESSION['perApellidoF'] : $_POST['perApellido'];
        
        $_SESSION['eleLecIdF'] = (isset($_POST['eleLecId']) && !isset($_SESSION['eleLecIdF'])) ? $_POST['eleLecId'] : $_SESSION['eleLecIdF'];
        $_SESSION['eleLecIdF'] = (!isset($_POST['eleLecId']) && isset($_SESSION['eleLecIdF'])) ? $_SESSION['eleLecIdF'] : $_POST['eleLecId'];
        
        $_SESSION['eleLecCodigoF'] = (isset($_POST['eleLecCodigo']) && !isset($_SESSION['eleLecCodigoF'])) ? $_POST['eleLecCodigo'] : $_SESSION['eleLecCodigoF'];
        $_SESSION['eleLecCodigoF'] = (!isset($_POST['eleLecCodigo']) && isset($_SESSION['eleLecCodigoF'])) ? $_SESSION['eleLecCodigoF'] : $_POST['eleLecCodigo'];

        $_SESSION['categoria_elementos_catEleIdF'] = (isset($_POST['categoria_elementos_catEleId']) && !isset($_SESSION['categoria_elementos_catEleId'])) ? $_POST['categoria_elementos_catEleId'] : $_SESSION['categoria_elementos_catEleIdF'];
        $_SESSION['categoria_elementos_catEleIdF'] = (!isset($_POST['categoria_elementos_catEleId']) && isset($_SESSION['categoria_elementos_catEleIdF'])) ? $_SESSION['categoria_elementos_catEleIdF'] : $_POST['categoria_elementos_catEleId'];

        $_SESSION['estado_elementos_estEleIdF'] = (isset($_POST['estado_elementos_estEleId']) && !isset($_SESSION['estado_elementos_estEleIdF'])) ? $_POST['estado_elementos_estEleId'] : $_SESSION['estado_elementos_estEleIdF'];
        $_SESSION['estado_elementos_estEleIdF'] = (!isset($_POST['estado_elementos_estEleId']) && isset($_SESSION['estado_elementos_estEleId'])) ? $_SESSION['estado_elementos_estEleIdF'] : $_POST['estado_elementos_estEleId'];
        
        $_SESSION['buscarPresEleF'] = (isset($_POST['buscarPresEle']) && !isset($_SESSION['buscarPresEleF'])) ? $_POST['buscarPresEle'] : $_SESSION['buscarPresEleF'];
        $_SESSION['buscarPresEleF'] = (!isset($_POST['buscarPresEle']) && isset($_SESSION['buscarPresEleF'])) ? $_SESSION['buscarPresEleF'] : $_POST['buscarPresEle'];

    }

}
