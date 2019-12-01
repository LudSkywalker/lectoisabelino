<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloElementos/ElementosDAO.php";

echo "    ";
$ele=new ElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$ele->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>