<?php

require_once PATH . 'controladores/ManejoSesiones/ClaseSesion.php';
require_once PATH . 'modelos/modeloLibrosLecto/LibrosLectoDAO.php';
require_once PATH . 'modelos/modeloControlPrestamoLibros/ControlPrestamoLibrosDAO.php';
require_once PATH . 'modelos/modeloPersona/PersonaDAO';
require_once PATH . 'modelos/modeloUsuariosRol/UsuariosRolDAO.php';

class LibrosLectoControlador{

    private $datos = array();

    public function __construct($datos) {
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
                $gestarLibros = new LibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
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

        $mostrar['inicio'] = "../../Controlador.php?ruta=" . $ruta . "&pag=0"; //Enlace a enviar para páginas Iniciales
        $mostrar['anterior'] = "../../Controlador.php?ruta=" . $ruta . "&pag=" . (($anterior)); //Enlace a enviar para páginas anteriores

        for ($i = $offset; $i < ($offset + $limit) && $i < $totalRegistros && $conteoEnlaces < $totalEnlacesPaginacion; $i++) {

            $mostrar[$i + 1] = "../../Controlador.php?ruta=" . $ruta . "&pag=$i";
            $enlacesProvisional[$i] = "Controlador.php?ruta=" . $ruta . "&pag=$i";
            $conteoEnlaces++;
            $siguiente = $i;
        }

        $cantidadProvisional = count($enlacesProvisional);

        if ($offset < $totalRegistros) {
            $mostrar['siguiente'] = "../../Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente + 1);
//            $mostrar.="<a href='controladores/ControladorPrincipal.php?ruta=listarLibros&pag=" . ($totalPag - $totalEnlacesPaginacion) . "'>..::BLOQUE FINAL::..</a><br></center>";
            $mostrar ['final'] = "../../Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros - $totalEnlacesPaginacion);
        }

        if ($offset >= $totalRegistros) {
            $mostrar[$siguiente + 1] = "../../Controlador.php?ruta=" . $ruta . "&pag=" . ($siguiente + 1);
            for ($j = 0; $j < $cantidadProvisional; $j++) {
                $mostrar [] = $enlacesProvisional[$j];
            }
            $mostrar [$totalRegistros - $offset] = "../../Controlador.php?ruta=" . $ruta . "&pag=" . ($totalRegistros - $offset);
        }

        return $mostrar;
    }

    public function armarFiltradoYBusqueda() {

        $planConsulta = "";

        if (!empty($_SESSION['isbnF'])) {
            $planConsulta .= " where l.isbn='" . $_SESSION['isbnF'] . "'";
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta        
        } else {
            $where = false; // inicializar $where a falso ( al comenzar la consulta NO HAY condiciones o criterios de búsqueda)
            $filtros = 0;  // cantidad de filtros/condiciones o criterios de búsqueda al comenzar la consulta            
            if (!empty($_SESSION['titulof'])) {
                $where = true; // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . "l.titulo like upper('%" . $_SESSION['titulof'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['autorF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " l.autor like upper('%" . $_SESSION['autorF'] . "%')"; // con tipo de búsqueda aproximada sin importar mayúsculas ni minúsculas
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['precioF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " l.precio = " . $_SESSION['precioF'];
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['categoriaLibro_catLibIdF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " l.categoriaLibro_catLibId like upper('%" . $_SESSION['categoriaLibro_catLibIdF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
            if (!empty($_SESSION['catLibNombreF'])) {
                $where = true;  // inicializar $where a verdadero ( hay condiciones o criterios de búsqueda)
                $planConsulta .= (($where && !$filtros) ? " where " : " and ") . " cl.catLibNombre like upper('%" . $_SESSION['catLibNombreF'] . "%')";
                $filtros++; //cantidad de filtros/condiciones o criterios de búsqueda
            }
        }
        if (!empty($_SESSION['buscarF'])) {
            $where = TRUE;
            $condicionBuscar = (($where && !$filtros == 0) ? " or " : " where ");
            $filtros++;
            $planConsulta .= $condicionBuscar;
            $planConsulta .= "( isbn like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or titulo like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or autor like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or precio like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or catLibId like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " or catLibNombre like '%" . $_SESSION['buscarF'] . "%'";
            $planConsulta .= " ) ";
        }
        return $planConsulta;
    }

    public function conservarFiltroYBuscar() {
//        se almacenan en sesion las variables del filtro y buscar para conservarlas en el formulario
        $_SESSION['isbnF'] = (isset($_POST['isbn']) && !isset($_SESSION['isbnF'])) ? $_POST['isbn'] : $_SESSION['isbnF'];
        $_SESSION['isbnF'] = (!isset($_POST['isbn']) && isset($_SESSION['isbnF'])) ? $_SESSION['isbnF'] : $_POST['isbn'];

        $_SESSION['tituloF'] = (isset($_POST['titulo']) && !isset($_SESSION['tituloF'])) ? $_POST['titulo'] : $_SESSION['tituloF'];
        $_SESSION['tituloF'] = (!isset($_POST['titulo']) && isset($_SESSION['tituloF'])) ? $_SESSION['tituloF'] : $_POST['titulo'];

        $_SESSION['autorF'] = (isset($_POST['autor']) && !isset($_SESSION['autorF'])) ? $_POST['autor'] : $_SESSION['autorF'];
        $_SESSION['autorF'] = (!isset($_POST['autor']) && isset($_SESSION['autorF'])) ? $_SESSION['autorF'] : $_POST['autor'];

        $_SESSION['precioF'] = (isset($_POST['precio']) && !isset($_SESSION['precioF'])) ? $_POST['precio'] : $_SESSION['precioF'];
        $_SESSION['precioF'] = (!isset($_POST['precio']) && isset($_SESSION['precioF'])) ? $_SESSION['precioF'] : $_POST['precio'];

        $_SESSION['categoriaLibro_catLibIdF'] = (isset($_POST['categoriaLibro_catLibId']) && !isset($_SESSION['categoriaLibro_catLibIdF'])) ? $_POST['categoriaLibro_catLibId'] : $_SESSION['categoriaLibro_catLibIdF'];
        $_SESSION['categoriaLibro_catLibIdF'] = (!isset($_POST['categoriaLibro_catLibId']) && isset($_SESSION['categoriaLibro_catLibIdF'])) ? $_SESSION['categoriaLibro_catLibIdF'] : $_POST['categoriaLibro_catLibId'];

        $_SESSION['buscarF'] = (isset($_POST['buscar']) && !isset($_SESSION['buscarF'])) ? $_POST['buscar'] : $_SESSION['buscarF'];
        $_SESSION['buscarF'] = (!isset($_POST['buscar']) && isset($_SESSION['buscarF'])) ? $_SESSION['buscarF'] : $_POST['buscar'];
    }

}
