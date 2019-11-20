<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloLibrosLecto/LibrosLectoDAO.php";

echo "    ";
$libLec=new LibrosLectoDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$libLec->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>