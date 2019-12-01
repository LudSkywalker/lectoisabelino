<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloEstadoLibros/EstadoLibrosDAO.php";

echo "    ";
$estLib=new EstadoLibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$estLib->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>