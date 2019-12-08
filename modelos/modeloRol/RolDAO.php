<?php
include_once PATH . "modelos/ConexDBMySQL.php";

class RolDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = " SELECT r.rolId, r.rolNombre, r.rolDescripcion FROM rol r;";

        $registrar = $this->conexion->prepare($consulta);
        $registrar->execute();

        $listado = array();
        while ($regis = $registrar->fetch(PDO::FETCH_OBJ)) {
            $listado[] = $regis;
        }

        $this->cierreDB();
        return $listado;
    }
   public function seleccionarRolPorPersona($sId) {//llega como parametro un array con datos a consultar
         
        $planConsulta = "select r.rolId,r.rolNombre,r.rolDescripcion ";
        $planConsulta .= " from ((rol r join usuario_s_roles ur on r.rolId=ur.id_rol) ";
        $planConsulta .= " join usuario_s u on u.usuId=ur.id_usuario_s) ";
        $planConsulta .= " right join persona p on p.usuario_s_usuId=ur.id_usuario_s ";
        $planConsulta .= " where p.perDocumento = ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0]));

        $registroEncontrado = array();
        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;
        }
        if (isset($registroEncontrado[0]->usuId) && $registroEncontrado[0]->usuId != FALSE) {
            return ['exitoSeleccionId' => 1, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => 0, 'registroEncontrado' => $registroEncontrado];
        }
    }
    public function insertar ($registro) {
        try {
            $query = "INSERT INTO rol";
            $query .= "(rolId,rolNombre,rolDescripcion) ";
            $query .= " VALUES";
            $query .= "(:rolId,:rolNombre,:rolDescripcion); ";
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":rolId", $registro['rolId']);
            $inserta->bindParam(":rolNombre", $registro['rolNombre']);
            $inserta->bindParam(":rolDescripcion", $registro['rolDescripcion']);
            $inserta->bindParam(":rolEstado", $registro['rolEstado']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];}}
            public function seleccionarId($rolId = array()) {
        $planConsulta = "SELECT * FROM  rol";
        $planConsulta .= " where r.rolId= ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($rolId[0]));
        $registroEncontrado = array();
        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro ;
            
        }
//       $this->cierreBd();
        //Retorna si fue exitoso o no hallar el registro con la llave primaria y sus datos o vacío       
        if (!empty($registroEncontrado)) {
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => FALSE, 'registroEncontrado' => $registroEncontrado];
        }}
        public function actualizar($registro) {
        try {
            $rolNombre = $registro[0]['rolNombre'];
            $rolDescripcion = $registro[0]['rolDescripcion'];
            $rolEstado= $registro[0]['rolEstado'];
            if (isset($rolId)) { 
                $actualizar = "UPDATE rol SET rolNombre = ? , ";
                $actualizar .= " rolDescripcion = ? , ";
                $actualizar .= " WHERE rolEstado= ? ; ";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($estLibId, $estLibNombre,$estLibObs));
                $actu= ['actualizacion' => $actualizacion, 'mensaje' => "Actualización realizada."];
                return $actu;            }
        } catch (PDOException $pdoExc) {
            $act= ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
             return $act;
        }  finally {
            $this-> cierreDB();        }}
            public function eliminar($id = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "DELETE from rol 
                                           WHERE rolId=:rolId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':rolId', $id[0], PDO::PARAM_INT);
        $resultado = $eliminar->execute();
        $this->cierreDB();
        if (!empty($resultado)) {
            return ['eliminar' => TRUE, 'registroEliminado' => array($id[0])];
        } else {
            return ['eliminar' => FALSE, 'registroEliminado' => array($id[0])];}}
             public function eliminarLogico($sId = array()) {// Se deshabilita un registro cambiando su estado a 0
        try {
            $cambiarEstado = 0;
            if (isset($sId[0])) {
                $actualizar = "UPDATE estado_libros SET estLibNombre = ? WHERE estLibId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $sId[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro Inactivado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion , 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();   }}
            public function habilitar($id = array()) {// Se habilita un registro cambiando su estado a 1
        try {
            $cambiarEstado = 1;
            if (isset($id[0])) {
                $actualizar = "UPDATE estado_libros SET rolNombre = ? WHERE rolId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];           }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB(); } }
}

?>