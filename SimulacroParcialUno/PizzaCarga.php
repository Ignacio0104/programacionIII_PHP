<?php
include_once "Pizza.php";

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

function GuardarListaPizzasJSON ($arrayPizzas)
{
    $archivo = fopen("Pizza.json","w");
    $confirmacion = false; 
    
    if(fwrite($archivo,json_encode($arrayPizzas,JSON_PRETTY_PRINT). PHP_EOL)!=false)
    {
        $confirmacion = true;
    }  
    fclose($archivo);
    return $confirmacion;
}

function LeerPizzasListaJSON($nombreArchivo)
{
    if(file_exists($nombreArchivo))
    {
        $archivo = fopen($nombreArchivo,"r");
        $arrayAtributos = array();
        $arrayDePizzas = array();

            if(filesize($nombreArchivo)>0)
            {
                $json = fread($archivo,filesize($nombreArchivo));
                $arrayAtributos=json_decode($json,true);
                    
                if(!empty($arrayAtributos))
                {
                    foreach ($arrayAtributos as $pizzaJson)
                    {
                        $pizzaAuxiliar = new Pizza($pizzaJson["id"],$pizzaJson["sabor"],
                        $pizzaJson["precio"],$pizzaJson["tipo"],$pizzaJson["cantidad"]);
                        array_push($arrayDePizzas,$pizzaAuxiliar);
                    }
                }
                fclose($archivo);  
                return $arrayDePizzas;  
            }

    }else{
        echo "El archivo no existe\n";
    }   
}

function CrearPizza($listaDePizzas,$sabor,$precio,$tipo,$cantidad)
{
    $pizzaAuxiliar = new Pizza(ConseguirUltimoID($listaDePizzas)+1,$sabor,$precio,$tipo,$cantidad);
    return $pizzaAuxiliar;
}

function BuscarPizza($listaDePizzas,$sabor,$tipo)
{
    if(count($listaDePizzas)>0){
        foreach ($listaDePizzas as $pizza)
        {
            if((strcmp($pizza->sabor,$sabor)==0)&&(strcmp($pizza->tipo,$tipo)==0))
            {
                return $pizza;
            }
        }
    }
    return null;
}

function ActualizarPizza ($pizza,$precio,$stock)
{
    $pizza->precio = $precio;
    $pizza->cantidad = $pizza->cantidad + $stock;
}

function ConseguirUltimoID($listaDePizzas)
{
    $idMaxima = 1000;
    if(count($listaDePizzas)>0)
    {
        foreach ($listaDePizzas as $pizza)
        {
            if($pizza->id>$idMaxima)
            {
                $idMaxima =$pizza->id;
            }
        }
    }
    return $idMaxima;
}


?>