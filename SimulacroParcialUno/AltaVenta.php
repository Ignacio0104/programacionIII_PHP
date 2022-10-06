<?php
include_once "Venta.php";
include_once "Pizza.php";
include_once "ManejoJSON.php";

$listaDeJSON = ManejoJSON::LeerListaJSON("Pizza.json");
$listaDePizzas=array();
$listaDeVentas = array();
if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $pizzaJson) {
        $pizzaAuxiliar = new Pizza($pizzaJson["id"],$pizzaJson["sabor"],
        $pizzaJson["precio"],$pizzaJson["tipo"],$pizzaJson["cantidad"]);
        array_push($listaDePizzas,$pizzaAuxiliar);
    }
}
$listaDeJSON = ManejoJSON::LeerListaJSON("Ventas.json");
if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $ventaJson)
    {
        $ventaAuxiliar = new Venta ($ventaJson["id"],$ventaJson["mailUsuario"],
        $ventaJson["sabor"],$ventaJson["tipo"],$ventaJson["cantidad"],$ventaJson["numeroDePedido"],
    $ventaJson["fechaDePedido"]);
        array_push($listaDeVentas,$ventaAuxiliar);
    }
}

$ventaCreada = CrearVenta($listaDeVentas,$listaDePizzas,$_POST["mailUsuario"],$_POST["sabor"],
$_POST["tipo"],$_POST["cantidad"],$_POST["numeroPedido"]);
if($ventaCreada!=null){
    echo "Venta creada con exito\n";
    if($listaDeVentas == null)
    {
        $listaDeVentas= array();
    }
    $pizzaElegida = BuscarPizza($listaDePizzas,$_POST["sabor"],$_POST["tipo"]);
    if($pizzaElegida !=null)
    {
        $pizzaElegida->cantidad = $pizzaElegida->cantidad - $_POST["cantidad"];
    }
    array_push($listaDeVentas,$ventaCreada);
    ManejoJSON::GuardarListaJSON($listaDeVentas,"Ventas.json");
    ManejoJSON::GuardarListaJSON($listaDePizzas,"Pizza.json");
    
}else{
    echo "No se pudo crear la venta\n";
}

function CrearVenta($listaDeVentas,$listaDePizza,$mailUsuario,$sabor,$tipo,$cantidad, $numeroDePedido)
{
    $pizzaPedida = BuscarPizza($listaDePizza,$sabor,$tipo);
    if($pizzaPedida != null)
    {
        $ventaNueva = new Venta(Operaciones::ConseguirIDMaximo($listaDeVentas,0)+1,$mailUsuario,$sabor,$tipo,$cantidad,$numeroDePedido);
        return $ventaNueva;
    }
    return null;
}

?>