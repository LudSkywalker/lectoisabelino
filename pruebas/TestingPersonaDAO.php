<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloPersona/PersonaDAO.php";

echo "    ";
$per=new PersonaDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$per->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>