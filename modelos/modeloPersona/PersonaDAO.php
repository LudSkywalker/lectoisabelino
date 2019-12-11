<?php
include_once PATH . "modelos/ConexDBMySQL.php";

class PersonaDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT pe.usuario_s_usuId,pe.perDocumento,pe.perNombre,pe.perApellido,u.usuId,u.usuLogin 
                                  FROM (persona pe LEFT JOIN usuario_s u ON pe.usuario_s_usuId=u.usuId) ;";

        $registrar = $this->conexion->prepare($consulta);
        $registrar->execute();

        $listado = array();
        while ($regis = $registrar->fetch(PDO::FETCH_OBJ)) {
            $listado[] = $regis;
        }

        $this->cierreDB();
        return $listado;
    }

    public function insertar($registro) {

        try {

            $inserta = $this->conexion->prepare('INSERT INTO persona (usuario_s_usuId, perDocumento, perNombre, perApellido) VALUES (:usuario_s_usuId, :perDocumento, :perNombre, :perApellido );');
            $inserta->bindParam(":usuario_s_usuId", $registro['usuario_s_usuId']);
            $inserta->bindParam(":perDocumento", $registro['documento']);
            $inserta->bindParam(":perNombre", $registro['nombre']);
            $inserta->bindParam(":perApellido", $registro['apellidos']);
            $execute = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();

            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function seleccionarId($sId) {


        $planConsulta = "select * from persona pe join usuario_s u on pe.usuario_s_usuId=u.usuId ";
        $planConsulta .= " where pe.perDocumento= ? or u.usuLogin = ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0], $sId[1]));

        $registroEncontrado = array();
        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;
        }
        $this->cierreDB();
        if (isset($registroEncontrado)) {
            return ['exitoSeleccionId' => 1, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => 0, 'registroEncontrado' => $registroEncontrado];
        }
    }

    public function actualizar($registro) {

        try {

            $perDocumento = $registro[0]['Documento'];
            $perNombre = $registro[0]['Nombre'];
            $perApellido = $registro[0]['Apellido'];
            $usuario_s_usuId = $registro[0]['usuario_s_usuId'];

            if (isset($usuario_s_usuId)) {
                $actualizar = "UPDATE persona SET perDocumento=? ,perNombre=? , perApellido=? WHERE usuario_s_usuId = ?";
                $actuali = $this->conexion->prepare($actualizar);
                $actualizacion = $actuali->execute(array($perDocumento, $perNombre, $perApellido, $usuario_s_usuId));
                $actu = ['actualizacion' => $actualizacion, 'mensaje' => "Actualizacion realizada."];
                return $actu;
            }
        } catch (PDOException $pdoExc) {
            $act = ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
            return $act;
        } finally {
            $this->cierreDB();
        }
    }

    public function eliminar($id = array()) {
        $planConsulta = "DELETE from persona  
                                           WHERE usuario_s_usuId=:usuario_s_usuId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':usuario_s_usuId', $id[0], PDO::PARAM_INT);
        $resultado = $eliminar->execute();

        $this->cierreDB();

        if (isset($resultado)) {
            return ['eliminar' => TRUE, 'registroEliminado' => array($id[0])];
        } else {
            return ['eliminar' => FALSE, 'registroEliminado' => array($id[0])];
        }
    }
    
      public function eliminarLogico($id = array()) {
        try {
            $cambiarEstado = 0;

            if (isset($id[0])) {
                $actualizar = "UPDATE persona  SET perEstado = ? WHERE usuario_s_usuId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualiza = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualiza, 'mensaje' => "Registro Inactivado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualiza, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function habilitar($id = array()) {
        try {

            $cambiarEstado = 1;

            if (isset($id[0])) {
                $actualizar = "UPDATE persona  SET perEstado = ? WHERE usuario_s_usuId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualiza = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualiza, 'mensaje' => "Registro habilitado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualiza, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

        public function consultaPaginada($limit = null, $offset = null, $filtrarBuscar = "") {

        $planConsulta = "select SQL_CALC_FOUND_ROWS  pe.usuario_s_usuId,pe.perDocumento,pe.perNombre,pe.perApellido,u.usuId,u.usuLogin 
                                  FROM (persona pe LEFT JOIN usuario_s u ON pe.usuario_s_usuId=u.usuId)";

        $planConsulta .= $filtrarBuscar;

        $planConsulta .= "ORDER BY pe.usuario_s_usuId ASC";
        $planConsulta .= " LIMIT " . $limit . " OFFSET " . $offset . " ; ";

        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute();

        $listadoLibros = array();

        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $listadoLibros[] = $registro;
        }

        $listar2 = $this->conexion->prepare("SELECT FOUND_ROWS() as total;");
        $listar2->execute();
        while ($registro = $listar2->fetch(PDO::FETCH_OBJ)) {
            $totalRegistros = $registro->total;
        }
        $this->cantidadTotalRegistros = $totalRegistros;

        return array($totalRegistros, $listadoLibros);
        $this->cierreDB();
    }

    public function totalRegistros() {

        $planConsulta = "SELECT count(*) as total from persona; ";

        $cantidadLibros = $this->conexion->prepare($planConsulta);
        $cantidadLibros->execute(); //Ejecución de la consulta 

        $totalRegistrosLibros = "";

        $totalRegistrosLibros = $cantidadLibros->fetch(PDO::FETCH_OBJ);

        $this->cierreDB();

        return $totalRegistrosLibros;
    }

}

    


?>