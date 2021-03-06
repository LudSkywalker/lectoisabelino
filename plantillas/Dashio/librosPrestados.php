<?php
if (isset($_SESSION['listaDePrestamos'])) {
    $listaDeLibros = $_SESSION['listaDePrestamos'];
}

if (isset($_SESSION['paginacionVinculosPrestamos'])) {
    $paginacionVinculos = $_SESSION['paginacionVinculosPrestamos'];
}
if (isset($_SESSION['totalRegistrosPrestamos'])) {
    $totalRegistrosLibros = $_SESSION['totalRegistrosPrestamos'];
}
if (isset($_SESSION['registroLibrosLecto'])) { /* * ************************ */
    $registroLibros = $_SESSION['registroLibrosLecto'];
}
if (isset($_SESSION['registroCategoriasLibrosLecto'])) { /* * ************************ */
    $registroCategoriasLibros = $_SESSION['registroCategoriasLibrosLecto'];
    $cantCategorias = count($registroCategoriasLibros);
}
if (isset($_SESSION['registroEstadosLibrosLecto'])) { /* * ************************ */
    $registroEstadosLibros = $_SESSION['registroEstadosLibrosLecto'];
    $cantEstados = count($registroEstadosLibros);
}

?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Libros Prestados</h3>
        <div style="width: 800">
            <p>Libros sin devolver: <?php if (isset($totalRegistrosLibros)) echo $totalRegistrosLibros; ?></p>
            <table border='1' class="display table table-bordered">
                <thead>
                    <tr>
                        <td style="width: 100;text-align: center" colspan="4">DATOS SOBRE EL LIBRO PRESTADO</td>
                        <td style="width: 100;text-align: center" colspan="2">PERSONA RESPONSABLE</td>
                        <td style="width: 100;text-align: center"colspan="2">INFORMACION DEL PRESTAMO</td>
                    </tr>
                    <tr>
                        <td style="width: 100">Codigo Libro</td>
                        <td style="width: 100">Titulo Libro</td>
                        <td style="width: 100">Estado Libro</td>
                        <td style="width: 100">Categoria Libro</td>
                        <td style="width: 100">Documento</td>
                        <td style="width: 100"> Nombre</td>
                        <td style="width: 100">Fecha salida</td>
                        <td style="width: 100">Observacion salida</td>
                    </tr>
                </thead> 
                <tbody>
<?php
$i = 0;
foreach ($listaDeLibros as $key => $value) {
    ?>
                        <tr>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->libLecCodigo ?></td>
                            <td style="width: 100"><?php echo strtoupper($listaDeLibros[$i]->libLecTitulo) ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->estLibNombre; ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->catLecNombre; ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->perDocumento ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->perNombre." ".$listaDeLibros[$i]->perApellido ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->conPFechaSal; ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->conPObsSalida; ?></td>
                                <?php
                                $i++;
                                ?>
                        <tr>
                                <?php
                            }
                            ?>
                </tbody>
</table>
         
                    <tr>
                        <td colspan="8">
                                                <div class="btn-group">
                        <?php $i = 0; ?>
                        
                        <?php foreach ($paginacionVinculos as $key => $value) { ?>    
                                        <a class="btn btn-theme" href="<?php echo $value; ?>"><?php echo ($key); ?></a>

                            
                            <?php }
                        ?>
                        </div>
                        </td>
                    </tr>
        </div>
        
        <fieldset class="scheduler-border">
            <form name="formBuscarLibrosLecto" action="Controlador.php" method="POST">
                <div class="row mt">
            <div class="col-lg-6">
            <h4><i class="fa fa-angle-right"></i>FILTRO</h4>
                <div class="form-panel">
                <input type="hidden" name="ruta" value="verInventarioLibros"/>
                <table> 
                    <tr><td>Codigo:</td>
                        <td><input type="number" name="libLecCod" onclick="" value="<?php
                                            if (isset($_SESSION['libLecCodF'])) {
                                                echo $_SESSION['libLecCodF'];
                                            }
                                            ?>"/>
                        </td>                      
                    </tr> 
                    <tr><td>Titulo:</td>
                        <td><input type="text" name="libLecTitulo" onclick="" value="<?php
                                    if (isset($_SESSION['libLecTituloF'])) {
                                        echo $_SESSION['libLecTituloF'];
                                    }
                                            ?>"/>
                        </td>                       
                    </tr> 
                    <tr><td>Autor:</td>
                        <td><input type="text" onclick="" name="libLecAutor" value="<?php
                                    if (isset($_SESSION['libLecAutorF'])) {
                                        echo $_SESSION['libLecAutorF'];
                                    }
                                            ?>"/>
                        </td>
                        <td>                         
                    </tr>              
                    <tr><td>Categoria: </td>
                        <td>
                            <select id="categoriaLibro_catLibId" name="categoria_libro_lecto_catLecId"style="width: 129px">
                                <option value = "">Seleccionar</option>
                            <?php
                            for ($j = 0; $j < $cantCategorias; $j++) {
                                ?>
                                    <option value = "<?php echo $registroCategoriasLibros[$j]->catLecId; ?>" <?php
                                   if (isset($_SESSION['categoria_libro_lecto_catLecIdF']) && $_SESSION['categoria_libro_lecto_catLecIdF'] == $registroCategoriasLibros[$j]->catLecId) {
                                       echo " selected";
                                   }
                                ?> > <?php echo $registroCategoriasLibros[$j]->catLecId . " - " . $registroCategoriasLibros[$j]->catLecNombre; ?></option>             
                                <?php
                            }
                            ?>
                            </select> 
                        </td>
                        <td></td>                          
                    </tr>
                    <tr><td>Estado: </td>
                        <td>
                            <select id="estado_libros_estLibId" name="estado_libros_estLibId"style="width: 129px">
                                <option value = "">Seleccionar</option>
                                <?php
                                for ($j = 0; $j < $cantEstados; $j++) {
                                    ?>
                                    <option value = "<?php echo $registroEstadosLibros[$j]->catLecId; ?>" <?php
                                            if (isset($_SESSION['estLibNombreF']) && $_SESSION['estLibNombreF'] == $registroEstadosLibros[$j]->estLibId) {
                                                echo " selected";
                                            }
                                            ?> > <?php echo $registroEstadosLibros[$j]->estLibId . " - " . $registroEstadosLibros[$j]->estLibNombre; ?></option>             
                                            <?php
                                    }
                                    ?>
                            </select> 
                        </td>
                        <td></td>                          
                    </tr>
                    <tr><td><input type="submit" class="btn btn-theme btn-block" value="Filtrar" name="enviar" title="Si es necesario limpie 'Buscar'"/></td>
                        <td><input type="reset"  class="btn btn-theme btn-block" value="limpiar" onclick="
                            javascript:document.formBuscarLibrosLecto.libLecCod.value = '';
                            javascript:document.formBuscarLibrosLecto.libLecTitulo.value = '';
                            javascript:document.formBuscarLibrosLecto.libLecAutor.value = '';
                            javascript:document.formBuscarLibrosLecto.categoria_libro_lecto_catLecId.value = '';
                            javascript:document.formBuscarLibrosLecto.estado_libros_estLibId.value = '';
                            javascript:document.formBuscarLibrosLecto.buscarLibLec.value = '';
                            javascript:document.formBuscarLibrosLecto.submit();"/>
                        </td>
                        <td></td>
                    </tr> 
                </table>
                </div>
                </div>
                <fieldset class="scheduler-border">
                    <h4><i class="fa fa-angle-right"></i>Buscar</h4>
            <div class="col-lg-6">
                <div class="form-panel">
                    
                    <div style="width: 800">
                        <!--BOTÓN PARA BUSCAR*************************-->
                        <input type="text" name="buscarLibLec" placeholder="Término a Buscar" value="<?php
                                    if (isset($_SESSION['buscarLibLecF'])) {
                                        echo $_SESSION['buscarLibLecF'];
                                    }
                                    ?>">
                    </div>        
                    </div>
                    </div>
                </fieldset>             
                    </div>
            </form>
        </fieldset>

</section>
    </section>

        <!--/ row -->