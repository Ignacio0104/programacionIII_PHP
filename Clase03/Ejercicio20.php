<?php
/*Ignacio Smirlian 

Aplicacion 20

Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)
Realizar un constructor capaz de poder instanciar objetos pasándole como

parámetros: i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo). Ejemplo:
$miGarage->Remove($autoUno);
Crear un método de clase para poder hacer el alta de un Garage y, guardando los datos en un
archivo garages.csv.
Hacer los métodos necesarios en la clase Garage para poder leer el listado desde el archivo
garage.csv
Se deben cargar los datos en un array de garage.
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos
los métodos.
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

$autoCinco = new Auto("Verde","Renault","25000",new DateTime("1/17/2000"));
$autoSeis = new Auto("Blanco","Fiat","10000");
$autoSiete = new Auto("Violeta","Ford","60000",new DateTime("5/18/2015"));
$garageDos = new Garage("Garage Norte",50);

$garageDos->Add($autoCinco,$garageDos);
echo "<br>";
$garageDos->Add($autoSeis,$garageDos);
echo "<br>";
$garageDos->Add($autoSiete,$garageDos);
echo "<br>";
$garageDos->Add($autoTres,$garageDos);
echo "<br>";

$autoOcho = new Auto("Verde","Tesla","125000",new DateTime("1/20/2010"));
$autoNueve = new Auto("Gris","Fiat","12000");
$autoDiez= new Auto("Marron","Chevrolet","160000",new DateTime("5/12/2020"));
$garageTres = new Garage("Garage Oeste",40);

$garageTres->Add($autoOcho,$garageTres);
echo "<br>";
$garageTres->Add($autoNueve,$garageTres);
echo "<br>";
$garageTres->Add($autoDiez,$garageTres);
echo "<br>";
$garageTres->Add($autoTres,$garageTres);
echo "<br>";
/*
$garage->Remove($autoTres,$garage);
echo "<br>";
$garage->MostrarGarage();
echo "<br>";
$garage->Remove($autoSeis,$garage);
echo "<br>";*/

/*$arrayDeGarages = array();
array_push($arrayDeGarages,$garage);
array_push($arrayDeGarages,$garageDos);
array_push($arrayDeGarages,$garageTres);*/

//$garage->GuardarGarage($arrayDeGarages);
$arrayDeGarages = $garage->LeerGarages();

echo "Lectura de csv";
echo "<br>";

foreach($arrayDeGarages as $garage)
{
    echo "Informacion sobre Garage: ";
    echo "<br>";
    $garage->MostrarGarage();
}

?>