<?php
include_once PATH."modelos/ConexDBMySQL.php";

class CategoriaElementosDao extends ConexDBMySQL {
    
    public function __construct($servidor, $base, $loginDB, $passwordDB) {
        
        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }
     
    public function seleccionarTodos(){
        
        $consulta="SELECT cel.catEleId, cel.catEleNombre, cel.catEleDescri FROM categoria_elementos cel";
        
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