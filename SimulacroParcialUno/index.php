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
        }
        break;
    case "GET":
        include_once "PizzaCarga.php";      
        break;
}


?>