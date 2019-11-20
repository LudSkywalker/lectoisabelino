<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloCategoriaElementos/CategoriaElementosDAO.php";

echo "    ";
$catEle=new CategoriaElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$catEle->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>