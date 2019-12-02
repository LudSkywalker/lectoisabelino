<?php

include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloElementos/ElementosDAO.php";

echo "Seleccionar todo";
$ele=new ElementosDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$ele->seleccionarTodos();
echo '<pre>';
//print_r($listado);
echo '</pre>';

//--> IMPRIMIR. (eleLecId, eleLecCodigo, eleLecEstado, estado_elementos_estEleId, categoria_elementos_catEleId)

$registro['eleLecId'] = 13;
$registro['eleLecCodigo'] = "AJE_07";
$registro['eleLecEstado'] = 1 ;
$registro['estado_elementos_estEleId'] = 3;
$registro['categoria_elementos_catEleId'] = 2;

$insert = $ele->insertar($registro);

echo '<pre>';
//print_r($insert);
echo '</pre>';

//--> SELECCIONAR ID
$id=array( 11 );

$isd=$ele->seleccionarId($id);
echo "<pre>";
//print_r($isd);
echo "</pre>";

////--->UPDATE
            $eleLecId = $registro[0]['eleLecId']= 17;
            $eleLecCodigo = $registro[0]['eleLecCodigo']= "AJE_09" ;
            $eleLecEstado = $registro[0]['eleLecEstado']= 2;
            $estado_elementos_estEleId = $registro[0]['estado_elementos_estEleId']= 1;
            $categoria_elementos_catEleId = $registro[0]['categoria_elementos_catEleId']= 2;
            $up= $ele->actualizar($registro);
echo "<pre>";
//print_r($up);
echo "</pre>";
///-->eliminar
$id= array (11);
$isd= $ele-> eliminar($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--> eliminar logico
$id= array (11);
$isd= $ele->eliminarLogico($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--->habilitar logicos
$id= array(11);
$isd=$ele->habilitar($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

$id= array(11);
$isd=$ele->consultaPaginada($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

//coutn
$cu=$conEle->totalRegistros();        
echo "<pre>";
print_r($cu);
echo "</pre>";

?>







