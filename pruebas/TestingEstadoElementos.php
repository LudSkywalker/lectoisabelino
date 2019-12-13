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
$registro['conEFechaSal'] = '2019-06-06 15:02:04';
$registro['conEFechaEnt'] = '2019-06-07 15:02:04';
$registro['conEFechaDev'] = NULL ;
$registro['conEPrestado'] = 1;
$registro['conEObsSalida'] = 'Excelente Estado';
$registro['conEObsEntrada'] = 'Buen Estado';
$registro['persona_perId'] = 2;
$registro['elementos_lecto_estEleId'] = 6;

$insert = $estEle->insertar($registro);

echo '<pre>';
//print_r($insert);
echo '</pre>';

//--> SELECCIONAR ID
$id=array( 11 );

$isd=$estEle->seleccionarId($id);
echo "<pre>";
//print_r($isd);
echo "</pre>";
////--->UPDATE
            $estEleNombre= $registro[0]['estEleNombre']= "LBGO_09" ;
            $estEleObs= $registro[0]['estEleObs']= "El tunel" ;
            $estEleEstado= $registro[0]['estEleEstado']=  "Ernesto Sabato" ;
            $up=$estEle->actualizar($registro);
echo "<pre>";
//print_r($up);
echo "</pre>";
///-->eliminar
$id= array (11);
$isd= $estEle-> eliminar($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--> eliminar logico
$id= array (11);
$isd= $estEle->eliminarLogico($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--->habilitar logicos
$id= array(11);
$isd=$estEle->habilitar($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

$id=[6,0];
$isd=$estEle->consultaPaginada($id[0],$id[1]);
echo"<pre>";
print_r($isd);
echo"</pre>";

//coutn
$cu=$estEle->totalRegistros();        
echo "<pre>";
print_r($cu);
echo "</pre>";

?>