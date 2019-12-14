<?php
include_once PATH . "modelos/ConexDBMySQL.php";
class LibrosLectoDao extends ConexDBMySQL {
    public function __construct($servidor, $base, $loginDB, $passwordDB) {
        parent::__construct($servidor, $base, $loginDB, $passwordDB);}
    public function seleccionarTodos() {
        $consulta = "SELECT ll.libLecId, ll.libLecCodigo, ll.libLecTitulo, ll.libLecAutor,cll.catLecId, cll.catLecNombre,el.estLibId, el.estLibNombre, 
                                  ll.libLecEstado 
                                  FROM ((libros_lecto ll Left JOIN categoria_libro_lecto cll ON ll.categoria_libro_lecto_catLecId=cll.catLecId)
                                  LEFT JOIN estado_libros el ON ll.estado_libros_estLibId=el.estLibId);";
        $registrar = $this->conexion->prepare($consulta);
        $registrar->execute();
        $listado = array();
        while ($regis = $registrar->fetch(PDO::FETCH_OBJ)) {
            $listado[] = $regis;}
        $this->cierreDB();
        return $listado;}
    public function insertar ($registro) {
        try {
            $query = "INSERT INTO libros_lecto";
            $query .= "(libLecId, libLecCodigo, libLecTitulo, libLecAutor,estado_libros_estLibId) ";
            $query .= " VALUES";
            $query .= "(:libLecId , :libLecCodigo , :libLecTitulo , :libLecAutor , :estado_libros_estLibId ); ";
            $inserta = $this->conexion->prepare($query);
            $inserta->bindParam(":libLecId", $registro['libLecId']);
            $inserta->bindParam(":libLecCodigo", $registro['libLecCodigo']);
            $inserta->bindParam(":libLecTitulo", $registro['libLecTitulo']);
            $inserta->bindParam(":libLecAutor", $registro['libLecAutor']);
            $inserta->bindParam(":estado_libros_estLibId", $registro['estado_libros_estLibId']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();
            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];}}
    public function seleccionarId($libLecId = array()) {
        $planConsulta = "select * from libros_lecto ll ";
        $planConsulta .= " where ll.libLecId= ? ;";

        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($libLecId[0]));
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
            $libLecCodigo = $registro[0]['libLecCodigo'];
            $libLecTitulo = $registro[0]['libLecTitulo'];
            $libLecAutor = $registro[0]['libLecAutor'];
            $estado_libros_estLibId = $registro[0]['estado_libros_estLibId'];
            $libLecId = $registro[0]['libLecId'];
            if (isset($libLecId)) { 
                $actualizar = "UPDATE libros_lecto SET libLecCodigo = ? , ";
                $actualizar .= " libLecTitulo = ? , ";
                $actualizar .= " libLecAutor = ? , ";
                $actualizar .= " estado_libros_estLibId = ? ";
                $actualizar .= " WHERE libLecId= ? ; ";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($libLecCodigo, $libLecTitulo, $libLecAutor, $estado_libros_estLibId, $libLecId));
                $actu= ['actualizacion' => $actualizacion, 'mensaje' => "Actualización realizada."];
                return $actu;            }
        } catch (PDOException $pdoExc) {
            $act= ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
             return $act;
        }  finally {
            $this-> cierreDB();        }}

    public function eliminar($id = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "DELETE from libros_lecto  
                                           WHERE libLecId=:libLecId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':libLecId', $id[0], PDO::PARAM_INT);
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
                $actualizar = "UPDATE libros_lecto SET libLecEstado= ? WHERE libLecId= ?;";
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
                $actualizar = "UPDATE libros_lecto SET libLecEstado = ? WHERE libLecId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];           }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }
    public function consultaPaginada($limit = null, $offset = null, $filtrarBuscar = "") {


        $planConsulta = "select SQL_CALC_FOUND_ROWS ll.libLecId, ll.libLecCodigo, ll.libLecTitulo, ll.libLecAutor,
                         cll.catLecId, cll.catLecNombre, el.estLibId, el.estLibNombre,ll.libLecEstado 
                         FROM ((libros_lecto ll LEFT JOIN  categoria_libro_lecto cll ON ll.categoria_libro_lecto_catLecId= cll.catLecId)

                       LEFT JOIN  estado_libros el ON ll.estado_libros_estLibId = el.estLibId)";

        $planConsulta.= $filtrarBuscar;

        $planConsulta.= "  ORDER BY ll.libLecId ASC";
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
    }

    public function totalRegistros() {

        $planConsulta = "SELECT count(*) as total from libros_lecto; ";

        $cantidadLibros = $this->conexion->prepare($planConsulta);
        $cantidadLibros->execute(); //Ejecución de la consulta 

        $totalRegistrosLibros = "";

        $totalRegistrosLibros = $cantidadLibros->fetch(PDO::FETCH_OBJ);

        $this->cierreDB();

        return $totalRegistrosLibros;
    }
}            ?>
