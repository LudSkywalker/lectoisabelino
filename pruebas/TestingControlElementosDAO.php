
<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloControlElementos/ControlElementosDAO.php";

echo "    ";
$conEle=new ControlElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);

//Select todos
$listado=$conEle->seleccionarTodos();

echo '<pre>';
print_r($listado);
echo '</pre>';


//Insert

$registro['conEFechaSal'] = '2019-06-06 15:02:04';
$registro['conEFechaEnt'] = '2019-06-07 15:02:04';
$registro['conEFechaDev'] = NULL ;
$registro['conEPrestado'] = 1;
$registro['conEObsSalida'] = 'Excelente Estado';
$registro['conEObsEntrada'] = 'Buen Estado';
$registro['persona_perId'] = 2;
$registro['elementos_lecto_eleLecId'] = 6;

$insert = $conEle->insertar($registro);

echo '<pre>';
print_r($insert);
echo '</pre>';

//Select id
$id=array( 11 );

$isd=$conEle->seleccionarId($id);

echo "<pre>";
print_r($isd);
echo "</pre>";

//Update
$registro[0]['conEFechaSal'] = '2019-06-06 15:02:04';
$registro[0]['conEFechaEnt'] = '2019-06-07 15:02:04';
$registro[0]['conEFechaDev'] = '2019-05-07 15:02:04' ;
$registro[0]['conEPrestado'] = 1;
$registro[0]['conEObsSalida'] = 'Excelente Estado';
$registro[0]['conEObsEntrada'] = 'Buen Estado';
$registro[0]['persona_perId'] = 2;
$registro[0]['elementos_lecto_eleLecId'] = 6;
$registro[0]['conEId ']=11;

$up=$conEle->actualizar($registro);

echo "<pre>";
print_r($up);
echo "</pre>";

//Delete
$sid=array(11);

$del=$conEle->eliminar($sid);

echo "<pre>";
print_r($del);
echo "</pre>";

//Delete logic
$dell=array(10);


$deletelog=$conEle->eliminarLogico($dell);

echo "<pre>";
print_r($deletelog);
echo "</pre>";

//Delete logico habilitar
$hab=array(10);

$hablog=$conEle->habilitar($hab);

echo "<pre>";
print_r($hablog);
echo "</pre>";
?>