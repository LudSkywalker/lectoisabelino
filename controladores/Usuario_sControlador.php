<?php

require_once PATH . 'controladores/ManejoSesiones/ClaseSesion.php';
require_once PATH . 'modelos/modeloUsuarios/UsuariosDAO.php';
require_once PATH . 'modelos/modeloPersona/PersonaDAO.php';
require_once PATH . 'modelos/modeloRol/RolDAO.php';
require_once PATH . 'modelos/modeloUsuariosRol/UsuariosRolDAO.php';

class Usuario_sControlador {

    private $datos = array();

    public function __construct($datos) {
        $this->datos = $datos;
        $this->usuario_sControlador();
    }

    public function usuario_sControlador() {
        switch ($this->datos["ruta"]) {
            case "gestionDeRegistro":
            case "insertarUsuario_s":
                $gestarUsuario_s = new UsuariosDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
//                $insertarUsuario = new Usuario_sVO();
                $existeUsuario_s = $gestarUsuario_s->seleccionarId(array($this->datos["documento"], $this->datos['email'])); //Se revisa si existe la persona en la base            
                $_SESSION['rol'] = (isset($_POST['rol']) && !isset($_SESSION['rol'])) ? $_POST['rol'] : $_SESSION['rol'];
                $_SESSION['rol'] = (!isset($_POST['rol']) && isset($_SESSION['rol'])) ? $_SESSION['rol'] : $_POST['rol'];
                $rolelegido=$_POST['rol'] ;
                
                if ((0 == $existeUsuario_s['exitoSeleccionId'])&&isset($rolelegido)&&$rolelegido!=0) {//Si no existe la persona en la base se procede a insertar
                    $this->datos['password'] = md5($this->datos['password']); //se encripta la contraseña que viene
                    $insertoUsuario_s = $gestarUsuario_s->insertar($this->datos); //inserción de los campos en la tabla usuario_s
                    $exitoInsercionUsuario_s = $insertoUsuario_s['inserto']; //indica si se logró inserción de los campos en la tabla usuario_s
                    $resultadoInsercionUsuario_s = $insertoUsuario_s['resultado']; //Traer el id con que quedó el usuario de lo contrario la excepción o fallo
//                    if (1 == $exitoInsercionUsuario_s) {//si se logró la inserción de los campos en la tabla usuario_s insertar datos en tabla persona
                    $gestarPersona = new PersonaDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                    $this->datos['usuario_s_usuId'] = $resultadoInsercionUsuario_s; //Id 'usuID' con quedó insertado el usuario, con el fin que quede el mismo en la tabla 'persona'
                    $insertoPersona = $gestarPersona->insertar($this->datos); //inserción de los campos en la tabla persona
//                    echo __FILE__ . "-----" . __LINE__;
//                    exit(1);
                    $exitoInsercionPersona = $insertoPersona['inserto']; //indica si se logró inserción de los campos en la tabla persona
                    $resultadoInsercionPersona = $insertoPersona['resultado']; //***Si logró insertar trae el id con que quedó la persona de lo contrario la excepción o fallo
                    //FALTA AQUÍ IMPLEMENTAR LA VALIDACIÓN EN CASO DE NO INSERTAR EN LA TABLA persona
                    //
                    // SE ASIGNA UN ROL GENÉRICO (en este ejemplo 1) AL USUARIO REGISTRADO//
                    $asignarRol = new UsuariosRolDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                    $rolAsignado = $asignarRol->insertar(array($resultadoInsercionUsuario_s, $rolelegido)); //Se envía el id con que quedó el usuario_s y el id del rol 
                    //se abre sesión para almacenar en ella el mensaje de inserción
                    $_SESSION['mensaje'] = "Registrado con èxito para ingreso al sistema"; //mensaje de inserción
                    if ($this->datos['ruta'] == 'gestionDeRegistro') {//si el formulario de la inserción es el de registrarse y fue exitoso se devuelve a login.php
                        header("location:principal.php?contenido=plantillas/Dashio/registro.php");
                    }
                    if ($this->datos['ruta'] == 'insertarUsuario_s') {//si el formulario de la inserción es el de Agregar Usuarios y fue exitoso se devuelve a listarRegistrosUsuario_s.php
//                        header("location:../principal.php?contenido=vistas/vistasUsuario_s/listarRegistrosUsuario_s.php");
                        header("location:../../Controlador.php?ruta=listarPersonas");
                    }
                } else {//Si la persona ya existe se abre sesión para almacenar en ella el mensaje de inserción y devolver datos al formulario por medio de la sesión
                    $_SESSION['documento'] = $this->datos['documento'];
                    $_SESSION['nombre'] = $this->datos['nombre'];
                    $_SESSION['apellidos'] = $this->datos['apellidos'];
                    $_SESSION['email'] = $this->datos['email'];
                    if(!isset($rolelegido)||$rolelegido==0){
                    $_SESSION['mensaje'] = "Rol no seleccionado";
                    } else {
                    $_SESSION['mensaje'] = "Usuario ya existente";
                    }
                    if ($this->datos['ruta'] == 'gestionDeRegistro') {//si al insertar un usuario en el formulario de registrarse y éste ya existe a registro.php
                        header("location:principal.php?contenido=plantillas/Dashio/registro.php");
                    }
                    if ($this->datos['ruta'] == 'insertarUsuario_s') {//si al insertar un usuario en el formulario de Agregar nuevo usuario y éste ya existe a listarRegistrosUsuario_s.php
                        header("location:../../Controlador.php?ruta=mostrarInsertarPersonas");
                    }
                }
                break;

            case "gestionDeAcceso":

                $gestarUsuario_s = new UsuariosDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);

                $this->datos["password"] = md5($this->datos["password"]); //Encriptamos password para que coincida con la base de datos
                $this->datos["documento"] = ""; //Para logueo crear ésta variable límpia por cuanto se utiliza el mismo método de registrarse a continuación
                $existeUsuario_s = $gestarUsuario_s->seleccionarId(array($this->datos["documento"], $this->datos['email'], $this->datos["password"])); //Se revisa si existe la persona en la base
                $logingg=$existeUsuario_s["registroEncontrado"];
                $_SESSION['log'] = $logingg[0]->perDocumento ;
                  if ((0 != $existeUsuario_s['exitoSeleccionId']) && ($existeUsuario_s['registroEncontrado'][0]->usuLogin == $this->datos['email'])) {
                    //se abre sesión para almacenar en ella el mensaje de inserción
                    $_SESSION['mensaje'] = "Bienvenido a nuestra Aplicación."; //mensaje de inserción
                    //Consultamos los roles de la persona logueada
                    $consultaRoles = new RolDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                    $rolesUsuario = $consultaRoles->seleccionarRolPorPersona(array($existeUsuario_s['registroEncontrado'][0]->perDocumento));
                    $cantidadRoles = count($rolesUsuario['registroEncontrado']);
                    $rolesEnSesion = array();
                    for ($i = 0; $i < $cantidadRoles; $i++) {
                        $rolesEnSesion[] = $rolesUsuario['registroEncontrado'][$i]->rolId;
                    }
                    //ABRIR SESION ******************************************
                    $sesionPermitida = new ClaseSesion(); //Se abre sesiòn
                    $sesionPermitida->crearSesion(array($existeUsuario_s['registroEncontrado'][0], $rolesUsuario, $rolesEnSesion)); //Se envìa a la sesiòn los datos del usuario logeado
                    header("location:principal.php?contenido=plantillas/Dashio/ini.php");
                } else {
                    //se abre sesión para almacenar en ella el mensaje de inserción
                    $_SESSION['mensaje'] = "Credenciales de acceso incorrectas"; //mensaje de inserción
                    header("location:login.php");
                }

                break;
            case "inicio":
                $log[0]=$_SESSION['log']; 
                $log[1]=null; 
                $usuario = new UsuariosDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                $usuarios = $usuario->seleccionarId($log);
                $_SESSION['usuarios'] = $usuarios;
                
                $persona = new PersonaDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                $personas = $persona->seleccionarId($log);
                $_SESSION['personas'] = $personas;
                

                header("location:principal.php?contenido=plantillas/Dashio/ini.php");
                break;
            case "registro":
                $roles = new RolDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
                $verRol = $roles->seleccionarTodos();
                $_SESSION['roles'] = $verRol;

                header("location:principal.php?contenido=plantillas/Dashio/registro.php");
                break;
            case "cerrarSesion":
                $cerrarSesion = new ClaseSesion();
                $cerrarSesion->cerrarSesion(); //Se cierra sesión

                break;
        }
    }

}
