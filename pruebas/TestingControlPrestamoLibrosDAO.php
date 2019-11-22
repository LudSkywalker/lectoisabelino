<?php


include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloControlPrestamoLibros/ControlPrestamoLibrosDAO.php";


$lib = new ControlPrestamoLibrosDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);

//Select todos
$listado = $lib->seleccionarTodos();

echo '<pre>';
print_r($listado);
echo '</pre>';

//Insert

$registro['conPFechaSal'] = '2019-06-06 15:02:04';
$registro['conPFechaEnt'] = '2019-06-07 15:02:04';
$registro['conPFechaDev'] = NULL ;
$registro['conPPrestado'] = 1;
$registro['conPObsSalida'] = 'Excelente Estado';
$registro['conPObsEntrada'] = 'Buen Estado';
$registro['persona_usuario_s_usuId'] = 2;
$registro['libros_lecto_libLecId'] = 6;

$insert = $lib->insertar($registro);

echo '<pre>';
print_r($insert);
echo '</pre>';

//Select id
$id=array( 11 );

$isd=$lib->seleccionarId($id);

echo "<pre>";
print_r($isd);
echo "</pre>";

//Update
$registro[0]['conPFechaSal'] = '2019-06-06 15:02:04';
$registro[0]['conPFechaEnt'] = '2019-06-07 15:02:04';
$registro[0]['conPFechaDev'] = '2019-05-07 15:02:04' ;
$registro[0]['conPPrestado'] = 1;
$registro[0]['conPObsSalida'] = 'Excelente Estado';
$registro[0]['conPObsEntrada'] = 'Buen Estado';
$registro[0]['persona_usuario_s_usuId'] = 2;
$registro[0]['libros_lecto_libLecId'] = 6;
$registro[0]['conPId ']=11;

$up=$lib->actualizar($registro);

echo "<pre>";
print_r($up);
echo "</pre>";

//Delete
$sid=array(11);

$del=$lib->eliminar($sid);

echo "<pre>";
print_r($del);
echo "</pre>";

//Delete logic
$dell=array(10);


$deletelog=$lib->eliminarLogico($dell);

echo "<pre>";
print_r($deletelog);
echo "</pre>";

//Delete logico habilitar
$hab=array(10);

$hablog=$lib->habilitar($hab);

echo "<pre>";
print_r($hablog);
echo "</pre>";


?>