<?php

include_once PATH . 'controladores/ManejoSesiones/BloqueDeSeguridad.php';
require_once PATH . 'modelos/modeloCategoriaElementos/CategoriaElementosDAO.php';
require_once PATH . 'modelos/modeloElementos/ElementosDAO.php';
require_once PATH . 'modelos/modeloEstadoElementos/EstadoElementosDAO.php';


class ElementosControlador{
    private $datos = array();
    private $limite;
    private $enlaces;    
    public function __construct($datos) { //Lo primero que haga es llamar la funcion librosLectoControlador.
        $this->limite=5;
        $this->enlaces=3;
        $this->datos = $datos;
        $this->elementosControlador();
    }
    public function elementosControlador() {
        switch ($this->datos["ruta"]) {
            case "verInventarioElementos":
            case "gestionElementos":
                                // PARA LA PAGINACIÒN SE VERIFICA Y VALIDA QUE EL LIMIT Y EL OFFSET ESTÈN EN LOS RANGOS QUE CORRESPONDAN//
                $limit = (isset($_GET['limit'])) ? $_GET['limit'] :$this->limite;
                $offset = (isset($_GET['pag'])) ? $_GET['pag'] : 0;
                $offset = ($offset < 0 || !isset($_GET['pag'])) ? 0 : $_GET['pag'];

                // SE REALIZA LA CONSERVACIÓN Y CONSTRUCCIÒN DE FILTROS O BUSQUEDA DE LA CONSULTA
                $filtarBuscar = "";
                $this->conservarFiltroYBuscar();

                $filtrarBuscar = $this->armarFiltradoYBusqueda();

                // SE HACE LA CONSULTA A LA BASE PARA TRAER LA CANTIDAD DE REGISTROS SOLICITADOS Y EL TOTAL PARA PAGINARLOS//
                $gestarElementos = new ElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $resultadoConsultaPaginada = $gestarElementos->consultaPaginada($limit, $offset, $filtrarBuscar);

                $totalRegistrosElementos = $resultadoConsultaPaginada[0];
                $listaDeElementos = $resultadoConsultaPaginada[1];
                $paginasExtra = $this->enlaces;
                //SE CONSTRUYEN LOS ENLACES PARA LA PAGINACIÓN QUE SE MOSTRARÀ EN LA VISTA//
                $totalEnlacesPaginacion = (isset($_GET['limit'])) ? $_GET['limit'] : $paginasExtra;
                $paginacionVinculos = $this->enlacesPaginacion($totalRegistrosElementos, $limit, $offset, $totalEnlacesPaginacion); //Se obtienen los enlaces de paginación
                //SE ALISTA LA CONSULTA DE CATEGORIAS DE ELEMENTOS PARA FUTURO FORMULARIO DE FILTRAR//
                $gestarCategoriasElementosLecto = new CategoriaElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroCategoriasElementos = $gestarCategoriasElementosLecto->seleccionarTodos();
                
                 $gestarEstadosElementosLecto = new EstadoElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
                $registroEstadosElementos = $gestarEstadosElementosLecto->seleccionarTodos();

                //SE SUBEN A SESION LOS DATOS NECESARIOS PARA QUE LA VISTA LOS IMPRIMA O UTILICE//
                $_SESSION['listaDeElementos'] = $listaDeElementos;
                $_SESSION['paginacionVinculosElementos'] = $paginacionVinculos;
                $_SESSION['totalRegistrosElementosLecto'] = $totalRegistrosElementos;
                $_SESSION['registroCategoriasElementosLecto'] = $registroCategoriasElementos;
                $_SESSION['registroEstadosElementosLecto'] = $registroEstadosElementos;
                $gestarElementosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                $gestarCategoriasElementosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
                 $gestarEstadosElementosLecto = null; //CIERRE DE LA CONEXIÓN CON LA BASE DE DATOS//
//                header("location:vistas/vistasLibros/listarRegistrosLibros.php");
                 if($this->datos["ruta"]=="verInventarioElementos"){
                header("location:principal.php?contenido=plantillas/Dashio/todosLosElementos.php");
                }
                if($this->datos["ruta"]=="gestionElementos"){
                header("location:principal.php?contenido=plantillas/Dashio/gestionarElementos.php");
//                header("location:vistas/vistasLibros/listarRegistrosLibros.php");
            }
                break;

        }
    }
  public function enlacesPaginacion($totalRegistros = NULL, $limit = 5, $offset = 0, $totalEnlacesPaginacion = 3) {

        $ruta = "verInventarioElementos";
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
            $mostrar[$i +1] = "Controlador.php?ruta=" . $ruta . "&pag=".$i;
            $enlacesProvisional[$i] = "Controlador.php?ruta=" . $ruta ."&pag=".$i;
            $conteoEnlace+= $this->enlaces;
            $siguiente = $i;
        }

        $cantidadProvisional = count($enlacesProvisional);

        if ($offset < $totalRegistros) {
            if($siguiente < ($totalRegistros-$limit)){
            $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente+1);
            } else {
        $totalEnlacesPaginacion = $this->limite;
            $siguiente=$totalRegistros -$totalEnlacesPaginacion-1;
            $mostrar['siguiente'] = "Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente+1);    
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

        if (!empty($_SESSION['eleLecCodF'])) {
            $planConsulta .= " where el.eleLecCodigo ='" . $_SESSION['eleLecCodF'] . "'";
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta        
        } else {
            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta            
           
            if (!empty($_SESSION['estado_elementos_estEleIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.estado_elementos_estEleId like ('%" . $_SESSION['estado_elementos_estEleIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
              if (!empty($_SESSION['estEleNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ee.estEleNombre like ('%" . $_SESSION['estEleNombre'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            
            if (!empty($_SESSION['categoria_elementos_catEleIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " el.categoria_elementos_catEleId like ('%" . $_SESSION['categoria_elementos_catEleIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['catEleNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " ce.catEleNombre like ('%" . $_SESSION['catEleNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            
        }
        if (!empty($_SESSION['buscarEleLecCodF'])) {
            $where = TRUE;
            $condicionBuscar = (($where && !$filtros == 0) ? " or " : " where ");
            $filtros++;
            $planConsulta .= $condicionBuscar;
            $planConsulta .= "( el.eleLecCodigo like '%" . $_SESSION['buscarEleLecCodF'] . "%'";
            $planConsulta .= " or el.estado_elementos_estEleId like '%" . $_SESSION['buscarEleLecCodF'] . "%'";
            $planConsulta .= " or el.categoria_elementos_catEleId like '%" . $_SESSION['buscarEleLecCodF'] . "%'";
            $planConsulta .= " or ce.catEleNombre like '%" . $_SESSION['buscarEleLecCodF'] . "%'";
            $planConsulta .= " or ee.estEleNombre like '%" . $_SESSION['buscarEleLecCodF'] . "%'";
            $planConsulta .= " ) ";
        }
        return $planConsulta;
    }
    }

    public function conservarFiltroYBuscar() {
//        se almacenan en sesion las variables del filtro y buscar para conservarlas en el formulario
        $_SESSION['estLibIdF'] = (isset($_POST['estLibId']) && !isset($_SESSION['estLibIdF'])) ? $_POST['estLibId'] : $_SESSION['estLibIdF'];
        $_SESSION['estLibIdF'] = (!isset($_POST['estLibId']) && isset($_SESSION['estLibIdF'])) ? $_SESSION['estLibIdF'] : $_POST['estLibId'];
        
        $_SESSION['eleLecCodF'] = (isset($_POST['eleLecCod']) && !isset($_SESSION['eleLecCodF'])) ? $_POST['eleLecCod'] : $_SESSION['eleLecCodF'];
        $_SESSION['eleLecCodF'] = (!isset($_POST['eleLecCod']) && isset($_SESSION['eleLecCodF'])) ? $_SESSION['eleLecCodF'] : $_POST['eleLecCod'];

        $_SESSION['estado_elementos_estEleIdF'] = (isset($_POST['estado_elementos_estEleId']) && !isset($_SESSION['estado_elementos_estEleIdF'])) ? $_POST['estado_elementos_estEleId'] : $_SESSION['estado_elementos_estEleIdF'];
        $_SESSION['estado_elementos_estEleIdF'] = (!isset($_POST['estado_elementos_estEleId']) && isset($_SESSION['estado_elementos_estEleIdF'])) ? $_SESSION['estado_elementos_estEleIdF'] : $_POST['estado_elementos_estEleId'];

        $_SESSION['categoria_elementos_catEleIdF'] = (isset($_POST['categoria_elementos_catEleId']) && !isset($_SESSION['categoria_elementos_catEleIdF'])) ? $_POST['categoria_elementos_catEleId'] : $_SESSION['categoria_elementos_catEleIdF'];
        $_SESSION['categoria_elementos_catEleIdF'] = (!isset($_POST['categoria_elementos_catEleId']) && isset($_SESSION['categoria_elementos_catEleIdF'])) ? $_SESSION['categoria_elementos_catEleIdF'] : $_POST['categoria_elementos_catEleId'];
          
        $_SESSION['buscarEleLecCodF'] = (isset($_POST['buscarEleLecCod']) && !isset($_SESSION['buscarEleLecCodF'])) ? $_POST['buscarEleLecCod'] : $_SESSION['buscarEleLecCodF'];
        $_SESSION['buscarEleLecCodF'] = (!isset($_POST['buscarEleLecCod']) && isset($_SESSION['buscarEleLecCodF'])) ? $_SESSION['buscarEleLecCodF'] : $_POST['buscarEleLecCod'];

    }

}
