<?php
include_once "Pizza.php";
include_once "ManejoJSON.php";
include_once "Operaciones.php";

$listaDeJSON = ManejoJSON::LeerListaJSON("Pizza.json");
$listaDePizzas=array();

if($listaDeJSON!=null &&count($listaDeJSON)>0)
{
    foreach ($listaDeJSON as $pizzaJson) {
        $pizzaAuxiliar = new Pizza($pizzaJson["id"],$pizzaJson["sabor"],
        $pizzaJson["precio"],$pizzaJson["tipo"],$pizzaJson["cantidad"]);
        array_push($listaDePizzas,$pizzaAuxiliar);
    }
}

if(Operaciones::BuscarPizza($listaDePizzas,$_GET["sabor"],$_GET["tipo"])==null)
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

/*--------------------------------------------------------*/
ManejoJSON::GuardarListaJSON($listaDePizzas,"Pizza.json");

function CrearPizza($listaDePizzas,$sabor,$precio,$tipo,$cantidad)
{
    $pizzaAuxiliar = new Pizza(Operaciones::ConseguirIDMaximo($listaDePizzas,1000)+1,$sabor,$precio,$tipo,$cantidad);
    return $pizzaAuxiliar;
}



function ActualizarPizza ($pizza,$precio,$stock)
{
    $pizza->precio = $precio;
    $pizza->cantidad = $pizza->cantidad + $stock;
}



?>