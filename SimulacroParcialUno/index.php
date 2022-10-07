<?php

$listaDePizzas;
$listaDeVentas;

switch ($_SERVER["REQUEST_METHOD"]){
    case "POST":
        
        switch ($_POST["accion"]){
            case "pizzas":
                include_once "PizzaConsultar.php";
                break;
            case "ventas":
                include_once "AltaVenta.php";
                break;
            case "reportes":
                include_once "ConsultasVentas.php";
                break;
            case "altaPizzas":
                include_once "PizzaCarga.php";
        }
        break;
    case "PUT":
        include_once "ModificarVenta.php";
        break;
    case "DELETE":
        include_once "BorrarVenta.php";
    /*case "GET":
        include_once "PizzaCarga.php";      
        break;*/
}


?>