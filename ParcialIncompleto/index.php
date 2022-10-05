<?php

$listaDePizzas=array();
$listaDeVentas = array();

switch ($_SERVER["REQUEST_METHOD"]){
    case "POST":
        include_once "PizzaConsultar.php";
        include_once "PizzaCarga.php";
        switch ($_POST["accion"]){
            case "pizzas":
                $listaDePizzas = LeerPizzasListaJSON("Pizza.json");
                echo BuscarPizzaPOST($listaDePizzas,$_POST["sabor"],$_POST["tipo"]);
                break;
            case "ventas":
                include_once "AltaVenta.php";
                //$listaDeVentas = LeerVentasListaJSON("Ventas.json");
                $listaDePizzas = LeerPizzasListaJSON("Pizza.json");
                $ventaCreada = CrearVenta($listaDeVentas,$listaDePizzas,$_POST["mailUsuario"],$_POST["sabor"],
                $_POST["tipo"],$_POST["cantidad"],$_POST["numeroPedido"]);
                if($ventaCreada!=null){
                    echo "Venta creada con exito";
                    $ventaCreada->Mostrar();
                }
                break;
        }
        break;
    case "GET":
        include_once "PizzaCarga.php";      
        $listaDePizzas = LeerPizzasListaJSON("Pizza.json");
        if($listaDePizzas == null){
            $listaDePizzas = array();
        }
        if(BuscarPizza($listaDePizzas,$_GET["sabor"],$_GET["tipo"])==null)
        {
            try{
                echo "La pizza no existe y la vamos a crear";
                $pizzaNueva = CrearPizza($listaDePizzas,$_GET["sabor"],$_GET["precio"],$_GET["tipo"],$_GET["cantidad"]);
                array_push($listaDePizzas,$pizzaNueva);
            }catch(Exception $ex){
                echo "No se pudo crear la pizza";
            }
        }else{
            ActualizarPizza(BuscarPizza($listaDePizzas,$_GET["sabor"],$_GET["tipo"]),$_GET["precio"],$_GET["cantidad"]);
        }
        foreach ($listaDePizzas as $pizza) {
            $pizza->Mostrar();
        }
        GuardarListaPizzasJSON($listaDePizzas);
        break;
}


?>