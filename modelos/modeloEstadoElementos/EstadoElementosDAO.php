<?php
include_once PATH."modelos/ConexDBMySQL.php";

class EstadoElementosDao extends ConexDBMySQL {
    
    public function __construct($servidor, $base, $loginDB, $passwordDB) {
        
        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }
     
    public function seleccionarTodos(){
        
        $consulta="SELECT ee.estEleId, ee.estEleNombre, ee.estEleObs FROM estado_elementos ee";
        
        $registrar= $this->conexion->prepare($consulta);
        $registrar->execute();
        
        $listado=array();
        while ($regis=$registrar->fetch(PDO::FETCH_OBJ)){
            $listado[]=$regis;
        }
        
        $this->cierreDB();
        return $listado;
    }
        public function insertar ($registro){
        try {
            $query = "INSERT INTO estado_elementos";
            $query .= "(estEleId, estEleNombre, estEleObs) ";
            $query .= " VALUES";
            $query .= "(:estEleId, :estEleNombre, :estEleObs); ";
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":estEleId", $registro['estEleId']);
            $inserta->bindParam(":estEleNombre", $registro['estEleNombre']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];}}
         public function seleccionarId($estEleId = array()) {
        $planConsulta = "SELECT * FROM  estado_elementos";
        $planConsulta .= " where ee.estEleId= ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($estEleId[0]));
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
            $estEleNombre= $registro[0]['estEleNombre'];
            $estEleObs= $registro[0]['estEleObs'];
            $estEleEstado= $registro[0]['estEleEstado'];
            if (isset($estEleId)) { 
                $actualizar = "UPDATE estado_elementos SET estEleNombre = ? , ";
                $actualizar .= " estEleObs = ? , ";
                $actualizar .= " WHERE estEleEstado= ? ; ";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($estEleId, $estEleNombre, $estEleObs));
                $actu= ['actualizacion' => $actualizacion, 'mensaje' => "Actualización realizada."];
                return $actu;            }
        } catch (PDOException $pdoExc) {
            $act= ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
             return $act;
        }  finally {
            $this-> cierreDB();        }}
            public function eliminar($id = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "DELETE from estado_elementos  
                                           WHERE estEleId=:estEleId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':estEleId', $id[0], PDO::PARAM_INT);
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
                $actualizar = "UPDATE estado_libros SET estEleNombre = ? WHERE estEleId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];           }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB(); } }
    }
    
    
    





?>