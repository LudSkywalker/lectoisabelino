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
        }

        $this->cierreDB();
        return $listado;
    }

}

?>