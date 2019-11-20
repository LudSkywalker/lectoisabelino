<?php

include_once PATH . "modelos/ConexDBMySQL.php";

class UsuariosRolDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT ur.id_usuario_s,u.usuId, u.usuLogin,r.rolId, r.rolNombre 
                                  FROM ((usuario_s_roles ur LEFT JOIN usuario_s u ON ur.id_usuario_s=u.usuId)
                                  LEFT JOIN rol r ON ur.id_rol = r.rolId) ;";

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