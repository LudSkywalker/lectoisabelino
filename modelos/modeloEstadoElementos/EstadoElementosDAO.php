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
        public function insertar($registro) {
        try {
            $query = "INSERT INTO estado_elementos";
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
        
    }
    
    
    
} 




?>