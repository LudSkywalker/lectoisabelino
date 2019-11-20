<?php

include_once PATH . "modelos/ConexDBMySQL.php";

class ControlPrestamoLibrosDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT cpl.conPId, cpl.conPPrestado,pe.perId, pe.perDocumento, pe.perNombre, pe.perApellido,
                                  ll.libLecId, ll.libLecCodigo,ll.libLecTitulo,
                                  cpl.conPFechaSal,cpl.conPFechaEnt,cpl.conPFechaDev,cpl.conPObsSalida,cpl.conPObsEntrada 
                                  FROM ((contr_prestamos_libros cpl LEFT JOIN persona pe ON cpl.persona_perId= pe.perId )
                                  LEFT JOIN libros_lecto ll ON cpl.libros_lecto_libLecId= ll.libLecId); ";

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
         
            $conPFechaSal = $registro['conPFechaSal'];
            $conPFechaEnt = $registro['conPFechaEnt'];
            $conPFechaDev = $registro['conPFechaDev'];
            $conPPrestado = $registro['conPPrestado'];
            $conPObsSalida = $registro['conPObsSalida'];
            $conPObsEntrada = $registro['conPObsEntrada'];
            $personap_perId = $registro['persona_perId'];
            $libros_lecto_libLecId = $registro['libros_lecto_libLecId'];

        try {
            $query = "INSERT INTO contr_prestamos_libros 
                                (conPFechaSal,conPFechaEnt,conPFechaDev,conPPrestado,conPObsSalida,conPObsEntrada,persona_perId,libros_lecto_libLecId)
                                VALUES (?,?,?,?,?,?,?,?)";
            $inserta = $this->conexion->prepare($query);

            $inserta->execute(array($conPFechaSal,$conPFechaEnt,$conPFechaDev,$conPPrestado,$conPObsSalida,$conPObsEntrada,$personap_perId,$libros_lecto_libLecId));

            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();

            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {

            return ['inserto' => 0, 'resultado' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function seleccionarId($id = array()) {
        $planConsulta = "SELECT * FROM contr_prestamos_libros cpl WHERE cpl.conPId= ?  ";

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
            
            $conPFechaSal = $registro[0]['conPFechaSal'];
            $conPFechaEnt = $registro[0]['conPFechaEnt'];
            $conPFechaDev = $registro[0]['conPFechaDev'];
            $conPPrestado = $registro[0]['conPPrestado'];
            $conPObsSalida = $registro[0]['conPObsSalida'];
            $conPObsEntrada = $registro[0]['conPObsEntrada'];
            $persona_perId = $registro[0]['persona_perId'];
            $libros_lecto_libLecId = $registro[0]['libros_lecto_libLecId'];
            $conPId  = $registro[0]['conPId '];

            if (isset($conPId)) {
                $actualizar = "UPDATE contr_prestamos_libros  SET 
                                             conPFechaSal= ?, conPFechaEnt= ? ,conPFechaDev= ?,
                                             conPPrestado= ?,conPObsSalida= ?,conPObsEntrada= ?,
                                             persona_perId= ?,libros_lecto_libLecId= ?
                                             WHERE conPId= ?";
                $actuali=$this->conexion->prepare($actualizar);
                $actualizacion =$actuali->execute(array($conPFechaSal, $conPFechaEnt, $conPFechaDev, $conPPrestado, $conPObsSalida,$conPObsEntrada,$persona_perId,$libros_lecto_libLecId,$conPId ));
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
        $planConsulta = "DELETE from contr_prestamos_libros   
                                           WHERE conPId=:conPId ";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':conPId', $id[0], PDO::PARAM_INT);
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
                $actualizar = "UPDATE contr_prestamos_libros  SET conPEstado = ? WHERE conPId= ?;";
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
                $actualizar = "UPDATE contr_prestamos_libros  SET conPEstado = ? WHERE conPId= ?;";
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