<?php
session_start();
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<script languaje='javascript'>alert('$mensaje')</script>";
    unset($_SESSION['mensaje']);
    $mensaje = NULL;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <script language="javascript">
            window.location.href = "principal.php";
        </script>
    </head>
    <body>

    </body>
</html>