<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloCategoriaLibrosLecto/CategoriaLibrosLectoDAO.php";

echo "    ";
$catLibLec=new CategoriaLibrosLectoDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$catLibLec->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>