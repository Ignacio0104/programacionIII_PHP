Ignacio Smirlian

Aplicación No 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

<?php

$num = 29;
$mensaje;


switch ($num) {
    case 20:
        $mensaje = "Veinte";
        break;
    case 21:
        $mensaje = "Veintiuno";
        break;
    case 22:
        $mensaje = "Veintidos";
        break;
    case 23:
        $mensaje = "Veintitres";
        break;
    case 24:
        $mensaje = "Veinticuatro";
        break;
    case 25:
        $mensaje = "Veinticinco";
        break;
    case 26:
        $mensaje = "Veintiseis";
        break;
    case 27:
        $mensaje = "Veintisiete";
        break;
    case 28:
        $mensaje = "Veintiocho";
        break;
    case 29:
        $mensaje = "Veintinueve";
        break;
    case 30:
        $mensaje = "Treinta";
        break;
    case 31:
        $mensaje = "Treinta y uno";
        break;
    case 32:
        $mensaje = "Treinta y dos";
        break;
    case 33:
        $mensaje = "Treinta y tres";
        break;
    case 34:
        $mensaje = "Treinta y cuatro";
        break;
    case 35:
        $mensaje = "Treinta y cinco";
        break;
    case 36:
        $mensaje = "Treinta y seis";
        break;
    case 37:
        $mensaje = "Treinta y siete";
        break;
    case 38:
        $mensaje = "Treinta y ocho";
        break;
    case 39:
        $mensaje = "Treinta y nueve";
        break;
    case 40:
        $mensaje = "Cuarenta y uno";
        break;
    case 41:
        $mensaje = "Cuarenta y uno";
        break;
    case 42:
        $mensaje = "Cuarenta y dos";
        break;
    case 43:
        $mensaje = "Cuarenta y tres";
        break;
    case 44:
        $mensaje = "Cuarenta y cuatro";
        break;
    case 45:
        $mensaje = "Cuarenta y cinco";
        break;
    case 46:
        $mensaje = "Cuarenta y seis";
        break;
    case 47:
        $mensaje = "Cuarenta y siete";
        break;
    case 48:
        $mensaje = "Cuarenta y ocho";
        break;
    case 49:
        $mensaje = "Cuarenta y nueve";
        break;
    case 50:
        $mensaje = "Cincuenta";
        break;
    case 51:
        $mensaje = "Cincuenta y uno";
        break;
    case 52:
        $mensaje = "Cincuenta y dos";
        break;
    case 53:
        $mensaje = "Cincuenta y tres";
        break;
    case 54:
        $mensaje = "Cincuenta y cuatro";
        break;
    case 55:
        $mensaje = "Cincuenta y cinco";
        break;
    case 56:
        $mensaje = "Cincuenta y seis";
        break;
    case 57:
        $mensaje = "Cincuenta y siete";
        break;
    case 58:
        $mensaje = "Cincuenta y ocho";
        break;
    case 59:
        $mensaje = "Cincuenta y nueve";
        break;
    case 60:
        $mensaje = "Sesenta";
        break;
    default:
    $mensaje="Numero erróneo";
}

echo "<br><br><br>El numero es $mensaje";

?>