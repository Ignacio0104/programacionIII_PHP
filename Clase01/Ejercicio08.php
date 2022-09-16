Ignacio Smirlian <br>

Aplicación No 8 (Carga aleatoria)
Imprima los valores del vector asociativo siguiente usando la estructura de control foreach: <br>
$v[1]=90; $v[30]=7; $v['e']=99; $v['hola']= 'mundo';<br>

<?php

$v = array(1=>90,30=>7,'e'=>99,'hola'=>'mundo');

foreach ($v as $clave => $valor)
{
    echo "<br> Elemento: ",$clave, " Valor: ", $valor;
}

?>