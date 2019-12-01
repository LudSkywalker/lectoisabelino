<?php

include_once PATH . "modelos/ConexDBMySQL.php";

class RolDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = " SELECT r.rolId, r.rolNombre, r.rolDescripcion FROM rol r;";

        $registrar = $this->conexion->prepare($consulta);
        $registrar->execute();

        $listado = array();
        while ($regis = $registrar->fetch(PDO::FETCH_OBJ)) {
            $listado[] = $regis;
        }

        $this->cierreDB();
        return $listado;
    }
   public function seleccionarRolPorPersona($sId) {//llega como parametro un array con datos a consultar
         
        $planConsulta = "select r.rolId,r.rolNombre,r.rolDescripcion ";
        $planConsulta .= " from ((rol r join usuario_s_roles ur on r.rolId=ur.id_rol) ";
        $planConsulta .= " join usuario_s u on u.usuId=ur.id_usuario_s) ";
        $planConsulta .= " right join persona p on p.usuario_s_usuId=ur.id_usuario_s ";
        $planConsulta .= " where p.perDocumento = ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0]));

        $registroEncontrado = array();
        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;
        }
        if (isset($registroEncontrado[0]->usuId) && $registroEncontrado[0]->usuId != FALSE) {
            return ['exitoSeleccionId' => 1, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => 0, 'registroEncontrado' => $registroEncontrado];
        }
    }
}

?>