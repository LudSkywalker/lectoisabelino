<?php


include_once PATH . "modelos/ConexDBMySQL.php";

class ElementosDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT el.eleLecId,el.eleLecCodigo,ce.catEleId, ce.catEleNombre,ee.estEleId, ee.estEleNombre 
                                  FROM ((elementos_lecto el Left JOIN categoria_elementos ce ON  el.categoria_elementos_catEleId= ce.catEleId)
                                  LEFT JOIN estado_elementos ee ON el.estado_elementos_estEleId=ee.estEleId); ";

        $registrar = $this->conexion->prepare($consulta);
        $registrar->execute();

        $listado = array();
        while ($regis = $registrar->fetch(PDO::FETCH_OBJ)) {
            $listado[] = $regis;
        }        $this->cierreDB();
                 return $listado;}
    public function insertar ($registro) {
        try {
            $query = "INSERT INTO elementos_lecto";
            $query .= "(eleLecId, eleLecCodigo, eleLecEstado, estado_elementos_estEleId, categoria_elementos_catEleId) ";
            $query .= " VALUES";
            $query .= "(:eleLecId, :eleLecCodigo, :eleLecEstado, :estado_elementos_estEleId, :categoria_elementos_catEleId); ";
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":eleLecId", $registro['eleLecId']);
            $inserta->bindParam(":eleLecCodigo", $registro['eleLecCodigo']);
            $inserta->bindParam(":eleLecEstado", $registro['eleLecEstado']);
            $inserta->bindParam(":estado_elementos_estEleId", $registro['estado_elementos_estEleId']);
            $inserta->bindParam(":categoria_elementos_catEleId", $registro['categoria_elementos_catEleId']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];}}
    public function seleccionarId($eleLecId = array()) {
        $planConsulta = "select * from elementos_lecto el ";
        $planConsulta .= " where el.eleLecId= ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($eleLecId[0]));
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
            $eleLecCodigo = $registro[0]['eleLecCodigo'];
            $eleLecEstado = $registro[0]['eleLecEstado'];
            $estado_elementos_estEleId = $registro[0]['estado_elementos_estEleId'];
            $categoria_elementos_catEleId = $registro[0]['categoria_elementos_catEleId'];
            $eleLecId = $registro[0]['eleLecId'];
            if (isset($eleLecId)) { 
                $actualizar = "UPDATE elementos_lecto SET eleLecCodigo = ? , ";
                $actualizar .= " eleLecEstado = ? , ";
                $actualizar .= " estado_elementos_estEleId = ? , ";
                $actualizar .= " categoria_elementos_catEleId = ? ";
                $actualizar .= " WHERE eleLecId= ? ; ";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($eleLecCodigo, $eleLecEstado, $estado_elementos_estEleId, $categoria_elementos_catEleId, $eleLecId));
                $actu= ['actualizacion' => $actualizacion, 'mensaje' => "Actualización realizada."];
                return $actu;            }
        } catch (PDOException $pdoExc) {
            $act= ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
             return $act;
        }  finally {
            $this-> cierreDB();        }}
    public function eliminar($id = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "DELETE from elementos_lecto  
                                           WHERE eleLecId=:eleLecId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':eleLecId', $id[0], PDO::PARAM_INT);
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
                $actualizar = "UPDATE elementos_lecto SET libLectEstado = ? WHERE eleLecId= ?;";
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
                $actualizar = "UPDATE elementos_lecto SET eleLecEstado = ? WHERE eleLecId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];           }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB(); } }
 
    public function consultaPaginada($limit = null, $offset = null, $filtrarBuscar ="") {
        $planConsulta = "SELECT SQL_CALC_FOUND_ROWS el.eleLecId, el.eleLecCodigo, ce.catEleId, ce.catEleNombre, ee.estEleId, ee.estEleNombre 
                                FROM ((elementos_lecto el Left JOIN categoria_elementos ce ON  el.categoria_elementos_catEleId= ce.catEleId)
                                LEFT JOIN estado_elementos ee ON el.estado_elementos_estEleId=ee.estEleId)";

        $planConsulta .= $filtrarBuscar;

        $planConsulta .= "  ORDER BY el.eleLecId ASC ";
        $planConsulta .= " LIMIT ".$limit." OFFSET ".$offset." ; ";
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

        $planConsulta = "SELECT count(*) as total from elementos_lecto; ";

        $cantidadLibros = $this->conexion->prepare($planConsulta);
        $cantidadLibros->execute(); //Ejecución de la consulta 

        $totalRegistrosLibros = "";

        $totalRegistrosLibros = $cantidadLibros->fetch(PDO::FETCH_OBJ);

        $this->cierreDB();

        return $totalRegistrosLibros;
    }
        }
?>