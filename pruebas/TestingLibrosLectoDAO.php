<?php
include_once "../modelos/ConstantesDeConexion.php";
include_once PATH."modelos/ConexDBMySQL.php";
include_once PATH."modelos/modeloLibrosLecto/LibrosLectoDAO.php";

//-- SELECCIONAR TODOS.
echo "Seleccionar todo";
$libLec=new LibrosLectoDao(SERVIDOR,BASE,USUARIO_BD,CONTRASENA);
$listado=$libLec->seleccionarTodos();

echo '<pre>';
//print_r($listado);
echo '</pre>';
//-- IMPRIMIR.
$registro['conEFechaSal'] = '2019-06-06 15:02:04';
$registro['conEFechaEnt'] = '2019-06-07 15:02:04';
$registro['conEFechaDev'] = NULL ;
$registro['conEPrestado'] = 1;
$registro['conEObsSalida'] = 'Excelente Estado';
$registro['conEObsEntrada'] = 'Buen Estado';
$registro['persona_perId'] = 2;
$registro['elementos_lecto_eleLecId'] = 6;

$insert = $libLec->insertar($registro);

echo '<pre>';
print_r($insert);
echo '</pre>';

//--> SELECCIONAR ID
$id=array( 11 );

$isd=$libLec->seleccionarId($id);
echo "<pre>";
//print_r($isd);
echo "</pre>";
////--->UPDATE
            $libLecCodigo = $registro[0]['libLecCodigo']= "LBGO_09" ;
            $libLecTitulo = $registro[0]['libLecTitulo']= "El tunel" ;
            $libLecAutor = $registro[0]['libLecAutor']=  "Ernesto Sabato" ;
            $estado_libros_estLibId = $registro[0]['estado_libros_estLibId']= 1  ;
            $libLecId = $registro[0]['libLecId']= 12  ;
            $up=$libLec->actualizar($registro);
echo "<pre>";
//print_r($up);
echo "</pre>";
///-->eliminar
$id= array (11);
$isd= $libLec-> eliminar($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--> eliminar logico
$id= array (11);
$isd= $libLec->eliminarLogico($id); 
echo "<pre>";
//print_r($isd);
echo "</pre>";
//--->habilitar logicos
$id= array(11);
$isd=$libLec->habilitar($id);
echo"<pres>";
//print_r($isd);
echo"</pres>";

$id=[6,0];
$isd=$libLec->consultaPaginada($id[0],$id[1]);
echo"<pre>";
//print_r($isd);
echo"</pre>";

//coutn
$cu=$libLec->totalRegistros();        
echo "<pre>";
//print_r($cu);
echo "</pre>";
?>
