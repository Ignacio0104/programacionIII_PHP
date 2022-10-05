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
                $listaDeVentas = LeerVentasListaJSON("Ventas.json");
                $listaDePizzas = LeerPizzasListaJSON("Pizza.json");
                $ventaCreada = CrearVenta($listaDeVentas,$listaDePizzas,$_POST["mailUsuario"],$_POST["sabor"],
                $_POST["tipo"],$_POST["cantidad"],$_POST["numeroPedido"]);
                if($ventaCreada!=null){
                    echo "Venta creada con exito\n";
                    if($listaDeVentas == null)
                    {
                        $listaDeVentas= array();
                    }
                    array_push($listaDeVentas,$ventaCreada);
                    GuardarListaVentasJSON($listaDeVentas);
                }else{
                    echo "No se pudo crear la venta\n";
                }
                break;
        }
        break;
    case "GET":
        include_once "PizzaCarga.php";      
        break;
}


?>