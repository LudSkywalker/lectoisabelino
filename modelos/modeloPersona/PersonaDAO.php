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

            $inserta = $this->conexion->prepare('INSERT INTO persona ( perDocumento, perNombre, perApellido) VALUES ( :perId, :perDocumento, :perNombre, :perApellido );');
            $inserta->bindParam(":perDocumento", $registro['perDocumento']);
            $inserta->bindParam(":perNombre", $registro['perNombre']);
            $inserta->bindParam(":perApellido", $registro['perApellido']);
            $execute = $inserta->execute();
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
            return ['exitoSeleccionId' => 1, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => 0, 'registroEncontrado' => $registroEncontrado];
        }
    }

}

?>