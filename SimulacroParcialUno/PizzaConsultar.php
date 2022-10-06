<?php

include_once "Pizza.php";
include_once "ManejoJSON.php";

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

if(BuscarPizzaPOST($listaDePizzas,$_POST["sabor"],$_POST["tipo"]))
{
    echo "Si hay!";
}else{
    echo "No existe el sabor o el tipo";
}

function BuscarPizzaPOST($listaDePizzas,$sabor,$tipo)
{
    if(count($listaDePizzas)>0){
        foreach ($listaDePizzas as $pizza)
        {
            if((strcmp($pizza->sabor,$sabor)==0)&&(strcmp($pizza->tipo,$tipo)==0))
            {
                return true;
            }
        }
    }
    return false;
}
?>