Ignacio Smirlian

Aplicación No 4 (Calculadora)
Escribir un programa que use la variable $operador que pueda almacenar los símbolos
matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.

<?php

$operador = '+';
$op1=4;
$op2=12;
$resultado;

switch($operador)
{
    case'+':
        $resultado=$op1 + $op2;
        break;
    case'-':
        $resultado=$op1 - $op2;
        break;
    case'*':
        $resultado=$op1 * $op2;
        break;
    case'/':
        if($op2 != 0)
        {
            $resultado=$op1 / $op2;
        }else
        {
            $resultado="No se puede dividir por cero";
        }
        break;
    default:
        $resultado="El operador ingresado en invalido";
}

echo "<br><br><br>El resultado de $op1 $operador $op2: $resultado";

?>