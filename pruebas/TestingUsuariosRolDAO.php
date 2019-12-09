<?php
include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloUsuariosRol/UsuariosRolDAO.php";

//-- SELECCIONAR TODOS.
$usuRol=new UsuariosRolDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$usuRol->seleccionarTodos();
echo '<pre>';
//print_r($listado);
echo '</pre>';

//--> IMPRIMIR. (id_usuario_s,id_rol, usuRolEstado, usuRolFecha, categoria_elementos_catEleId)
$registro['id_usuario_s'] = 13;
$registro['id_rol'] = 2;
$registro['usuRolEstado'] = 1 ;
$registro['usuRolFecha'] = '2019-06-06 15:02:04';
$registro['categoria_elementos_catEleId'] = 2;

$insert = $usuRol->insertar($registro);

echo '<pre>';
//print_r($insert);
echo '</pre>';

//--> SELECCIONAR ID
$id=array( 11 );

$isd=$usuRol->seleccionarId($id);
echo "<pre>";
//print_r($isd);
echo "</pre>";

////--->UPDATE
            $id_usuario_s = $registro[0]['id_usuario_s']= 17;
            $id_rol = $registro[0]['id_rol']= 1 ;
            $usuRolEstado = $registro[0]['usuRolEstado']= 2;
            $usuRolFecha = $registro[0]['usuRolFecha']= 1;
            $categoria_elementos_catEleId = $registro[0]['categoria_elementos_catEleId']= 2;
            $up= $usuRol->actualizar($registro);
echo "<pre>";
//print_r($up);
echo "</pre>";
///-->eliminar
$id= array (11);
$isd= $usuRol-> eliminar($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--> eliminar logico
$id= array (11);
$isd= $usuRol->eliminarLogico($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--->habilitar logicos
$id= array(11);
$isd=$usuRol->habilitar($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

$id=[5,0];
$isd=$usuRol->consultaPaginada($id[0], $id[1]);
echo"<pre>";
print_r($isd);
echo"</pre>";

//coutn
$cu=$usuRol->totalRegistros();        
echo "<pre>";
//print_r($cu);
echo "</pre>";
?>







