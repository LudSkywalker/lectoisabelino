<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH . "modelos/ConexDBMySQL.php";
include_once PATH . "modelos/modeloLibros/LibrosDAO.php";

//Select todos
echo "    ";
$lib = new LibrosDao(SERVIDOR, BASE, USUARIO_BD, CONTRASENA);
$listado = $lib->seleccionarTodos();

echo '<pre>';
print_r($listado);
echo '</pre>';

//Insert
$registro['isbn'] = 905;
$registro['titulo'] = "1906846 R1 CRUD INSERTAR";
$registro['autor'] = "CAMILO";
$registro['precio'] = "10000";
$registro['categoriaLibro_catLibId'] = 2;

$insert = $lib->insertar($registro);

echo '<pre>';
print_r($insert);
echo '</pre>';

//Select id
$sId=array(645);

$id=$lib->seleccionarId($sId);

echo "<pre>";
print_r($id);
echo "</pre>";

//Update
$registro[0]['isbn']=905;
$registro[0]['titulo']="1906846 R1 CRUD INSERTAR";
$registro[0]['autor']="VALENTINA";
$registro[0]['precio']="10000";
$registro[0]['categoriaLibro_catLibId']=2;

$up=$lib->actualizar($registro);

echo "<pre>";
print_r($up);
echo "</pre>";

//Delete
$sid=array(905);

$del=$lib->eliminar($sid);

echo "<pre>";
print_r($del);
echo "</pre>";

//Delete logic
$dell=array(645);


$deletelog=$lib->eliminarLogico($dell);

echo "<pre>";
print_r($deletelog);
echo "</pre>";

//Delete logico habilitar
$hab=array(645);

$hablog=$lib->habilitar($hab);

echo "<pre>";
print_r($hablog);
echo "</pre>";



?>