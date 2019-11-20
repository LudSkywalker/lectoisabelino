<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloUsuariosRol/UsuariosRolDAO.php";

echo "    ";
$usuRol=new UsuariosRolDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$usuRol->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>