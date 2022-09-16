Ignacio Smirlian

Aplicación No 13 (Invertir palabra)
Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La
función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además
deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado.
0 en caso contrario.

<?php

function validarPalabra($palabra,$max)
{
    $listaPalabras = array("Recuperatorio","Parcial","Programacion");
    if(strlen($palabra)<$max)
    {
        foreach($listaPalabras as $valor)
        {
            if(strcmp($palabra,$valor)==0)
            {
                return 1;
            }
        }
        return 0;
    }
    return -1;
}

$resultado = validarPalabra("Programacion",30);
echo "<br> <br> <br>";
if($resultado==1)
{
    echo "La palabra está en la lista y respeta el tamaño maximo";
}else if($resultado==0)
{
    echo "La palabra NO está en la lista y respeta el tamaño maximo";
}else
{
    echo "La palabra NO respeta el tamaño maximo";
}

?>
