
<?php

include_once PATH . 'controladores/LibrosControlador.php';
include_once PATH . 'modelos/modeloLibros/ValidadorLibros.php';
include_once PATH . 'controladores/Usuario_sControlador.php';
include_once PATH . 'controladores/LibrosLectoControlador.php';
include_once PATH . 'controladores/PrestamoLibrosControlador.php';
include_once PATH . 'controladores/PrestamoElementosControlador.php';
include_once PATH . 'modelos/modeloUsuarios/ValidadorUsuarios.php';
include_once PATH . 'modelos/modeloPersona/ValidadorPersona.php';
include_once PATH . 'controladores/ElementosControlador.php';

class ControladorPrincipal {

    private $datos = array();

    public function __construct() {

        if (!empty($_POST) && isset($_POST["ruta"])) {
            $this->datos = $_POST;
        }
        if (!empty($_GET) && isset($_GET["ruta"])) {
            $this->datos = $_GET;
        }

        $this->control();
    }

    public function control() {

        switch ($this->datos['ruta']) {
///*****GESTIONANDO LA TABLA libros********///
            case "mostrarInsertarLibros":
            case "listarLibros":
            case "actualizarLibro":
            case "insertarLibro":
            case "confirmaActualizarLibro":
                if ($this->datos['ruta'] == "insertarLibro" || $this->datos['ruta'] == "confirmaActualizarLibro") {
                    $validarRegistro = new ValidadorLibros();
                    $erroresValidacion = $validarRegistro->validarFormularioLibro($this->datos);
                }
                if (isset($erroresValidacion) && $erroresValidacion != FALSE) {
                    
                    $_SESSION['erroresValidacion'] = $erroresValidacion;
//                    $erroresValidacion = json_encode($erroresValidacion);
                    if ($this->datos['ruta'] == "insertarLibro") {
                        header("location:principal.php?contenido=vistas/vistasLibros/vistaInsertarLibro.php");
                    }
                    if ($this->datos['ruta'] == "confirmaActualizarLibro") {
                        header("location:principal.php?contenido=vistas/vistasLibros/vistaActualizarLibro.php");
                    }
                } else {

                    $librosControlador = new LibrosControlador($this->datos); /* --------->>>>>>>>>>>>>>>*** */
//                $librosControlador->librosControlador(); /* --------->>>>>>>>>>>>>>>*** */
                }
                break;
///******************************************************///
///*****GESTIONANDO LA TABLA usuario_S y PERSONAS********///
            case "cerrarSesion":
            case "gestionDeAcceso":
            case "gestionDeRegistro":
            case "insertarUsuario_s":
            case "confirmaActualizarUsuario_s":
            case "registro":
            case "inicio":
                if ($this->datos['ruta'] == "gestionDeRegistro" || $this->datos['ruta'] == "insertarUsuario_s" || $this->datos['ruta'] == "confirmaActualizarUsuario_s") {
                    $validarRegistro = new ValidadorUsuarios_s();
                    $erroresValidacion = $validarRegistro->validarFormularioUsuarios_s($this->datos);
                }
                if (isset($erroresValidacion) && $erroresValidacion != FALSE) {
                    
                    $_SESSION['erroresValidacion'] = $erroresValidacion;
//                    $erroresValidacion = json_encode($erroresValidacion);
                    if ($this->datos['ruta'] == "gestionDeRegistro") {

                        header("location:registro.php");
                    }
                    if ($this->datos['ruta'] == "insertarUsuario_s") {

                        header("location:principal.php?contenido=plantillas/Dashio/registro.php");
                    }
                    if ($this->datos['ruta'] == "confirmaActualizarUsuario_s") {
                        header("location:principal.php?contenido=vistas/vistasUsuario_s/vistaActualizarUsuario_s.php");
                    }
                } else {

                    $usuario_sControlador = new Usuario_sControlador($this->datos);
                }

             break;
//Gestion la tabal libros lecto                
            case "verInventarioLibros":
            case "eliminarLibroLecto":
            case "gestionLibrosLecto":  
                     $LibrosLectoControlador= new LibrosLectoControlador($this->datos);
            break;
            case "verInventarioElementos":    
            case "gestionElementos":
                     $ElementosControlador= new ElementosControlador($this->datos);
            break;
            case "verLibrosPrestados":
                     $PrestamoLibrosControlador = new PrestamoLibrosControlador($this->datos);
            break;        

            case "verElementosPrestados":
                     $PrstamoElementosControlador = new PrestamoElementosControlador($this->datos);
            break;        

        

                
                
                
        }
    }

}

?>