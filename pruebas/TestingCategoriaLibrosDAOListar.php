<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloCategoriaLibro/CategoriaLibrosDAO.php";


$catlib=new CategoriaLibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$catlib->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>