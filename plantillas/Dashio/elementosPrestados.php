<?php
if (isset($_SESSION['listaDePrestamosEle'])) {
    $listaDeElementos = $_SESSION['listaDePrestamosEle'];
}

if (isset($_SESSION['paginacionVinculosPrestamosEle'])) {
    $paginacionVinculos = $_SESSION['paginacionVinculosPrestamosEle'];
}
if (isset($_SESSION['totalRegistrosPrestamosEle'])) {
    $totalRegistrosElementos = $_SESSION['totalRegistrosPrestamosEle'];
}
if (isset($_SESSION['registroElementos'])) { /* * ************************ */
    $registroElementos = $_SESSION['registroElementos'];
}
if (isset($_SESSION['registroCategoriasElementos'])) { /* * ************************ */
    $registroCategoriasElementos = $_SESSION['registroCategoriasElementos'];
    $cantCategorias = count($registroCategoriasElementos);
}
if (isset($_SESSION['registroEstadosElementos'])) { /* * ************************ */
    $registroEstadosElementos = $_SESSION['registroEstadosElementos'];
    $cantEstados = count($registroEstadosElementos);
}

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
    $mensaje = NULL;
}
?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Elementos Prestados</h3>
        <div style="width: 800">
            <p>Libros sin devolver: <?php if (isset($totalRegistrosElementos)) echo $totalRegistrosElementos; ?></p>
            <table border='1' class="display table table-bordered">
                <thead>
                    <tr>
                        <td style="width: 100;text-align: center" colspan="3">DATOS SOBRE EL ELEMENTO PRESTADO</td>
                        <td style="width: 100;text-align: center" colspan="2">PERSONA RESPONSABLE</td>
                        <td style="width: 100;text-align: center"colspan="2">INFORMACION DEL PRESTAMO</td>
                    </tr>
                    <tr>
                        <td style="width: 100">Codigo Elemento</td>
                        <td style="width: 100">Categoria Elemento</td>
                        <td style="width: 100">Estado Elemento</td>
                        <td style="width: 100">Documento</td>
                        <td style="width: 100">Nombre</td>
                        <td style="width: 100">Fecha salida</td>
                        <td style="width: 100">Observacion salida</td>
                    </tr>
                </thead> 
                <tbody>
<?php
$i = 0;
foreach ($listaDeElementos as $key => $value) {
    ?>
                        <tr>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->eleLecCodigo ?></td>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->catEleNombre; ?></td>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->estEleNombre; ?></td>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->perDocumento ?></td>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->perNombre." ".$listaDeElementos[$i]->perApellido ?></td>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->conEFechaSal; ?></td>
                            <td style="width: 100"><?php echo $listaDeElementos[$i]->conEObsSalida; ?></td>
                                <?php
                                $i++;
                                ?>
                        <tr>
                                <?php
                            }
                            ?>
                </tbody>
                <tfoot> 
                    <tr>
                        <td colspan="8">
                            <nav aria-label="Page navigation example">
                        <?php $i = 0; ?>
                                <ul class="pagination justify-content-center">
                        <?php foreach ($paginacionVinculos as $key => $value) { ?>    
                                        <li class="page-item"><a class="page-link" href="<?php echo $value; ?>"><?php echo ($key); ?></a></li>
                            <?php }
                        ?>
                                </ul>
                            </nav>
                        </td>
                    </tr>
                </tfoot>
            </table>
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

        <!--/ row -->
    </section>
    <!-- /wrapper -->