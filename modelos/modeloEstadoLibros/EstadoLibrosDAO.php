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
    
    
    
} 




?>