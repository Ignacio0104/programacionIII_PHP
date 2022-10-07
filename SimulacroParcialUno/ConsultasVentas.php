<?php
include_once "Venta.php";
include_once "Pizza.php";
include_once "ManejoJSON.php";
include_once "Operaciones.php";

$listaDeJSON = ManejoJSON::LeerListaJSON("Pizza.json");
$listaDePizzas=array();
$listaDeVentas = array();
$listaDeVentasPorFecha = array();
$cantidadPizzasVendidas;
$fechaInicio=new DateTime($_POST["inicio"]);
$fechaFinal = new DateTime($_POST["final"]);
$cantidadPizzasVendidas = 0;
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
        $cantidadPizzasVendidas+=$ventaAuxiliar->cantidad;

        $fechaAuxiliar = new DateTime($ventaAuxiliar->fechaDePedido);

        if($fechaInicio < $fechaAuxiliar && $fechaAuxiliar < $fechaFinal)
        {
            array_push($listaDeVentasPorFecha,$ventaAuxiliar);
        }
        array_push($listaDeVentas,$ventaAuxiliar);
    }
}

echo "Se vendieron $cantidadPizzasVendidas pizzas\n";

usort($listaDeVentasPorFecha,"Operaciones::CompararSabores");
foreach ($listaDeVentasPorFecha as $item) {
   $item->Mostrar();
   echo "\n";
}

?>