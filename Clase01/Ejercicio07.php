Ignacio Smirlian

Aplicación No 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.

<?php

$arrayImpares = array();
$numero=2;
$indice=0;


while($indice<10)
{
    if($numero%2!=0)
    {
        array_push($arrayImpares,$numero);
        //$arrayImpares[$indice] = $numero;
        $indice++;
    }
    $numero++;
}

echo "<br> Impresión con estructura FOR</br>";

for ($i=0;$i<count($arrayImpares);$i++)
{
    echo "$arrayImpares[$i]</br>";
}

echo "<br> Impresión con estructura FOREACH</br>";

foreach($arrayImpares as $valor)
{
    echo "$valor</br>";
}

echo "<br> Impresión con estructura WHILE</br>";

while(count($arrayImpares)>0)
{
    echo "<br>",array_shift($arrayImpares);
}

?>