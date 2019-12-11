<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloEstadoLibros/EstadoLibrosDAO.php";

echo "    ";
$estLib=new EstadoLibrosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$estLib->seleccionarTodos();



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
$registro['elementos_lecto_estLibId'] = 6;

$insert = $estLib->insertar($registro);

echo '<pre>';
//print_r($insert);
echo '</pre>';

//--> SELECCIONAR ID
$id=array( 11 );

$isd=$estLib->seleccionarId($id);
echo "<pre>";
//print_r($isd);
echo "</pre>";
////--->UPDATE
            $estLibNombre = $registro[0]['estLibNombre']= "LBGO_09" ;
            $estLibObs = $registro[0]['estLibObs']= "El tunel" ;
            $estLibEstado= $registro[0]['estLibEstado']=  "Ernesto Sabato" ;
            $up=$estLib->actualizar($registro);
echo "<pre>";
//print_r($up);
echo "</pre>";
///-->eliminar
$id= array (11);
$isd= $estLib-> eliminar($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--> eliminar logico
$id= array (11);
$isd= $estLib->eliminarLogico($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--->habilitar logicos
$id= array(11);
$isd=$estLib->habilitar($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

$id=[6,0];
$isd=$estLib->consultaPaginada($id[0],$id[1]);
echo"<pre>";
print_r($isd);
echo"</pre>";

//coutn
$cu=$estLib->totalRegistros();        
echo "<pre>";
print_r($cu);
echo "</pre>";

?>