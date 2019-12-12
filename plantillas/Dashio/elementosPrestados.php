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
            <p>Elementos sin devolver: <?php if (isset($totalRegistrosElementos)) echo $totalRegistrosElementos; ?></p>
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
            <form name="formBuscarElementos" action="Controlador.php" method="POST">
                <div class="row mt">
            <div class="col-lg-6">
            <h4><i class="fa fa-angle-right"></i>FILTRO</h4>
                <div class="form-panel">
                <input type="hidden" name="ruta" value="verInventarioElementos"/>
                <table> 
                    <tr><td>Codigo:</td>
                        <td><input type="number" name="eleLecCodigo" onclick="" value="<?php
                                            if (isset($_SESSION['eleLecCodigoF'])) {
                                                echo $_SESSION['eleLecCodigoF'];
                                            }
                                            ?>"/>
                        </td>                      
                    </tr>             
                    <tr><td>Categoria: </td>
                        <td>
                            <select id="categoriaElementos_catEleId" name="categoria_elementos_catEleId"style="width: 129px">
                                <option value = "">Seleccionar</option>
                            <?php
                            for ($j = 0; $j < $cantCategorias; $j++) {
                                ?>
                                    <option value = "<?php echo $registroCategoriasElementos[$j]->catEleId; ?>" <?php
                                   if (isset($_SESSION['categoria_elementos_catEleIdF']) && $_SESSION['categoria_elementos_catEleIdF'] == $registroCategoriasElementos[$j]->catEleId) {
                                       echo " selected";
                                   }
                                ?> > <?php echo $registroCategoriasElementos[$j]->catEleId . " - " . $registroCategoriasElementos[$j]->catEleNombre; ?></option>             
                                <?php
                            }
                            ?>
                            </select> 
                        </td>
                        <td></td>                          
                    </tr>
                    <tr><td>Estado: </td>
                        <td>
                            <select id="estado_elementos_estEleId" name="estado_elementos_estEleId"style="width: 129px">
                                <option value = "">Seleccionar</option>
                                <?php
                                for ($j = 0; $j < $cantEstados; $j++) {
                                    ?>
                                    <option value = "<?php echo $registroEstadosElementos[$j]->catEleId; ?>" <?php
                                            if (isset($_SESSION['estEleNombreF']) && $_SESSION['estEleNombreF'] == $registroEstadosElementos[$j]->estEleId) {
                                                echo " selected";
                                            }
                                            ?> > <?php echo $registroEstadosElementos[$j]->estEleId . " - " . $registroEstadosElementos[$j]->estEleNombre; ?></option>             
                                            <?php
                                    }
                                    ?>
                            </select> 
                        </td>
                        <td></td>                          
                    </tr>
                    <tr><td><input type="submit" class="btn btn-theme btn-block" value="Filtrar" name="enviar" title="Si es necesario limpie 'Buscar'"/></td>
                        <td><input type="reset"  class="btn btn-theme btn-block" value="limpiar" onclick="
                            javascript:document.formBuscarElementos.eleLecCodigo.value = '';
                            javascript:document.formBuscarElementos.categoria_elementos_catEleId.value = '';
                            javascript:document.formBuscarElementos.estado_elementos_estEleId.value = '';
                            javascript:document.formBuscarElementos.buscarEle.value = '';
                            javascript:document.formBuscarElementos.submit();"/>
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
                        <input type="text" name="buscarEle" placeholder="Término a Buscar" value="<?php
                                    if (isset($_SESSION['buscarEleF'])) {
                                        echo $_SESSION['buscarEleF'];
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
