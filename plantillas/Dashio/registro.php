<?php
if (isset($_SESSION['roles'])) { /* * ************************ */
    $roles = $_SESSION['roles'];
    $cantRol = count($roles);
}
?>

<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Registrar nuevo usuario</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="form-panel">
                    <form class="form-horizontal style-form" method="POST" action="Controlador.php" id="formRegistro">
                        <div class="form-group">
                            <div class="col-sm-10">                    
                                <input class="form-control"  placeholder="Documento" name="documento" type="number" required="required" autofocus
                                       value=<?php
                                       if (isset($erroresValidacion['datosViejos']['documento']))
                                           echo "\"" . $erroresValidacion['datosViejos']['documento'] . "\"";
                                       if (isset($_SESSION['documento']))
                                           echo "\"" . $_SESSION['documento'] . "\"";
                                       unset($_SESSION['documento']);
                                       ?>
                                       >
                            </div >
                            <div >
                                <?php
                                if (isset($erroresValidacion['marcaCampo']['documento']))
                                    echo "<font color='red'>" . $erroresValidacion['marcaCampo']['documento'] . "</font>";
                                ?>
                                <?php
                                if (isset($erroresValidacion['mensajesError']['documento']))
                                    echo "<font color='red'>" . $erroresValidacion['mensajesError']['documento'] . "</font>";
                                ?>  
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">                    
                                <input class="form-control"  placeholder="Nombres" name="nombre" type="text"   required="required"
                                       value=<?php
                                       if (isset($erroresValidacion['datosViejos']['nombre']))
                                           echo "\"" . $erroresValidacion['datosViejos']['nombre'] . "\"";
                                       if (isset($_SESSION['nombre'])) {
                                           echo "\"" . $_SESSION['nombre'] . "\"";
                                           unset($_SESSION['nombre']);
                                       }
                                       ?>
                                       >
                            </div >
                            <div >
                                <?php
                                if (isset($erroresValidacion['marcaCampo']['nombre']))
                                    echo "<font color='red'>" . $erroresValidacion['marcaCampo']['nombre'] . "</font>";
                                ?>                                        
                                <?php
                                if (isset($erroresValidacion['mensajesError']['nombre']))
                                    echo "<font color='red'>" . $erroresValidacion['mensajesError']['nombre'] . "</font>";
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input class="form-control"  placeholder="Apellidos" name="apellidos" type="text"  required="required"
                                       value=<?php
                                       if (isset($erroresValidacion['datosViejos']['apellidos']))
                                           echo "\"" . $erroresValidacion['datosViejos']['apellidos'] . "\"";
                                       if (isset($_SESSION['apellidos'])) {
                                           echo "\"" . $_SESSION['apellidos'] . "\"";
                                           unset($_SESSION['apellidos']);
                                       }
                                       ?>
                                       >
                            </div >
                            <div >
                                <?php
                                if (isset($erroresValidacion['marcaCampo']['apellidos']))
                                    echo "<font color='red'>" . $erroresValidacion['marcaCampo']['apellidos'] . "</font>";
                                ?>
                                <?php
                                if (isset($erroresValidacion['mensajesError']['apellidos']))
                                    echo "<font color='red'>" . $erroresValidacion['mensajesError']['apellidos'] . "</font>";
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">                    
                                <input class="form-control"  id="InputCorreo" placeholder="Correo Electrónico" name="email" type="email"  required="required"
                                       value=<?php
                                       if (isset($erroresValidacion['datosViejos']['email']))
                                           echo "\"" . $erroresValidacion['datosViejos']['email'] . "\"";
                                       if (isset($_SESSION['email'])) {
                                           echo "\"" . $_SESSION['email'] . "\"";
                                           unset($_SESSION['email']);
                                       }
                                       ?>
                                       >
                            </div >
                        </div >
                        <div >
                            <?php
                            if (isset($erroresValidacion['marcaCampo']['email']))
                                echo "<font color='red'>" . $erroresValidacion['marcaCampo']['email'] . "</font>";
                            ?>
                            <?php
                            if (isset($erroresValidacion['mensajesError']['email']))
                                echo "<font color='red'>" . $erroresValidacion['mensajesError']['email'] . "</font>";
                            ?>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">   
                            <select class="form-control" id="categoria_elementos_catEleId" name="rol">
                                <option value = "">Seleccionar</option>
                                <?php
                                for ($j = 0; $j < $cantRol; $j++) {
                                    ?>
                                    <option value = "<?php echo $roles[$j]->rolId; ?>"  > <?php echo $roles[$j]->rolId . " - " . $roles[$j]->rolNombre; ?></option>       
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">                   
                                <input class="form-control"  id="InputPassword" placeholder="Password" name="password" type="password" value=""  required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input class="form-control"  id="InputPassword2" placeholder="Confirmar Password" name="password2" type="password" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">              
                                <input class="form-control"  type="hidden" name="ruta" value="gestionDeRegistro">
                                <button class="btn btn-primary btn-lg btn-block" onclick="valida_registro()">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
<?php
if (isset($erroresValidacion))
    $erroresValidacion = NULL;
?>

