<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloRol/RolDAO.php";

echo "    ";
$rol=new RolDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$rol->seleccionarTodos();



echo '<pre>';
print_r($listado);
echo '</pre>';
$registro['conEFechaSal'] = '2019-06-06 15:02:04';
$registro['conEFechaEnt'] = '2019-06-07 15:02:04';
$registro['conEFechaDev'] = NULL ;
$registro['conEPrestado'] = 1;
$registro['conEObsSalida'] = 'Excelente Estado';
$registro['conEObsEntrada'] = 'Buen Estado';
$registro['persona_perId'] = 2;
$registro['elementos_lecto_rolId'] = 6;

$insert = $rol->insertar($registro);

echo '<pre>';
//print_r($insert);
echo '</pre>';

//--> SELECCIONAR ID
$id=array( 11 );

$isd=$rol->seleccionarId($id);
echo "<pre>";
//print_r($isd);
echo "</pre>";
////--->UPDATE
            $rolNombre= $registro[0]['rolNombre']= "LBGO_09" ;
            $rolDescripcion= $registro[0]['rolDescripcion']= "El tunel" ;
            $rolEstado= $registro[0]['rolEstado']=  "Ernesto Sabato" ;
            $up=$rol->actualizar($registro);
echo "<pre>";
//print_r($up);
echo "</pre>";
///-->eliminar
$id= array (11);
$isd= $rol-> eliminar($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--> eliminar logico
$id= array (11);
$isd= $rol->eliminarLogico($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--->habilitar logicos
$id= array(11);
$isd=$rol->habilitar($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

$id=[6,0];
$isd=$rol->consultaPaginada($id[0],$id[1]);
echo"<pre>";
print_r($isd);
echo"</pre>";

//coutn
$cu=$rol->totalRegistros();        
echo "<pre>";
print_r($cu);
echo "</pre>";

?>