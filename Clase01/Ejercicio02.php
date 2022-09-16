Aplicación No 2 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.

<?php

echo "<br> La fecha actual es ",date("d/m/Y");
echo "<br> La fecha actual es ",date("d.m.Y");
echo "<br> La fecha actual es ",date("d.m.Y - h:i:sa");
echo "<br> La fecha actual es ",date("Y d m");
echo "<br> La fecha actual es ",date("m");

switch(date("m"))
{
    case "05":
    case "06":
    case "07":
    case "08":
        echo "<br> Estamos en invierno";
        break;
    case "09":
    case "10":
    case "11":
        echo "<br> Estamos en Primavera";
        break;
    case "09":
    case "10":
    case "11":
        echo "<br> Estamos en Primavera";
        break;
    case "12":
    case "01":
    case "02":
        echo "<br> Estamos en Verano";
        break;
    case "03":
    case "04":
        echo "<br> Estamos en Otono";
        break;
    
}
?>