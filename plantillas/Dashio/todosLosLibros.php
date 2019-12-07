<?php

if (isset($_SESSION['listaDeLibrosLecto'])) {
    $listaDeLibros = $_SESSION['listaDeLibrosLecto'];
}

if (isset($_SESSION['paginacionVinculosLecto'])) {
    $paginacionVinculos = $_SESSION['paginacionVinculosLecto'];
}
if (isset($_SESSION['totalRegistrosLibrosLecto'])) {
    $totalRegistrosLibros = $_SESSION['totalRegistrosLibrosLecto'];
}
if (isset($_SESSION['registroCategoriasLibrosLecto'])) { /* * ************************ */
    $registroCategoriasLibros = $_SESSION['registroCategoriasLibrosLecto'];
    $cantCategorias = count($registroCategoriasLibros);
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
            <h3><i class="fa fa-angle-right"></i> Gestión de Libros</h3>
<div>
    <fieldset class="scheduler-border"><legend class="scheduler-border">FILTRO</legend>

        <form name="formBuscarLibrosLecto" action="Controlador.php" method="POST">
            <input type="hidden" name="ruta" value="verInventarioLibros"/>
            <table> 
                <tr><td>Codigo:</td>
                    <td><input type="number" name="libLecCod" onclick="" value="<?php

                        if (isset($_SESSION['libLecCodF'])) {
                            echo $_SESSION['libLecCodF'];
                        } ?>"/>
                    </td>                      
                </tr> 
                <tr><td>Titulo:</td>
                    <td><input type="text" name="libLecTitulo" onclick="" value="<?php

                        if (isset($_SESSION['libLecTituloF'])) {
                            echo $_SESSION['libLecTituloF'];
                        } ?>"/>
                    </td>                       
                </tr> 
                <tr><td>Autor:</td>
                    <td><input type="text" onclick="" name="libLecAutor" value="<?php

                        if (isset($_SESSION['libLecAutorF'])) {
                            echo $_SESSION['libLecAutorF'];
                        } ?>"/>
                    </td>
                    <td>                         
                </tr>              
                <tr><td>Categoria: </td>
                    <td>
                        <select id="categoriaLibro_catLibId" name="categoria_libro_lecto_catLecId">
                            <option value = "">Seleccionar</option>
                        <?php
                            for ($j = 0; $j < $cantCategorias; $j++) {
                        ?>
                                <option value = "<?php
 echo $registroCategoriasLibros[$j]->catLibId; ?>" <?php

                                if (isset($_SESSION['categoria_libro_lecto_catLecIdF']) && $_SESSION['categoria_libro_lecto_catLecIdF'] == $registroCategoriasLibros[$j]->catLibId) {
                                    echo " selected";
                                }
                                ?> > <?php
 echo $registroCategoriasLibros[$j]->catLecId . " - " . $registroCategoriasLibros[$j]->catLecNombre; ?></option>             
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
                            javascript:document.formBuscarLibrosLecto.buscarLibLec.value = '';
                            javascript:document.formBuscarLibrosLecto.submit();"/>
                    </td>
                    <td></td>
                </tr> 
            </table>
            <fieldset class="scheduler-border"><legend class="scheduler-border">Buscar</legend>
                <div style="width: 800">
                        <!--BOTÓN PARA BUSCAR*************************-->
                            <input type="text" name="buscarLibLec" placeholder="Término a Buscar" value="<?php

                            if (isset($_SESSION['buscarLibLecF'])) {
                                echo $_SESSION['buscarLibLecF'];
                            }
                            ?>">
                </div>        
            </fieldset>             
        </form>
    </fieldset>
</div>
            
<br>
<div style="width: 800">
    <span class="izquierdo">
        <input type="button" onclick="javascript:location.href = 'Controlador.php?ruta=mostrarInsertarLibros'" value="Nuevo Libro">
    </span>
</div>
<br>
<a name="listaDeLibros" id="a"></a>
<div style="width: 800">
    <p>Total de Registros: <?php
 if (isset($totalRegistrosLibros)) echo $totalRegistrosLibros; ?></p>
    <table border='1' class="display table table-bordered">
        <thead>
           <tr>
                <td style="width: 100">Codigo</td>
                <td style="width: 100">Titulo</td>
                <td style="width: 100">Autor</td>
                <td style="width: 100">Precio</td>
                <td style="width: 100">Id categoria</td>
                <td style="width: 100">Categoria</td>
                <td style="width: 100"  colspan="2"> Acciones </td>
            </tr>
        </thead> 
        <tbody>
 <?php

            $i = 0;
            foreach ($listaDeLibros as $key => $value) {
            ?>
            <tr>
                <td style="width: 100"><?php
 echo $listaDeLibros[$i]->libLecCodigo; ?></td>
                <td style="width: 100"><?php
 echo strtoupper($listaDeLibros[$i]->libLecTitulo); ?></td>
                <td style="width: 100"><?php
 echo strtoupper($listaDeLibros[$i]->libLecAutor); ?></td>
                <td style="width: 100"><?php
 echo $listaDeLibros[$i]->catLecId; ?></td>
                <td style="width: 100"><?php
 echo $listaDeLibros[$i]->catLecNombre; ?></td>
                <td style="width: 100"><?php
 if (in_array(1, $_SESSION['rolesEnSesion'])) { ?><a href="Controlador.php?ruta=actualizarLibro&idAct=<?php
 echo $listaDeLibros[$i]->libLecId; ?>" >Actualizar</a><?php
 } ?></td>
                <td style="width: 100"><?php
 if (in_array(1, $_SESSION['rolesEnSesion'])) { ?>  <a href="Controlador.php?ruta=eliminarLibro&idAct=<?php
 echo $listaDeLibros[$i]->libLecId; ?>">Eliminar</a><?php
 } ?>  </td>
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
                        <?php
 $i = 0; ?>
                        <ul class="pagination justify-content-center">
                        <?php
 foreach ($paginacionVinculos as $key => $value) { ?>    
                                <li class="page-item"><a class="page-link" href="<?php
 echo $value; ?>"><?php
 echo ($key); ?></a></li>
                            <?php
 } ?>
                        </ul>
                    </nav>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

        <!--/ row -->
      </section>
      <!-- /wrapper -->
    </section>