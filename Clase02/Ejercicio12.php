Ignacio Smirlian

Ejercicio 12:
Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
de las letras del Array.
Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.

<?php

function invertirOrdenLetras ($palabra)
{
    $ultimoIndice=count($palabra);
    $palabraInvertida ="";
    $i =0;
    while($ultimoIndice>0)
    {
        $palabraInvertida.=$palabra[$ultimoIndice-1];
        $i++;
        $ultimoIndice--;
    }

    return $palabraInvertida;
}

echo "<br> <br> <br> <br>", invertirOrdenLetras(array("H","O","L","A"));

?>