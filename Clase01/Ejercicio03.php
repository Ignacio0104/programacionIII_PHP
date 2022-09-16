Ignacio Smirlian

Aplicación No 3 (Obtener el valor del medio)
Dadas tres variables numéricas de tipo entero $a, $b y $c realizar una aplicación que muestre
el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres
variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido.
Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”

<?php 

$a = 6;
$b = 8;
$c = -2;
$medio; 

echo "<br><br><br>Numero a: ", $a;
echo "<br>Numero b: ", $b;
echo "<br>Numero c: ", $c;

if($a>$b && $a<$c || $a<$b && $a>$c )
{
    $medio = $a;
}else if($b>$a && $b<$c ||$b<$a && $b>$c)
{
    $medio = $b;
}else if($c>$a&&$c<$b ||$c<$a&&$c>$b)
{
    $medio = $c;
}else
{
    $medio="No hay velor del medio";
}

echo "<br>El valor medio es: ", $medio;
?>