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
//
////Insert
//
//$registro['perDocumento'] = 1000972050;
//$registro['usuario_s_usuId'] = 11;
//$registro['perNombre'] = "Lud" ;
//$registro['perApellido'] = "Skywalker";
//
//
//$insert = $per->insertar($registro);
//
//echo '<pre>';
//print_r($insert);
//echo '</pre>';
//
////Select id
//$sId[0]="1234";
//$sId[1]=null;
//
//$isd=$per->seleccionarId($sId);
//
//echo "<pre>";
//print_r($isd);
//echo "</pre>";
//
////Update
//$registro[0]['perDocumento'] =1000972050;
//$registro[0]['perNombre'] = 'Luding';
//$registro[0]['perApellido'] = "Skywalker" ;
//$registro[0]['usuario_s_usuId'] =10;
//
//$up=$per->actualizar($registro);
//
//echo "<pre>";
//print_r($up);
//echo "</pre>";
//
////Delete
//$sid=array(11);
//
//$del=$per->eliminar($sid);
//
//echo "<pre>";
//print_r($del);
//echo "</pre>";
//
////Delete logic
//$dell=array(9);
//
//
//$deletelog=$per->eliminarLogico($dell);
//
//echo "<pre>";
//print_r($deletelog);
//echo "</pre>";
//
////Delete logico habilitar
//$hab=array(9);
//
//$hablog=$per->habilitar($hab);
//
//echo "<pre>";
//print_r($hablog);
//echo "</pre>";

//Query pag
$pag=$per->consultaPaginada(5,0);
echo "<pre>";
print_r($pag);
echo "</pre>";

//coutn
$cu=$per->totalRegistros();        
echo "<pre>";
print_r($cu);
echo "</pre>";

?>