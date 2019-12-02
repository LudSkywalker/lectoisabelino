<?php


include_once PATH . "modelos/ConexDBMySQL.php";

class UsuariosRolDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT ur.id_usuario_s,u.usuId, u.usuLogin,r.rolId, r.rolNombre 
                                  FROM ((usuario_s_roles ur LEFT JOIN usuario_s u ON ur.id_usuario_s=u.usuId)
                                  LEFT JOIN rol r ON ur.id_rol = r.rolId) ;";

        $registrar = $this->conexion->prepare($consulta);
        $registrar->execute();

        $listado = array();
        while ($regis = $registrar->fetch(PDO::FETCH_OBJ)) {
            $listado[] = $regis;
        }

        $this->cierreDB();
        return $listado;
    }

    public function insertar ($registro) {
        try {
            $query = "INSERT INTO usuario_s_roles";
            $query .= "(id_usuario_s,id_rol, usuRolEstado, usuRolFecha, categoria_elementos_catEleId) ";
            $query .= " VALUES";
            $query .= "(:id_usuario_s, :id_rol, :usuRolEstado, :usuRolFecha, :categoria_elementos_catEleId); ";
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":id_usuario_s", $registro['id_usuario_s']);
            $inserta->bindParam(":id_rol", $registro['id_rol']);
            $inserta->bindParam(":usuRolEstado", $registro['usuRolEstado']);
            $inserta->bindParam(":usuRolFecha", $registro['usuRolFecha']);
            $inserta->bindParam(":categoria_elementos_catEleId", $registro['categoria_elementos_catEleId']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];}}
    public function seleccionarId($id_usuario_s = array()) {
        $planConsulta = "select * from usuario_s_roles ur ";
        $planConsulta .= " where ur.id_usuario_s= ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($id_usuario_s[0]));
        $registroEncontrado = array();
        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;}
//       $this->cierreBd();
        //Retorna si fue exitoso o no hallar el registro con la llave primaria y sus datos o vacío       
        if (!empty($registroEncontrado)) {
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => FALSE, 'registroEncontrado' => $registroEncontrado];
        }}
    public function actualizar($registro) {
        try {
            $id_rol = $registro[0]['id_rol'];
            $usuRolEstado = $registro[0]['usuRolEstado'];
            $usuRolFecha = $registro[0]['usuRolFecha'];
            $categoria_elementos_catEleId = $registro[0]['categoria_elementos_catEleId'];
            $id_usuario_s = $registro[0]['id_usuario_s'];
            if (isset($id_usuario_s)) { 
                $actualizar = "UPDATE usuario_s_roles SET id_rol = ? , ";
                $actualizar .= " usuRolEstado = ? , ";
                $actualizar .= " usuRolFecha = ? , ";
                $actualizar .= " categoria_elementos_catEleId = ? ";
                $actualizar .= " WHERE id_usuario_s= ? ; ";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($id_rol, $usuRolEstado, $usuRolFecha, $categoria_elementos_catEleId, $id_usuario_s));
                $actu= ['actualizacion' => $actualizacion, 'mensaje' => "Actualización realizada."];
                return $actu;            }
        } catch (PDOException $pdoExc) {
            $act= ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
             return $act;
        }  finally {
            $this-> cierreDB();        }}
    public function eliminar($id = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "DELETE from usuario_s_roles  
                                           WHERE id_usuario_s=:id_usuario_s ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':id_usuario_s', $id[0], PDO::PARAM_INT);
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
                $actualizar = "UPDATE usuario_s_roles SET libLectEstado = ? WHERE id_usuario_s= ?;";
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
                $actualizar = "UPDATE usuario_s_roles SET usuRolEstado = ? WHERE id_usuario_s= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];           }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB(); } }
  
    public function consultaPaginada($limit = null, $offset = null, $filtrarBuscar = "") {

        $planConsulta = "select SQL_CALC_FOUND_ROWS ur.id_usuario_s, u.usuId, u.usuLogin,r.rolId, r.rolNombre
                                  FROM ((usuario_s_roles ur LEFT JOIN usuario_s u ON ur.id_usuario_s=u.usuId)
                                  LEFT JOIN rol r ON ur.id_rol = r.rolId) ;";
        $planConsulta .= $filtrarBuscar;

        $planConsulta .= "  ORDER BY ur.id_usuario_s ASC";
        $planConsulta .= " LIMIT " . $limit . " OFFSET " . $offset . " ; ";

        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute();



        $planConsulta .= $filtrarBuscar;
        $planConsulta .= " ORDER BY ur.id_usuario_s ASC";
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

        $planConsulta = "SELECT count(*) as total from usuario_s_roles; ";

        $cantidadLibros = $this->conexion->prepare($planConsulta);
        $cantidadLibros->execute(); //Ejecución de la consulta 

        $totalRegistrosLibros = "";

        $totalRegistrosLibros = $cantidadLibros->fetch(PDO::FETCH_OBJ);

        $this->cierreDB();

        return $totalRegistrosLibros;
    }
}            ?>
