<?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
    $mensaje = NULL;
}
?>
<section id="main-content">
    <section class="wrapper">
        <div>
            <h3 class="panel-title">Registrar</h3>
        </div>
        <div>
            <form method="POST" action="Controlador.php" id="formRegistro">
                <fieldset>
                    <div>
                        <input placeholder="Documento" name="documento" type="number" required="required" autofocus
                               value=<?php
                               if (isset($erroresValidacion['datosViejos']['documento']))
                                   echo "\"".$erroresValidacion['datosViejos']['documento']."\"";
                               if (isset($_SESSION['documento']))
                                   echo "\"".$_SESSION['documento']."\"";
                               unset($_SESSION['documento']);
                               ?>
                               >
                        <div>
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
                    <div>
                        <input placeholder="Nombres" name="nombre" type="text"   required="required"
                               value=<?php
                               if (isset($erroresValidacion['datosViejos']['nombre']))
                                   echo "\"".$erroresValidacion['datosViejos']['nombre']."\"";
                               if (isset($_SESSION['nombre'])){
                                   echo "\"".$_SESSION['nombre']."\"";
                               unset($_SESSION['nombre']);}
                               ?>
                               >
                        <div>
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
                    <div>
                        <input placeholder="Apellidos" name="apellidos" type="text"  required="required"
                               value=<?php
                               if (isset($erroresValidacion['datosViejos']['apellidos']))
                                   echo "\"".$erroresValidacion['datosViejos']['apellidos']."\"";
                               if (isset($_SESSION['apellidos'])){
                                   echo "\"".$_SESSION['apellidos']."\"";
                               unset($_SESSION['apellidos']);}
                               ?>
                               >
                        <div>
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
                    <div>
                        <input id="InputCorreo" placeholder="Correo Electrónico" name="email" type="email"  required="required"
                               value=<?php
                               if (isset($erroresValidacion['datosViejos']['email']))
                                   echo "\"".$erroresValidacion['datosViejos']['email']."\"";
                               if (isset($_SESSION['email'])){
                                   echo "\"".$_SESSION['email']."\"";
                               unset($_SESSION['email']);}
                               ?>
                               >
                        <div>
                               <?php
                               if (isset($erroresValidacion['marcaCampo']['email']))
                                   echo "<font color='red'>" . $erroresValidacion['marcaCampo']['email'] . "</font>";
                               ?>
                               <?php
                               if (isset($erroresValidacion['mensajesError']['email']))
                                   echo "<font color='red'>" . $erroresValidacion['mensajesError']['email'] . "</font>";
                               ?>
                        </div>
                    </div>
                    <div>
                        <input id="InputPassword" placeholder="Password" name="password" type="password" value=""  required="required">
                    </div>
                    <div>
                        <input id="InputPassword2" placeholder="Confirmar Password" name="password2" type="password" value="">
                    </div>
                    <input type="hidden" name="ruta" value="gestionDeRegistro">
                    <button onclick="valida_registro()">Registrar</button>
                </fieldset>
          <?php
                if (isset($erroresValidacion))
                    $erroresValidacion = NULL;
                ?>
            </form>
        </div>
</section>
</section>

