<?php
include_once PATH."modelos/ConexDBMySQL.php";

class EstadoLibrosDao extends ConexDBMySQL {
    
    public function __construct($servidor, $base, $loginDB, $passwordDB) {
        
        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }
     
    public function seleccionarTodos(){
        
        $consulta="select el.estLibId, el.estLibNombre, el.estLibObs FROM estado_libros el;";
        
        $registrar= $this->conexion->prepare($consulta);
        $registrar->execute();
        
        $listado=array();
        while ($regis=$registrar->fetch(PDO::FETCH_OBJ)){
            $listado[]=$regis;
        }
        
        $this->cierreDB();
        return $listado;
    }
    public function insertar ($registro) {
        try {
            $query = "INSERT INTO estados_libro";
            $query .= "(estLibId, estLibNombre,estLibObs) ";
            $query .= " VALUES";
            $query .= "(:estLibId,:estLibNombre,:estLibObs); ";
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":estLibId", $registro['eleLecId']);
            $inserta->bindParam(":estLibNombre", $registro['eleLecCodigo']);
            $inserta->bindParam(":estLibObs", $registro['eleLecEstado']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];}}
     public function seleccionarId($estLibId = array()) {
        $planConsulta = "SELECT * FROM  estado_libros";
        $planConsulta .= " where el.estLibId= ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($estLibId[0]));
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
            $estLibNombre = $registro[0]['estLibNombre'];
            $estLibObs = $registro[0]['estLibObs'];
            $estLibEstado= $registro[0]['estLibEstado'];
            if (isset($estEleId)) { 
                $actualizar = "UPDATE estado_libros SET estLibNombre = ? , ";
                $actualizar .= " estLibObs = ? , ";
                $actualizar .= " WHERE estLibEstado= ? ; ";
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
        $planConsulta = "DELETE from estado_libros  
                                           WHERE estLibId=:estLibId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':estLibId', $id[0], PDO::PARAM_INT);
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
                $actualizar = "UPDATE estado_libros SET estLibNombre = ? WHERE estLibId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];           }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB(); } }
    
    
}

?>