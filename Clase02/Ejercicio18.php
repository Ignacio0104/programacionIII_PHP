<?php
/*Ignacio Smirlian 

Aplicación No 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.
*/
include_once "ClaseAuto.php";
include_once "ClaseGarage.php";

echo "<br>";
echo "<br>";
$autoUno = new Auto("Negro","Fiat","30000",new DateTime("1/17/2006"));
$autoDos = new Auto("Azul","BMW","20000");
$autoTres = new Auto("Verde","Ford","40000",new DateTime("5/18/2018"));
$autoCuatro = new Auto("Negro","Jeep","30000",new DateTime("12/23/2012"));
$garage = new Garage("Garage Sur",26);
$autoSeis = new Auto("Negro","Fiat","30000",new DateTime("12/23/2012"));

$garage->Add($autoUno,$garage);
echo "<br>";
$garage->Add($autoDos,$garage);
echo "<br>";
$garage->Add($autoTres,$garage);
echo "<br>";
$garage->Add($autoCuatro,$garage);
echo "<br>";
$garage->Add($autoTres,$garage);
echo "<br>";

$garage->MostrarGarage();
echo "<br>";

$garage->Remove($autoTres,$garage);
echo "<br>";
$garage->MostrarGarage();
echo "<br>";
$garage->Remove($autoSeis,$garage);
echo "<br>";

?>