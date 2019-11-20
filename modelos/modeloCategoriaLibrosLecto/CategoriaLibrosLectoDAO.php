<?php

include_once PATH.".../ConexDBMySQL.php";

class CategoriaLibrosLectoDao extends ConexDBMySQL {
    
    public function __construct($servidor, $base, $loginDB, $passwordDB) {
        
        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }
     
    public function seleccionarTodos(){
        
        $consulta="SELECT cll.catLecId, cll.catLecNombre, cll.catLecDescri FROM categoria_libro_lecto cll";
        
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