<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloRol/RolDAO.php";

echo "    ";
$rol=new RolDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$rol->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>