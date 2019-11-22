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

    public function insertar($registro) {

        try {

            $inserta = $this->conexion->prepare('INSERT INTO persona (perId, perDocumento, perNombre, perApellido, usuario_s_usuId) VALUES ( :perId, :perDocumento, :perNombre, :perApellido, :usuario_s_usuId );');
            $inserta->bindParam(":perId", $registro['perId']);
            $inserta->bindParam(":perDocumento", $registro['documento']);
            $inserta->bindParam(":perNombre", $registro['nombre']);
            $inserta->bindParam(":perApellido", $registro['apellidos']);
            $inserta->bindParam(":perApellido", $registro['apellidos']);
            $inserta->bindParam(":usuario_s_usuId", $registro['perId']);
            $insercion = $inserta->execute();
            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();

            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {
            return ['inserto' => 0, 'resultado' => $pdoExc];
        }
    }

    public function seleccionarId($sId) {


        $planConsulta = "select * from persona p join usuario_s u on p.perId=u.usuId ";
        $planConsulta .= " where p.perDocumento= ? or u.usuLogin = ? ;";
        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0], $sId[1]));

        $registroEncontrado = array();
        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;
        }

        if ($registro != FALSE) {
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => FALSE, 'registroEncontrado' => $registroEncontrado];
        }
    }

}

?>