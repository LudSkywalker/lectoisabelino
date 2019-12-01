<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloEstadoElementos/EstadoElementosDAO.php";

echo "    ";
$estEle=new EstadoElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$estEle->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';

?>