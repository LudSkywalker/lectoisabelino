<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloUsuarios/UsuariosDAO.php";

echo "    ";
$usu=new UsuariosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$usu->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>