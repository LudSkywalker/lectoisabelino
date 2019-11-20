<?php

include_once PATH . "modelos/ConexDBMySQL.php";

class PersonaDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT p.perId,p.perDocumento,p.perNombre,p.perApellido,u.usuId,u.usuLogin 
                                  FROM (persona p LEFT JOIN usuario_s u ON p.usuario_s_usuId=u.usuId) ;";

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