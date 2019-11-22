<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloPersona/PersonaDAO.php";


$per=new PersonaDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);

////Select todos
//$listado=$per->seleccionarTodos();
//
//echo '<pre>';
//print_r($listado);
//echo '</pre>';

//Insert

$registro['perDocumento'] = "1000972050";
$registro['perNombre'] = "Lud" ;
$registro['perApellido'] = "Skywalker";


$insert = $per->insertar($registro);

echo '<pre>';
print_r($insert);
echo '</pre>';

////Select id
//$sId[0]="8888888";
//$sId[1]=null;
//
//$isd=$per->seleccionarId($sId);
//
//echo "<pre>";
//print_r($isd);
//echo "</pre>";

?>