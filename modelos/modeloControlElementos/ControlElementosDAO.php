<?php

include_once PATH . "modelos/ConexDBMySQL.php";

class ControlElementosDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT ce.conEId, ce.conEPrestado,pe.perId, pe.perDocumento, pe.perNombre, pe.perApellido, el.eleLecId,
                                  el.eleLecCodigo,cel.catEleId,cel.catEleNombre,
                                  ce.conEFechaSal,ce.conEFechaEnt,ce.conEFechaDev,ce.conEObsSalida,ce.conEObsEntrada
                                  FROM (((contr_elementos ce LEFT JOIN persona pe ON ce.persona_perId= pe.perId)
                                  LEFT JOIN elementos_lecto el ON ce.elementos_lecto_eleLecId= el.eleLecId)
                                  LEFT JOIN categoria_elementos cel ON el.categoria_elementos_catEleId= cel.catEleId); ";

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
         
            $conEFechaSal = $registro['conEFechaSal'];
            $conEFechaEnt = $registro['conEFechaEnt'];
            $conEFechaDev = $registro['conEFechaDev'];
            $conEPrestado = $registro['conEPrestado'];
            $conEObsSalida = $registro['conEObsSalida'];
            $conEObsEntrada = $registro['conEObsEntrada'];
            $personap_perId = $registro['persona_perId'];
            $elementos_lecto_eleLecId  = $registro['elementos_lecto_eleLecId'];

        try {
            $query = "INSERT INTO contr_elementos (conEFechaSal,conEFechaEnt,conEFechaDev,
                                conEPrestado,conEObsSalida, conEObsEntrada,persona_perId,elementos_lecto_eleLecId )
                               VALUES(?,?,?,?,?,?,?,?);";
            $inserta = $this->conexion->prepare($query);

            $inserta->execute(array($conEFechaSal,$conEFechaEnt,$conEFechaDev,$conEPrestado,$conEObsSalida,$conEObsEntrada,$personap_perId,$elementos_lecto_eleLecId));

            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();

            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {

            return ['inserto' => 0, 'resultado' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function seleccionarId($id = array()) {
        $planConsulta = "SELECT * FROM contr_elementos ce WHERE ce.conEId= ? ;";

        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($id[0]));

        $registroEncontrado = array();

        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;
        }

        $this->cierreDB();
        //Retorna si fue exitoso o no hallar el registro con la llave primaria y sus datos o vacÃ­o       
        if (!empty($registroEncontrado)) {
            return ['exitoSeleccionId' => 1, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => 0, 'registroEncontrado' => $registroEncontrado];
        }
    }

    public function actualizar($registro) {
        
        try {
            
            $conEFechaSal = $registro[0]['conEFechaSal'];
            $conEFechaEnt = $registro[0]['conEFechaEnt'];
            $conEFechaDev = $registro[0]['conEFechaDev'];
            $conEPrestado = $registro[0]['conEPrestado'];
            $conEObsSalida = $registro[0]['conEObsSalida'];
            $conEObsEntrada = $registro[0]['conEObsEntrada'];
            $persona_perId = $registro[0]['persona_perId'];
            $elementos_lecto_eleLecId = $registro[0]['elementos_lecto_eleLecId'];
            $conEId  = $registro[0]['conEId '];

            if (isset($conEId)) {
                $actualizar = "UPDATE contr_elementos SET 
                                             conEFechaSal= ?, conEFechaEnt= ? ,conEFechaDev= ?,
                                             conEPrestado= ?,conEObsSalida= ?,conEObsEntrada= ?,
                                             persona_perId= ?,elementos_lecto_eleLecId= ?
                                             WHERE conEId= ?";
                $actuali=$this->conexion->prepare($actualizar);
                $actualizacion =$actuali->execute(array($conEFechaSal, $conEFechaEnt, $conEFechaDev, $conEPrestado, $conEObsSalida,$conEObsEntrada,$persona_perId,$elementos_lecto_eleLecId,$conEId ));
                $actu= ['actualizacion' => $actualizacion, 'mensaje' => "Actualizacion realizada."];
                return $actu;
            }
        } catch (PDOException $pdoExc) {
            $act= ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
            return $act;
        } finally {
            $this->cierreDB();
        }
    }

    public function eliminar($id = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "DELETE from contr_elementos   
                                           WHERE conEId=:conEId; ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':conEId', $id[0], PDO::PARAM_INT);
        $resultado = $eliminar->execute();

        $this->cierreDB();

        if (!empty($resultado)) {
            return ['eliminar' => TRUE, 'registroEliminado' => array($id[0])];
        } else {
            return ['eliminar' => FALSE, 'registroEliminado' => array($id[0])];
        }
    }

    public function eliminarLogico($id = array()) {// Se deshabilita un registro cambiando su estado a 0
        try {
            $cambiarEstado = 0;

            if (isset($id[0])) {
                $actualizar = "UPDATE contr_elementos  SET conEEstado = ? WHERE conEId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualiza = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualiza, 'mensaje' => "Registro Inactivado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualiza, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function habilitar($id = array()) {// Se habilita un registro cambiando su estado a 1
        try {

            $cambiarEstado = 1;

            if (isset($id[0])) {
                $actualizar = "UPDATE contr_elementos  SET conEEstado = ? WHERE conEId= ?;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualiza = $actualizacion->execute(array($cambiarEstado, $id[0]));
                return ['actualizacion' => $actualiza, 'mensaje' => "Registro habilitado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualiza, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }


}

?>