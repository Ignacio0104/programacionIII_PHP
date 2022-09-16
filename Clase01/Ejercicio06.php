Ignacio Smirlian

Aplicación No 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.

<?php

$arrayEnteros = array();
$acumulador=0;

for($i=0;$i<5;$i++)
{
    $arrayEnteros[$i]=rand(1,10);
    $acumulador+=$arrayEnteros[$i];
}

foreach($arrayEnteros as $valor)
{
    echo "<br>",$valor;
}

if($acumulador/5>6)
{
    echo "<br>El promedio es mayor a 6";
}else if($acumulador/5<6)
{
    echo "<br>El promedio es menor a 6";
}else 
{
    echo "<br>El promedio es igual a 6";
}

?>