<?php
if (isset($_SESSION['listaDeElementos'])) {
    $listaDeLibros = $_SESSION['listaDeElementos'];
}

if (isset($_SESSION['paginacionVinculosElementos'])) {
    $paginacionVinculos = $_SESSION['paginacionVinculosElementos'];
}
if (isset($_SESSION['totalRegistrosElementosLecto'])) {
    $totalRegistrosLibros = $_SESSION['totalRegistrosElementosLecto'];
}
if (isset($_SESSION['registroCategoriasElementosLecto'])) { /* * ************************ */
    $registroCategoriasLibros = $_SESSION['registroCategoriasElementosLecto'];
    $cantCategorias = count($registroCategoriasLibros);
}
if (isset($_SESSION['registroEstadosElementosLecto'])) { /* * ************************ */
    $registroEstadosLibros = $_SESSION['registroEstadosElementosLecto'];
    $cantEstados = count($registroEstadosLibros);
}

?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Elementos</h3>
        <div style="width: 800">
            <p>Total de libros: <?php if (isset($totalRegistrosLibros)) echo $totalRegistrosLibros; ?></p>
            <table border='1' class="display table table-bordered">
                <thead>
                    <tr>
                        <td style="width: 100">Codigo</td>
                        <td style="width: 100">Categoria</td>
                        <td style="width: 100">Estado</td>
                    </tr>
                </thead> 
                <tbody>
<?php
$i = 0;
foreach ($listaDeLibros as $key => $value) {
    ?>
                        <tr>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->eleLecCodigo; ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->catEleNombre; ?></td>
                            <td style="width: 100"><?php echo $listaDeLibros[$i]->estEleNombre; ?></td>
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
                <input type="hidden" name="ruta" value="verInventarioElementos"/>
                <table> 
                    <tr><td>Codigo:</td>
                        <td><input type="text" name="eleLecCod" onclick="" value="<?php
                                            if (isset($_SESSION['eleLecCodF'])) {
                                                echo $_SESSION['eleLecCodF'];
                                            }
                                            ?>"/>
                        </td>                      
                    </tr> 
                    <tr><td>Categoria: </td>
                        <td>
                            <select id="categoria_elementos_catEleId" name="categoria_elementos_catEleId"style="width: 129px">
                                <option value = "">Seleccionar</option>
                            <?php
                            for ($j = 0; $j < $cantCategorias; $j++) {
                                ?>
                                    <option value = "<?php echo $registroCategoriasLibros[$j]->catEleId; ?>" <?php
                                   if (isset($_SESSION['categoria_elementos_catEleIdF']) && $_SESSION['categoria_elementos_catEleIdF'] == $registroCategoriasLibros[$j]->catEleId) {
                                       echo " selected";
                                   }
                                ?> > <?php echo $registroCategoriasLibros[$j]->catEleId . " - " . $registroCategoriasLibros[$j]->catEleNombre; ?></option>             
                                <?php
                            }
                            ?>
                            </select> 
                        </td>
                        <td></td>                          
                    </tr>
                    <tr><td>Estado: </td>
                        <td>
                            <select id="estado_libros_estLibId" name="estado_elementos_estEleId"style="width: 129px">
                                <option value = "">Seleccionar</option>
                                <?php
                                for ($j = 0; $j < $cantEstados; $j++) {
                                    ?>
                                    <option value = "<?php echo $registroEstadosLibros[$j]->estEleId; ?>" <?php
                                            if (isset($_SESSION['estEleNombreF']) && $_SESSION['estEleNombreF'] == $registroEstadosLibros[$j]->estEleId) {
                                                echo " selected";
                                            }
                                            ?> > <?php echo $registroEstadosLibros[$j]->estEleId . " - " . $registroEstadosLibros[$j]->estEleNombre; ?></option>             
                                            <?php
                                    }
                                    ?>
                            </select> 
                        </td>
                        <td></td>                          
                    </tr>
                    <tr><td><input type="submit" class="btn btn-theme btn-block" value="Filtrar" name="enviar" title="Si es necesario limpie 'Buscar'"/></td>
                        <td><input type="reset"  class="btn btn-theme btn-block" value="limpiar" onclick="
                            javascript:document.formBuscarLibrosLecto.eleLecCod.value = '';
                            javascript:document.formBuscarLibrosLecto.categoria_elementos_catEleId.value = '';
                            javascript:document.formBuscarLibrosLecto.estado_elementos_estEleId.value = '';
                            javascript:document.formBuscarLibrosLecto.buscarEleLecCod.value = '';
                            javascript:document.formBuscarLibrosLecto.submit();"/>
                        </td>
                        <td></td>
                    </tr> 
                </table>
                </div>
                </div>
                <fieldset class="scheduler-border">
                    <h4><i class="fa fa-angle-right"></i>Buscar elementos</h4>
            <div class="col-lg-6">
                <div class="form-panel">
                    
                    <div style="width: 800">
                        <!--BOTÓN PARA BUSCAR*************************-->
                        <input type="text" name="buscarEleLecCod" placeholder="Término a Buscar" value="<?php
                                    if (isset($_SESSION['buscarEleLecCodF'])) {
                                        echo $_SESSION['buscarEleLecCodF'];
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

