<?php

echo "hola mundo ";
$nombre = "HENRY";
$apellido = "GARZON";
echo "</br>" . $nombre . " " . $apellido;
echo "<table border= 1px>";
echo "<tr>";
echo "<td>holaaaaa";
echo "</td>";
echo "<td>holaaaaa";
echo "</td>";
echo "</tr>";
echo "</table>";
//var_dump($apellido);
$cosas = array("pepe", 10.9, "Maria");
echo "$cosas[2]";
echo '</br>';
echo '<pre>';
print_r($cosas);
echo '</pre>';
$cuenta = count($cosas);

echo "<table border= 1px>";
echo "<tr>";
for ($i=0; $i < $cuenta; $i++) {
    echo "<td>".$cosas[$i] . '</td>';
}
echo "</tr>";
echo "</table>";
echo $_SERVER["DOCUMENT_ROOT"];
?>

<p>hola</p>
