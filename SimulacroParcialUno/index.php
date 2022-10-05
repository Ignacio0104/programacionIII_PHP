<?php

$listaDePizzas;
$listaDeVentas;

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
                $listaDeVentas = LeerVentasListaJSON("Ventas.json");
                $listaDePizzas = LeerPizzasListaJSON("Pizza.json");
                $ventaCreada = CrearVenta($listaDeVentas,$listaDePizzas,$_POST["mailUsuario"],$_POST["sabor"],
                $_POST["tipo"],$_POST["cantidad"],$_POST["numeroPedido"]);
                if($ventaCreada!=null){
                    echo "Venta creada con exito\n";
                    $ventaCreada->Mostrar();
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
        $listaDePizzas = LeerPizzasListaJSON("Pizza.json");
        if($listaDePizzas == null){
            $listaDePizzas = array();
        }
        if(BuscarPizza($listaDePizzas,$_GET["sabor"],$_GET["tipo"])==null)
        {
            echo "La pizza no existe y la vamos a crear\n";
            $pizzaNueva = CrearPizza($listaDePizzas,$_GET["sabor"],$_GET["precio"],$_GET["tipo"],$_GET["cantidad"]);
            if($pizzaNueva==null){
                echo "No se pudo cargar la pizza\n";
            }else{
                array_push($listaDePizzas,$pizzaNueva);
            }        
        }else{
            echo "La pizza existe, actualizamos los datos\n";
            ActualizarPizza(BuscarPizza($listaDePizzas,$_GET["sabor"],$_GET["tipo"]),$_GET["precio"],$_GET["cantidad"]);
        }
        foreach ($listaDePizzas as $pizza) {
            $pizza->Mostrar();
            echo "\n";
        }
        GuardarListaPizzasJSON($listaDePizzas);
        break;
}


?>