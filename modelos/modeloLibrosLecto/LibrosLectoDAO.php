<?php
include_once PATH . "modelos/ConexDBMySQL.php";

class LibrosLectoDao extends ConexDBMySQL {

    public function __construct($servidor, $base, $loginDB, $passwordDB) {

        parent::__construct($servidor, $base, $loginDB, $passwordDB);
    }

    public function seleccionarTodos() {

        $consulta = "SELECT ll.libLecId, ll.libLecCodigo, ll.libLecTitulo, ll.libLecAutor,cll.catLecId, cll.catLecNombre,el.estLibId, el.estLibNombre 
                                  FROM ((libros_lecto ll Left JOIN categoria_libro_lecto cll ON ll.categoria_libro_lecto_catLecId=cll.catLecId)
                                  LEFT JOIN estado_libros el ON ll.estado_libros_estLibId=el.estLibId);";

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