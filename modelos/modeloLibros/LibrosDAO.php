<?php

include_once PATH . "modelos/ConexDBMySQL.php";

class LibrosDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT li.isbn, li.titulo, li.autor, li.precio,cl.catLibId, cl.catLibNombre FROM (libros li Left JOIN categorialibro cl 
                                  ON li.categoriaLibro_catLibId=cl.catLibId)";

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
            $query = "INSERT INTO libros";
            $query .= "(isbn, titulo, autor, precio, categoriaLibro_catLibId) ";
            $query .= " VALUES";
            $query .= "(:isbn , :titulo , :autor , :precio , :categoriaLibro_catLibId ); ";
            $inserta = $this->conexion->prepare($query);

            $inserta->bindParam(":isbn", $registro['isbn']);
            $inserta->bindParam(":titulo", $registro['titulo']);
            $inserta->bindParam(":autor", $registro['autor']);
            $inserta->bindParam(":precio", $registro['precio']);
            $inserta->bindParam(":categoriaLibro_catLibId", $registro['categoriaLibro_catLibId']);

            $insercion = $inserta->execute();

            $clavePrimariaConQueInserto = $this->conexion->lastInsertId();

            return ['inserto' => 1, 'resultado' => $clavePrimariaConQueInserto];
        } catch (PDOException $pdoExc) {

            return ['inserto' => 0, 'resultado' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function seleccionarId($sId = array()) {
        $planConsulta = "select * from libros l ";
        $planConsulta .= " where l.isbn= ? ;";

        $listar = $this->conexion->prepare($planConsulta);
        $listar->execute(array($sId[0]));

        $registroEncontrado = array();

        while ($registro = $listar->fetch(PDO::FETCH_OBJ)) {
            $registroEncontrado[] = $registro;
        }
        $this->cierreDB();

        //Retorna si fue exitoso o no hallar el registro con la llave primaria y sus datos o vacÃ­o       
        if (!empty($registroEncontrado)) {
            return ['exitoSeleccionId' => TRUE, 'registroEncontrado' => $registroEncontrado];
        } else {
            return ['exitoSeleccionId' => FALSE, 'registroEncontrado' => $registroEncontrado];
        }
        $this->cierreDB();
    }

    public function actualizar($registro) {
        try {
            $autor = $registro[0]['autor'];
            $titulo = $registro[0]['titulo'];
            $precio = $registro[0]['precio'];
            $categoria = $registro[0]['categoriaLibro_catLibId'];
            $isbn = $registro[0]['isbn'];

            if (isset($isbn)) {
                $actualizar = "UPDATE libros SET autor= ? , ";
                $actualizar .= " titulo = ? , ";
                $actualizar .= " precio = ? , ";
                $actualizar .= " categoriaLibro_catLibId = ? ";
                $actualizar .= " WHERE isbn= ? ; ";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($autor, $titulo, $precio, $categoria, $isbn));
                return ['actualizacion' => $actualizacion, 'mensaje' => "ActualizaciÃ³n realizada."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function eliminar($sId = array()) {//Recibe llave primaria a eliminar
        $planConsulta = "delete from libros ";
        $planConsulta .= " where isbn= :isbn ;";
        $eliminar = $this->conexion->prepare($planConsulta);
        $eliminar->bindParam(':isbn', $sId[0], PDO::PARAM_INT);
        $resultado = $eliminar->execute();

        $this->cierreDB();

        if (!empty($resultado)) {
            return ['eliminar' => TRUE, 'registroEliminado' => array($sId[0])];
        } else {
            return ['eliminar' => FALSE, 'registroEliminado' => array($sId[0])];
        }
        $this->cierreDB();
    }

    public function eliminarLogico($sId = array()) {// Se deshabilita un registro cambiando su estado a 0
        try {
            $cambiarEstado = 0;

            if (isset($sId[0])) {
                $actualizar = "UPDATE libros SET estado = ? WHERE isbn= ? ;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $sId[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro Inactivado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

    public function habilitar($sId = array()) {// Se habilita un registro cambiando su estado a 1
        try {

            $cambiarEstado = 1;

            if (isset($sId[0])) {
                $actualizar = "UPDATE libros SET estado = ? WHERE isbn= ? ;";
                $actualizacion = $this->conexion->prepare($actualizar);
                $actualizacion = $actualizacion->execute(array($cambiarEstado, $sId[0]));
                return ['actualizacion' => $actualizacion, 'mensaje' => "Registro habilitado."];
            }
        } catch (PDOException $pdoExc) {
            return ['actualizacion' => $actualizacion, 'mensaje' => $pdoExc];
        } finally {
            $this->cierreDB();
        }
    }

}

?>